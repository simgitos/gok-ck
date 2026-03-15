<?php
session_start();
ob_start();
$pageTitle = 'Strony';

include('../config.php');
include('header.php');
//------------------------------------------------//

if ($_GET['cmd'] == 'zmenu') {
        if ($db->query("UPDATE $table SET pos='0' WHERE id=?", $_GET['id'])) {
                $_SESSION['alert'] = 'Poprawnie usunięto stronę z menu';
                header("Location: strony.php");
                exit();
        }
}
if ($_GET['cmd'] == 'domenu') {
       if($db->query("UPDATE $table SET pos='-3' WHERE id=?", $_GET['id'])){
        $_SESSION['alert'] = 'Poprawnie dodano stronę do menu';
                header("Location: strony.php");
                exit();
       }
}



if ($_GET['cmd'] == 'dodaj_strone') {
        dodaj();
} elseif ($_GET['cmd'] == 'dodaj_miniaturke') {
        dodaj_miniaturke();
} elseif ($_GET['cmd'] == 'usun_miniaturke') {
        usun_miniaturke();
} elseif ($_GET['cmd'] == 'pokaz_strony') {
        pokaz_strony();
} elseif ($_GET['cmd'] == 'edytuj_strone') {
        edytuj_strone_form($_GET['id']);
} elseif ($_GET['cmd'] == 'aktualizuj_strone') {
        aktualizuj_strone();
} elseif ($_GET['cmd'] == 'confirm_del') {
        confirm_del();
} elseif ($_GET['cmd'] == 'del_now') {
        del();
} else {
        pokaz_strony();
}
/////////////////

if ($_POST['sort']) {
        $i = 1;
        foreach ($_POST['element'] as $id) {
                $result = $db->query("UPDATE $table SET pos=? WHERE id=?", $i, $id);
                $i++;
        }
}
///////////////////



//------------------------------------------------//
include('footer.php');


function pokaz_strony()
{
        global $table, $db;

        $pagesInsideMenu = $db->query("SELECT * FROM $table WHERE pos <> '0' ORDER BY pos")->fetchAll();
        $pagesOutsideMenu = $db->query("SELECT * FROM $table WHERE pos = '0' ORDER BY pos")->fetchAll();


        include('views/strony/dodaj.php');
        include('views/strony/index.php');
}

function dodaj()
{
        global $db, $table;
        $name = seo($_POST['name']);

        if ($db->query("SELECT * FROM $table")->numRows() == 0) $name = 'index';

        $result = $db->query("SELECT * FROM $table WHERE name='$name'")->numRows();
        if ($result > 0) {
                $rand = rand(10, 990);
                $name = '' . $name . '_' . $rand . '';
        }

        $strona = $db->query(
                "INSERT INTO $table 
        (menu, name, title, naglowek)
        VALUES(?, ?, ?, ?)",
                $_POST['name'],
                $name,
                $_POST['name'],
                $_POST['name']
        )->lastInsertID();

        edytuj_strone_form($strona);
}

function edytuj_strone_form($id)
{
        global $table, $db, $img_table;


        $strona = $db->query("SELECT * FROM $table WHERE id=?", $id)->fetchArray();

        //switch
        if ($strona['pos'] <> '0') $switch = 'value="' . $strona['pos'] . '" checked';
        else {
                $switch = 'value="-3"';
        }

        //typ strony
        $options = ['index', 'blog', 'linki', 'sub'];
        $typeOptions = '';
        foreach ($options as $option) {
                $sel = ($strona['type'] == $option) ? ' selected' : '';
                $typeOptions .= '<option value="' . $option . '" ' . $sel . '>' . $option . '</option>';
        }
        //podmnenu
        $menuCategory = '<option value="" >Kategoria główna</option>';

        $submenus = $db->query("SELECT * FROM $table WHERE submenu='' ORDER BY pos desc")->fetchAll();
        foreach ($submenus as $submenu) {
                $sel = ($strona['submenu'] == $submenu['id']) ? ' selected' : '';

                $menuCategory .= '<option value="' . $submenu['id'] . '" ' . $sel . '>' . $submenu['menu'] . '</option>';
        }

        //galeria
        $pageGalery = '<option value="" >Bez galerii</option>';

        $galeries = $db->query("SELECT DISTINCT dir FROM $img_table ORDER BY id desc")->fetchAll();
        foreach ($galeries as $galery) {
                $sel = ($strona['dirs'] == $galery['dir']) ? ' selected' : '';

                $pageGalery .= '<option value="' . $galery['dir'] . '" ' . $sel . '>' . $galery['dir'] . '</option>';
        }

        ///////////////////////

        include('views/strony/edit.php');
}


function aktualizuj_strone()
{
        global $table, $db;


        $name = seo($_POST['name']);


        if (empty($_POST['menu']) || empty($_POST['title']) || empty($name)) {
                echo 'Nie wypełniłeś wymaganych pól<br>[<a href="javascript:history.back(1)">wstecz</a>]';
        } else {
                $query = "UPDATE $table SET pos=?, menu=?, name=?, title=?, naglowek=?, type=?, text1=?, submenu=?, dirs=? WHERE id=?";
                if ($db->query($query, $_POST['pos'], $_POST['menu'], $name, $_POST['title'], $_POST['naglowek'], $_POST['type'], $_POST['text1'], $_POST['submenu'], $_POST['dirs'], $_POST['id'])) {

                        $_SESSION['alert'] = 'Poprawnie zapisano stronę';
                        header("Location: strony.php");
                        exit();
                } //if
        } //else
} //function

function foldery_galerii()
{
        global $dirs;

        echo '<option value="">Bez galerii</option>';
        $handle = opendir('../galeria');
        while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {

                        echo '<option value="' . $file . '"';
                        echo ' ' . $dirs . '';
                        echo '>' . $file . '</option>';
                } // if file
        } // while
        closedir($handle);
} //function



function confirm_del()
{

        global $db, $table;

        $page = $db->query("SELECT menu FROM $table WHERE id=?", $_GET['id'])->fetchArray();

        echo 'Czy jestes pewien, że chcesz usunąć stronę <b>' . $page['menu'] . '</b>?';
        echo '<h3><a href="strony.php?cmd=del_now&id=' . $_GET['id'] . '">TAK</a> <a href="strony.php?cmd=pokaz_strony">NIE</a></h3>';
}

function del()
{

        global $db, $table;

        if ($db->query("DELETE FROM $table WHERE id=? LIMIT 1", $_GET['id'])) {

                $_SESSION['alert'] = 'Poprawnie usunięto stronę';
                header("Location: strony.php");
                exit();
        }
}


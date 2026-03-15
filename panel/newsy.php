<?php
session_start();
ob_start();

$pageTitle = 'Posty';

include('../config.php');
include('header.php');
//------------------------------------------------//



// $result  = $db->query("INSERT INTO $news_table VALUES('', '', ?, NOW(), '', '', NOW(), '')", $_POST['name']);
// if ($result) {
//         $idn = $db->lastInsertID();
//         header('Location: newsy.php?cmd=edit_news_form&id=' . $idn . '');
//         exit;
// }


if ($_GET['cmd'] == 'news') {
        news();
} elseif ($_GET['cmd'] == 'dodaj_miniaturke') {
        dodaj_miniaturke();
} elseif ($_GET['cmd'] == 'usun_miniaturke') {
        usun_miniaturke();
} elseif ($_GET['cmd'] == 'add_news') {
        add_news();
} elseif ($_GET['cmd'] == 'confirm_del_news') {
        confirm_del_news();
} elseif ($_GET['cmd'] == 'del_news') {
        del_news();
} elseif ($_GET['cmd'] == 'edit_news') {
        edit_news($_GET['id']);
} elseif ($_GET['cmd'] == 'update') {
        update_news();
} else news();


//------------------------------------------------//
include('footer.php');

function news()
{
        global $news_table, $db;

        $newsy = $db->query("SELECT * FROM $news_table ORDER BY od DESC")->fetchAll();

        include('views/news/add.php');
        include('views/news/index.php');
}

function add_news()
{
        global $db, $news_table;

        $db->query("INSERT INTO $news_table (title_news, date_added, od) VALUES(?, NOW(), NOW())", $_POST['name']);

        $idn = $db->lastInsertID();
        edit_news($idn);
}
function edit_news($id)
{
        global $news_table, $db, $img_table;

        $news = $db->query("SELECT * FROM $news_table WHERE id=?", $id)->fetchArray();


        $newsGalery = '<option value="" >Bez galerii</option>';

        $galeries = $db->query("SELECT DISTINCT dir FROM $img_table ORDER BY id desc")->fetchAll();
        foreach ($galeries as $galery) {
                $sel = ($news['galery_news'] == $galery['dir']) ? ' selected' : '';

                $newsGalery .= '<option value="' . $galery['dir'] . '" ' . $sel . '>' . $galery['dir'] . '</option>';
        }

        include('views/news/edit.php');
}



function update_news()
{
        global $news_table, $db;

        if (empty($_POST['title_news'])) {
                echo 'Nie wypełniłeś wymaganych pól<br>[<a href="javascript:history.back(1)">wstecz</a>]';
                exit;
        } else {
                if ($db->query(
                        "UPDATE $news_table SET title_news=?, text_news=?, od=?, do=?, galery_news=? WHERE id=?",
                        $_POST['title_news'],
                        $_POST['text_news'],
                        $_POST['od'],
                        $_POST['do'],
                        $_POST['galery_news'],
                        $_POST['id']
                )) {

                        $_SESSION['alert'] = 'Poprawnie zapisano posta';
                        header("Location: newsy.php");
                        exit();
                }
        }
} //function

function dodaj_miniaturke()
{
        global $_quality_, $_width_max_;
        $id_strony = $_GET['id_strony'];
        $_width_min_ = 600;
        $plik = $_FILES['plik']['tmp_name'];
        $plik_name = $_FILES['plik']['name'];
        $plik_type = $_FILES['plik']['type'];
        $plik_size = $_FILES['plik']['size'];

        ini_set("memory_limit", "32M");

        if (is_uploaded_file($plik)) {

                if ($plik_size > 1607200) { //300KB
                        echo 'Podany plik jest zbyt duży';
                        exit;
                }



                if ($plik_type !== 'image/jpeg') {
                        echo 'System obsługuje tylko pliki jpg';
                        exit;
                }


                $fid = 'news-' . $id_strony . '.jpg';
                move_uploaded_file($plik, "../temp/$fid");

                echo '<br />Zdjęcie załadowano poprawnie <br /><br />';

                
                        $max_szer = $_width_min_;


                $stary = "../temp/$fid";

                $rozmiar = GetImageSize($stary);
                $szer = $rozmiar[0];
                $wys = $rozmiar[1];

                if ($szer <= $max_szer) {
                        $nowa_szer = $szer;
                        $nowa_wys = $wys;
                } else {
                        $wsp_x = $max_szer / $szer;
                        $nowa_szer = $max_szer;
                        $nowa_wys = ceil($wsp_x * $wys);
                }

                $org = imagecreatefromjpeg($stary);
                $min = ImageCreateTrueColor($nowa_szer, $nowa_wys);
                imagecopyresampled($min, $org, 0, 0, 0, 0, $nowa_szer, $nowa_wys, $szer, $wys);
                imagedestroy($org);
                imagejpeg($min, "../pliki/miniaturki/$fid", 80);
                imagedestroy($min);
                unlink($stary);

                $_SESSION['alert'] = 'Poprawnie dodano miniaturkę';
                header("Location: newsy.php");
                exit();
        } else {
                echo 'Wybierz zdjęcie miniaturki:

<form action="newsy.php?cmd=dodaj_miniaturke&id_strony=' . $_GET['id_strony'] . '" method="post" enctype="multipart/form-data">
<input type="file" name="plik"> <br>
<input type="submit" name="Submit" value="Dodaj"> <br />

</form>';
        }
}

function usun_miniaturke()
{


        if (unlink('../pliki/miniaturki/news-' . $_GET['id_strony'] . '.jpg'))
       
        $_SESSION['alert'] = 'Usunięto miniaturkę'; 
        header("Location: newsy.php");
        exit();
}


function foldery_galerii()
{ //
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




function confirm_del_news()
{ //

        global $news_table, $db;


        $news = $db->query("SELECT * FROM $news_table WHERE id=?", $_GET['id'])->fetchArray();

        echo 'Czy jestes pewien, że chcesz usunąć newsa <b>' . $news['title_news'] . '</b>?<br>';
        echo '<h3><a href="newsy.php?cmd=del_news&id=' . $_GET['id'] . '" class="btn btn-danger">TAK</a> <a href="newsy.php"> NIE</a></h3>';
}

function del_news()
{

        global $news_table, $db;


        if ($db->query("DELETE FROM $news_table WHERE id=? LIMIT 1", $_GET['id'])) {
                unlink('../pliki/miniaturki/news-' . $_GET['id'] . '.jpg');
                
                $_SESSION['alert'] = 'Poprawnie usunięto posta'; 
                header("Location: newsy.php");
                exit();
        }
}

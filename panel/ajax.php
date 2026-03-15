<?
session_start();
//header('Content-type: text/html; charset=UTF-8');

//$_POST['opis']=iconv('utf-8','iso-8859-2',$_POST['opis']);




include('../config.php');

switch ($_POST['funkcja']) {

    case 'opis':
        opis();
        break;
    case 'link':
        links();
        break;
    case 'usun_zdj':
        usun_zdj();
        break;
}


function opis()
{
    global $img_table, $db;
    if ($db->query("UPDATE $img_table SET opis=? WHERE id=? LIMIT 1", $_POST['opis'], $_POST['id']))
        echo "Opis zmieniony";
}
function links()
{
    global $img_table, $db;
    if ($db->query("UPDATE $img_table SET link=? WHERE id=? LIMIT 1", $_POST['link'], $_POST['id']))
        echo "Link zmieniony";
}
function pozycja()
{
    global $img_table, $db;
    if ($db->query("UPDATE $img_table SET pos=? WHERE id=? LIMIT 1", $_POST['pos'], $_POST['id']))
        echo 'Pozycja zmieniona na ' . $_POST['pos'];
}

function usun_zdj()
{
    global $img_table, $db;
    unlink('../galeria/' . $_POST['dir'] . '/galeria_' . $_POST['id'] . '.jpg');
    unlink('../galeria/' . $_POST['dir'] . '/mini/galeria_' . $_POST['id'] . '.jpg');
    $db->query("DELETE FROM $img_table WHERE id=? AND dir=? LIMIT 1", $_POST['id'], $_POST['dir']);
}

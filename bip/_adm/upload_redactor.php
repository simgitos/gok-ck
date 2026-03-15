<?php
session_start();
// files storage folder
$dir = '../pliki/';


$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

if ($_FILES['file']['type'] == 'image/png'
|| $_FILES['file']['type'] == 'image/jpg'
|| $_FILES['file']['type'] == 'image/gif'
|| $_FILES['file']['type'] == 'image/jpeg'
|| $_FILES['file']['type'] == 'image/pjpeg')
{
    // setting file's mysterious name

 $plikk = md5(date('YmdHis')).'.jpg';
    $file = $dir.$plikk;
    // copying
    move_uploaded_file($_FILES['file']['tmp_name'], "$file");

    // displaying file
    $array = array(
        'filelink' => 'https://gok-ck.pl/bip/pliki/'.$plikk
    );

    echo stripslashes(json_encode($array));
}

?>

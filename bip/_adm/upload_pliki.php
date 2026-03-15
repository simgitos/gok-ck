<?php
session_start();
// files storage folder
$dir = '../pliki/';

$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

if ($_FILES['file']['type'] == 'application/pdf')
{
    // setting file's mysterious name
    $plikk = md5(date('YmdHis')).'.pdf';
    $file = $dir.$plikk;

    // copying
    move_uploaded_file($_FILES['file']['tmp_name'], "$file");

    // displaying file
    $array = array(
        'filelink' => 'https://gok-ck.pl/bip/pliki/'.$plikk
    );

    echo stripslashes(json_encode($array));
}
if ($_FILES['file']['type'] == 'application/msword')
{
    // setting file's mysterious name
    $plikk = md5(date('YmdHis')).'.doc';
    $file = $dir.$plikk;

    // copying
    move_uploaded_file($_FILES['file']['tmp_name'], "$file");

    // displaying file
    $array = array(
        'filelink' => 'https://gok-ck.pl/bip/pliki/'.$plikk
    );

    echo stripslashes(json_encode($array));
}
if ($_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
{
    // setting file's mysterious name
    $plikk = md5(date('YmdHis')).'.docx';
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

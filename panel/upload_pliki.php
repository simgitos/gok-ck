<?php
session_start();
// files storage folder
$dir = '/pliki/';

$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

if ($_FILES['file']['type'] == 'application/pdf')
{
    // setting file's mysterious name
    $file = $dir.md5(date('YmdHis')).'.pdf';

    // copying
    move_uploaded_file($_FILES['file']['tmp_name'], "../$file");

    // displaying file
    $array = array(
        'filelink' => $file
    );

    echo stripslashes(json_encode($array));
}
if ($_FILES['file']['type'] == 'application/msword')
{
    // setting file's mysterious name
    $file = $dir.md5(date('YmdHis')).'.doc';

    // copying
    move_uploaded_file($_FILES['file']['tmp_name'], "../$file");

    // displaying file
    $array = array(
        'filelink' => $file
    );

    echo stripslashes(json_encode($array));
}
if ($_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
{
    // setting file's mysterious name
    $file = $dir.md5(date('YmdHis')).'.docx';

    // copying
    move_uploaded_file($_FILES['file']['tmp_name'], "../$file");

    // displaying file
    $array = array(
        'filelink' => $file
    );

    echo stripslashes(json_encode($array));
}
?>

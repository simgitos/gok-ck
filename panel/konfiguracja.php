<?php
session_start();
ob_start();
$pageTitle = 'Konfiguracja';

include('../config.php');
include('header.php');
//------------------------------------------------//

if (!empty($_POST['ok'])) {

    $query = "UPDATE _admin SET site_title=?, keywords_strony=?, mail=?, haslo=?, opis_strony=? WHERE login=? LIMIT 1";

    if ($result = $db->query($query, $_POST['site_title'], $_POST['keywords_strony'], $_POST['mail'], $_POST['haslo'], $_POST['opis_strony'], $_SESSION['login_strona'])) {
        $_SESSION['alert'] = 'Poprawnie zapisano konfigurację';
        header("Location: konfiguracja.php");
        exit();
    }

} else {

    $config = $db->query(
        "SELECT * FROM _admin WHERE login=?",
        $_SESSION['login_strona']
    )
        ->fetchArray();

    include('views/configure/form.php');
}




//------------------------------------------------//
include('footer.php');

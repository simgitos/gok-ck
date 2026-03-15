<?php
session_start();
ob_start();
$pageTitle = 'Użytkownik';

include('../config.php');
include('header.php');
//------------------------------------------------//

if (!empty($_GET['cmd']) && $_GET['cmd'] === 'update' && !empty($_POST['haslo'])) {

    if ($_POST['haslo'] !== $_POST['haslo2']) {
        $_SESSION['alert'] = 'Hasła nie są takie same!!!';
		header("Location: user.php");
		exit(); 
    } else {
        if ($db->query("UPDATE _admin SET haslo=? WHERE login=? LIMIT 1", $_POST['haslo'], $_SESSION['login_strona']))
        $_SESSION['alert'] = 'Hasło zostało zmienione';
		header("Location: user.php");
		exit(); 
    }
} 
    include('views/user/form.php');


//------------------------------------------------//
include('footer.php');

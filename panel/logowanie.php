<?
session_start();
include_once('../config.php');


if (isset($_GET['wyloguj'])) {
    $_SESSION['access_strona'] = 'no';
    session_destroy();
    header("Location: logowanie.php");
    exit;
}



if (!isset($_POST['cmd']) || $_POST['cmd'] !== 'logowanie') {
    include('views/logowanie/form.php');
    exit;
}


if (!isset($_POST['log'], $_POST['has'])) {
    showLoginForm("Błąd: Nieprawidłowy login lub hasło.");
}


$query = $db->query("SELECT id, url, haslo FROM _admin WHERE login = ?", trim($_POST['log']));
$r = $query->fetchArray();

if (!$r) {
    showLoginForm("Błąd: Nieprawidłowy login lub hasło.");
}

// Weryfikacja hasła (zakładając, że są zapisane jako `password_hash`)
//if (!password_verify($_POST['has'], $r['haslo'])) {
if($_POST['has'] <> $r['haslo']){

    showLoginForm("Błąd: Nieprawidłowy login lub hasło.");
}


$_SESSION['access_strona'] = true;
$_SESSION['login_strona'] = $_POST['log'];
$_SESSION['url'] = $r['url'];
$_SESSION['id'] = $r['id'];

header("Location: index.php");
exit;


function showLoginForm($error = '') {
    include('views/logowanie/form.php'); // Wczytuje plik formularza
    
    exit;
}
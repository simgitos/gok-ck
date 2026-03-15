<?
session_start();
include('../__conf.php');

function logout()
{

    $_SESSION['ad'] = '';
    $_SESSION['up'] = '';
    $_SESSION['Pimie'] = '';
    $_SESSION['Pnazwisko'] = '';
    $_SESSION['ml'] = '';
    $_SESSION['ps'] = '';
    header('Location: /bip/_adm/');
}



function logowanie()
{
    global $baza;
    $_POST['haslo'] = md5($_POST['haslo']);
    // echo 'a' .$_POST['haslo'] ;exit;
    $res = $baza->query("SELECT * FROM _users WHERE Email = ? AND Haslo = ?", $_POST['mail'], $_POST['haslo']);
    //   print_r($res);
    //       //  echo $r[Imie];
    if ($res->numRows() == 1) {
        $r = $res->fetchArray();

        $_SESSION['ad'] = $r['Id'];
        $_SESSION['up'] = $r['Uprawnienia'];
        $_SESSION['Pimie'] = $r['Imie'];
        $_SESSION['Pnazwisko'] = $r['Nazwisko'];
        $_SESSION['ml'] = $r['Email'];
        $_SESSION['ps'] = $r['Haslo'];
        add_log('Poprawne logowanie');
        echo 'Poprawne logowanie';
        header('Location: /bip/_adm');
    } else {
        add_log('Niepoprawne logowanie');
        header('Location: /bip/_adm/');
        login_form();
    }
}



if (!empty($_GET['cmd']) and $_GET['cmd'] == 'logout') logout();
elseif ($_POST['co'] == 'Logowanie') logowanie();
else login_form();

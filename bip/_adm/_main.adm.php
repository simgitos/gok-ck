<?
session_start();
function is_login()
{
    global $baza;
    if (!isset($_SESSION['ml']) || !isset($_SESSION['ps']) || !isset($_SESSION['up'])) return 'no';
    else {
        
    $res = $baza->query("SELECT * FROM _users WHERE Email = ? AND Haslo = ? AND Uprawnienia = ?", $_SESSION['ml'], $_SESSION['ps'], $_SESSION['up']);

   if ($res->numRows() == 1)  return $ret = 'yes';
    }
}


function login_form()
{
    echo '<div class="col-md-7"><h2>Logowanie do panelu</h2>

    <form method="post" action="login.adm.php">
    <b>E-mail</b><input type="text" name="mail" value="" class="form-control" required/>
    <b>Hasło</b><input type="password" name="haslo" value="" class="form-control" required/>
    <input type="submit" name="co" value="Logowanie" class="form-control btn btn-success"/>
    </form> ';
    echo '<a href="../">Przejdź do strony głównej</a></div>';
}

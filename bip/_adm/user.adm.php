<?
include('../__conf.php');
include('_main.adm.php');



function edycja($id)
{
  global $baza;



  $r = $baza->query("SELECT * FROM _users WHERE Id = ?", $id)->fetchArray();


  if (isset($_POST['co']) && $_POST['co'] == 'aktualizacja') {
    if ($_POST['haslo'] <> '' and $_POST['_haslo'] <> '') {

      if ($_POST['haslo'] == $_POST['_haslo']) {
        $has = md5($_POST['haslo']);
        $hass = ", Haslo='$has'";
      } else {
        $hass = '';
        echo '<h3>Nie mogliśmy zmienić hasła</h3>';
      }
    }
    $baza->query(
      "UPDATE _users SET Imie = ?, Nazwisko = ?, Email=?, Uprawnienia=?, Aktywne=? $hass WHERE Id=?",
      $_POST['imie'],
      $_POST['nazwisko'],
      $_POST['email'],
      $_POST['uprawnienia'],
      $_POST['aktywne'],
      $id

    );

    echo '<h3>Zaktualizowano dane użytkownika</h3>';
    //add_log('Edycja użytkownika '.$_POST[imie].' '.$_POST[nazwisko].'');
  } else {
    if ($r['Uprawnienia'] == 'A') $u1 = 'selected';
    else $u1 = '';
    if ($r['Uprawnienia'] == 'R') $u2 = 'selected';
    else $u2 = '';
    if ($r['Aktywne'] == '1') $a1 = 'selected';
    else $a1 = '';
    if ($r['Aktywne'] == '0') $a2 = 'selected';
    else $a2 = '';

    echo '<h2>Edycja użytkownika ' . $r['Imie'] . ' ' . $r['Nazwisko'] . ' </h2>
    <form method="post" action="user.adm.php?id=' . $id . '&cmd=edycja">
    <b>Imię</b><input type="text" name="imie" value="' . $r['Imie'] . '" class="form-control" required/>
    <b>Nazwisko</b><input type="text" name="nazwisko" value="' . $r['Nazwisko'] . '" class="form-control" required/>
    <b>E-mail</b><input type="text" name="email" value="' . $r['Email'] . '" class="form-control" required/><b>Uprawnienia</b>
    <select name="uprawnienia" class="form-control" required>
    <option value="">Określ uprawnienia</option>
    <option value="A" ' . $u1 . '>Administrator</option>
    <option value="R" ' . $u2 . '>Redaktor</option>
    </select>
    <b>Konto</b>
    <select name="aktywne" class="form-control" required>
    <option value="1" ' . $a1 . '>Konto aktywne</option>
    <option value="0" ' . $a2 . '>Konto nieaktywne</option>
    </select>

    <hr>
    <b>Hasło (pozostaw wolne jeśli nie wymaga zmiany)</b><input type="password" name="haslo" value="" class="form-control" />
    <b>Powtórz hasło (pozostaw wolne jeśli nie wymaga zmiany)</b><input type="password" name="_haslo" value="" class="form-control" />
    <input type="submit" name="co" value="aktualizacja" class="form-control btn btn-success"/>
    </form> ';
  }
}


function dodaj()
{
  global $baza;
  if ($_POST['co'] == 'dodaj') {
    $baza->query("INSERT INTO _users VALUES('', '', '', ?, '', '', NOW(), ?, '0', NOW(), NOW())", $_POST['email'], $_SERVER['REMOTE_ADDR']);
    $id = $baza->lastInsertId();
    edycja($id);
  }
}


function tresc()
{
  global $baza;
  if (is_login() == 'yes') {

    if ($_SESSION['up'] == 'A') {

      if (isset($_GET['cmd']) && $_GET['cmd'] == 'dodaj') dodaj();


      if (isset($_GET['cmd']) && $_GET['cmd'] == 'edycja') {
        edycja($_GET['id']);
      }



      echo '<h1>Administratorzy</h1>';

      echo '   <table class="table table-hover">
     <tr>
     <td><b>Data utworzenia</b></td><td><b>Administrator</b></td><td><b>Uprawnienia</b></td><td><b>Aktywny</b></td><td><b>Akcje</b></td></tr>';
      $res = $baza->query("SELECT * FROM _users ORDER BY Id ASC")->fetchAll();
      foreach ($res as $r) {


        echo ' <tr><td>' . $r['DataU'] . '</td><td>' . $r['Imie'] . ' ' . $r['Nazwisko'] . '<br />' . $r['Email'] . '</td><td>' . $r['Uprawnienia'] . '</td><td>' . $r['Aktywne'] . '</td><td><a href="user.adm.php?cmd=edycja&id=' . $r['Id'] . '" class="btn btn-info">Edycja</a></td></tr>';
      }

      echo '</table>
     <div class="well">
 <form method="post" action="user.adm.php?cmd=dodaj">
    <b>Dodaj nowego użytkownika</b><input type="text" name="email" value="" class="form-control" placeholder="E-mail nowego użytkownika" required/>
    <input type="submit" name="co" value="dodaj" class="form-control btn btn-success"/>
    </form>
    </div>
  ';
    } else echo 'Nie masz uprawnień do przeglądania tej strony';
  } else login_form();
}
include('_szab.adm.php');

<?
include('../__conf.php');
include('_main.adm.php');

function lista()
{
      global $baza;
      echo '<h2>Aktualności</h2>
<div class="well">
 <form method="post" action="newsy.adm.php?cmd=dodaj">
    <b>Dodaj nową wiadomość</b><input type="text" name="tytul" value="" class="form-control" placeholder="Tytuł wiadomości" required/>
    <input type="submit" name="co" value="dodaj" class="form-control btn btn-success"/>
    </form>
    </div>
  ';
      $res = $baza->query("SELECT * FROM _news WHERE Usuniete = 0 AND Aktualna = 1 ORDER BY System DESC, Id DESC ")->fetchAll();

      foreach ($res as $r) {
            if ($r['Aktywne'] == 0) $pub = '<a href="newsy.adm.php?cmd=publikuj&id=' . $r['Id'] . '" class="btn btn-primary right">[Publikuj]</a>';
            else $pub = '';

            echo '<h3><a href="newsy.adm.php?id=' . $r['Id'] . '">' . $r['Tytul'] . '</a><br /><small>
   ' . $pub . '<a href="newsy.adm.php?cmd=edit&id=' . $r['Id'] . '" class="btn btn-success right">[Edycja] </a><a href="newsy.adm.php?cmd=delete&id=' . $r['Id'] . '" class="btn btn-danger right">[Usuń]</a></small></h3>';
            echo $r['Lid'];
            echo '<hr>';
      }
}

function news($id)
{
      global $baza;
      $r = $baza->query("SELECT * FROM _news WHERE Id = ? AND Usuniete = 0 AND Aktualna = 1 ", $id)->fetchArray();



      echo '<h2>' . $r['Tytul'] . '<br /><small>' . $r['DataU'] . '</small></h2>';
      echo $r['Tresc'];
      echo '<hr>';
      echo '<div class="well small">
   Liczba wyświetleń strony: <b>' . $r['V'] . '</b><br />
   Opublikował: <b>' . $r['Pimie'] . ' ' . $r['Pnazwisko'] . '</b><br />
   Data utworzenia: <b>' . $r['DataU'] . '</b> <br />
   Historia edycji:  <br />
   </div>';
}

function dodaj()
{
      global $baza;
      if ($_POST['co'] == 'dodaj') {
            $r = $baza->query(
                  "INSERT INTO _news VALUES('', 1, ?, '', '', '', '0', NOW(), '', '1', '0','0', '1', ?, ?, '0', '', '', ?)",

                  $_POST['tytul'],
                  $_SESSION['Pimie'],
                  $_SESSION['Pnazwisko'],
                  $_SESSION['ad']
            );


            $id = $r->lastInsertID();
            $baza->query("UPDATE _news SET System = ? WHERE Id=?", $id, $id);
            
            add_log('Dodanie newsa ' . $_POST['tytul']);
            edit_news($id);
      }
}

function edit_news($id)
{
      global $baza;



      $r = $baza->query("SELECT * FROM _news WHERE Id = ? AND Usuniete = 0 AND Aktualna = 1 ", $id)->fetchArray();


      if (isset($_POST['co']) and $_POST['co'] == 'aktualizacja') {

            if ($r['Aktywne'] == 1) {
                  $baza->query("UPDATE _news SET Aktualna = 0 WHERE System = ?", $r['System']);

                  $baza->query(
                        "INSERT INTO _news VALUES('', ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, 1, ?, ?, ?, ?, ?, ?)",
                        $r['System'],
                        $_POST['tytul'],
                        $r['Title'],
                        $_POST['lid'],
                        $_POST['tresc'],
                        $r['Aktywne'],
                        $r['DataU'],
                        $r['Druk'],
                        $r['PDF'],
                        $r['V'],
                        $_SESSION['Pimie'],
                        $_SESSION['Pnazwisko'],
                        $r['Usuniete'],
                        $_POST['powod'],
                        $r['DataDel'],
                        $_SESSION['ad']


                  );
            } else $baza->query("UPDATE _news SET Tytul = ?, Lid = ?, Tresc=? WHERE Id=?", $_POST['tytul'], $_POST['lid'], $_POST['tresc'], $id);

            echo 'Zaktualizowano';
            add_log('Aktualizacja newsa '.$_POST['tytul']);
      } else {

            if ($r['Aktywne'] == 1) $pow = '<b>Powód zmiany</b><textarea name="powod" class="form-control" rows="2" required></textarea>';
            else $pow = '';
            echo '<h2>Edycja ' . $r['Tytul'] . '<br /><small>' . $r['DataU'] . '</small></h2>
    <form method="post" action="newsy.adm.php?id=' . $id . '&cmd=edit">
    <b>Tytuł</b><input type="text" name="tytul" value="' . $r['Tytul'] . '" class="form-control" required/>
    <b>Zajawka</b><textarea name="lid" class="form-control" rows="5" required>' . strip_tags($r['Lid']) . '</textarea>
    <b>Treść</b><textarea name="tresc" class="form-control" id="redactor_content" required>' . $r['Tresc'] . '</textarea>
    ' . $pow . '

    <input type="submit" name="co" value="aktualizacja" class="form-control btn btn-success"/>
    </form> ';




            echo '<hr>';
            echo '<div class="well small">
   Liczba wyświetleń strony: <b>' . $r['V'] . '</b><br />
   Opublikował: <b>' . $r['Pimie'] . ' ' . $r['Pnazwisko'] . '</b><br />
   Data utworzenia: <b>' . $r['DataU'] . '</b> <br />
   Historia edycji:  <br />
   </div>';
      }
}
function delete_news($id)
{
      global $baza;
      $baza->query("UPDATE _news SET Aktywne=0, Usuniete = 1, DataDel = NOW() WHERE Id=?", $id);
      echo 'Usunięto poprawnie';

      add_log('Usunięcie newsa ' . $id . '');
}
function publikuj_news($id)
{
      global $baza;
      $baza->query("UPDATE _news SET Aktywne=1, DataU = NOW() WHERE Id=?", $id);

      echo 'Publikacja pomyślna';
      add_log('Publikacja newsa ' . $id . '');
}


function tresc()
{
      if (is_login() <> 'yes') {
            login_form();
      } else {

            if (isset($_GET['id']) and !isset($_GET['cmd'])) news($_GET['id']);
            elseif (isset($_GET['cmd']) and $_GET['cmd'] == 'dodaj') dodaj();
            elseif (!empty($_GET['id']) and $_GET['cmd'] == 'edit') edit_news($_GET['id']);
            elseif (isset($_GET['id']) and $_GET['cmd'] == 'delete') delete_news($_GET['id']);
            elseif (isset($_GET['id']) and $_GET['cmd'] == 'publikuj') publikuj_news($_GET['id']);
            else lista();
      }
}


include('_szab.adm.php');

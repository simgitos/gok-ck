<?
include('__conf.php');

function lista()
{
      global $baza;
      echo '<h2>Aktualności:</h2> <hr>  ';

      $res = $baza->query("SELECT * FROM _news WHERE Aktywne = 1 AND Usuniete = 0 AND Aktualna = 1 ORDER BY System DESC, Id DESC ")->fetchAll();
      foreach ($res as $r) {

            echo '<h3><a href="index.php?id=' . $r['Id'] . '">' . $r['Tytul'] . '</a><br /><small>' . $r['DataU'] . '</small></h3>';
            echo $r['Lid'];
            echo '<hr>';
      }
}

function news($id)
{
      global $baza;
      licznik('_news', $id);
      $r = $baza->query("SELECT * FROM _news WHERE Id = ? AND Aktywne = 1 AND Usuniete = 0 AND Aktualna = 1 ", $id)->fetchArray();

      if (!empty($r) && is_array($r)) {
           


            echo '<h2>' . $r['Tytul'] . '<br /><small>' . $r['DataU'] . '</small></h2>';
           // echo '<p>' . $r['Lid'] . '</p>';
            echo $r['Tresc'];

            echo '<hr>';

            echo '<div class="well small">
   <a href="druk.php?druk=news&id=' . $id . '" target="_blank"><b>Wersja do druku</b></a> <br />
   Liczba wyświetleń strony: <b>' . $r['V'] . '</b><br />
   Opublikował: <b>' . $r['Pimie'] . ' ' . $r['Pnazwisko'] . '</b><br />
   Data utworzenia: <b>' . $r['DataU'] . '</b> <br />
   Historia edycji:  <br />
   </div>';
      } else {
            // Zmienna nie istnieje lub nie jest tablicą
            echo '<h2>Nie znaleziono artykułu</h2>';
      }
}


function tresc()
{
      if (!empty($_GET['id'])) news($_GET['id']);
      else lista();
}


include('_szab.php');

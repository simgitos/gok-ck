<?
include('__conf.php');



function strona($id){
      global $baza;
      licznik('_strony', $id);
$r = $baza->query("SELECT * FROM _strony WHERE Id = ? AND Aktywne = 1 AND Usuniete = 0 AND Aktualna = 1 ", $id)->fetchArray();



echo '<h2>'.$r['Tytul'].'<br /><small>'.$r['DataD'].'</small></h2>';
   echo $r['Tresc'];
   
   echo '<hr>';
   echo '<div class="well small">
   <a href="druk.php?druk=strona&id='.$id.'" target="_blank"><b>Wersja do druku</b></a> <br />
   Liczba wyświetleń strony: <b>'.$r['V'].'</b><br />
   Opublikował: <b>'.$r['Pimie'].' '.$r['Pnazwisko'].'</b><br />
   Data utworzenia: <b>'.$r['DataD'].'</b> <br />
   Historia edycji:  <br />
   </div>';

}


function tresc(){
 if($_GET['id']) strona($_GET['id']);
 else echo 'Nie ma takiej strony';
}


include('_szab.php');
?>

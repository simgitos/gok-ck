<?
include('../__conf.php');
include('_main.adm.php');

function lista(){
      global $baza;
echo '<h2>Strony</h2>
<div class="well">
 <form method="post" action="strony.adm.php?cmd=dodaj">
    <b>Dodaj nową Stronę</b><input type="text" name="tytul" value="" class="form-control" placeholder="Tytuł Strony" required/>
    <input type="submit" name="co" value="dodaj" class="form-control btn btn-success"/>
    </form>
    </div>
  ';
$res = $baza->query("SELECT * FROM _strony WHERE Usuniete = 0 AND Aktualna = 1 ORDER BY System DESC, Id DESC ")->fetchAll();

foreach ($res as $r) {
   if($r['Aktywne'] == 0) $pub = '<a href="strony.adm.php?cmd=publikuj&id='.$r['Id'].'" class="btn btn-primary right">[Publikuj]';
   else $pub = '';

   echo '<h3><a href="strony.adm.php?id='.$r['Id'].'">'.$r['Tytul'].'</a><br /><small>
   '.$pub.'</a><a href="strony.adm.php?cmd=edit&id='.$r['Id'].'" class="btn btn-success right">[Edycja] </a><a href="strony.adm.php?cmd=delete&id='.$r['Id'].'" class="btn btn-danger right">[Usuń]</a></small></h3>';
   //echo $r['Lid'];
   echo '<hr>';
      }
}

function news($id){
      global $baza;
$r = $baza->query("SELECT * FROM _strony WHERE Id = ? AND Usuniete = 0 AND Aktualna = 1 ", $id)->fetchArray();




echo '<h2>'.$r['Tytul'].'<br /><small>'.$r['DataD'].'</small></h2>';
   echo $r['Tresc'];
   echo '<hr>';
   echo '<div class="well small">
   Liczba wyświetleń strony: <b>'.$r['V'].'</b><br />
   Opublikował: <b>'.$r['Pimie'].' '.$r['Pnazwisko'].'</b><br />
   Data utworzenia: <b>'.$r['DataD'].'</b> <br />
   Historia edycji:  <br />
   </div>';

}

function dodaj(){
   global $baza;
   if($_POST[co]=='dodaj'){
   mysqli_query($baza, "INSERT INTO _strony VALUES(
   '',
   '',
   '".esc($_POST[tytul])."',
   '',
   '',
   '',
   '0',
   '',
   '',
   '',
   '1',
   '',
   '',
   '1',
   '',
   '',
   '".esc($_SESSION[Pimie])."',
   '".esc($_SESSION[Pnazwisko])."',
   NOW(),
   '',
   '0',
   '',
   '',
   '".esc($_SESSION[ad])."'
   )");
       $id = mysqli_insert_id($baza);
    mysqli_query($baza, "UPDATE _strony SET System = '".esc($id)."' WHERE Id='".esc($id)."'");
    
 edit_news($id);
  }
}

function edit_news($id){
      global $baza;



$res = mysqli_query($baza, "SELECT * FROM _strony WHERE Id = '".esc($id)."' AND Usuniete = 0 AND Aktualna = 1 ");
$r = mysqli_fetch_array($res);

 if($_POST[co]=='aktualizacja'){

       if($r[Aktywne]==1){
     mysqli_query($baza, "UPDATE _strony SET Aktualna = 0 WHERE System = '$r[System]'");


     mysqli_query($baza, "INSERT INTO _strony VALUES(
     '',
     '$r[System]',
     '".esc($_POST[tytul])."',
     '$r[Title]',
     '".esc($_POST[tresc])."',
     '$r[Parent]',
     '$r[Aktywne]',
     '$r[Kolejnosc]',
     '$r[Typ]',
     '$r[Menu]',
     '$r[Druk]',
     '$r[PDF]',
     '$r[V]',
     1,
     '".esc($_SESSION[Pimie])."',
     '".esc($_SESSION[Pnazwisko])."',
     '$r[Pimie]',
     '$r[Pnazwisko]',
     '$r[DataD]',
     NOW(),
     '$r[Usuniete]',
     '".esc($_POST[powod])."',
     '$r[DataDel]',
     '$r[Dodal]')");


       }else mysqli_query($baza, "UPDATE _strony SET Tytul = '".esc($_POST[tytul])."', Tresc='".esc($_POST[tresc])."' WHERE Id='".esc($id)."'");
  add_log('Aktualizacja strony '.$_POST[tytul].'');
  echo 'Zaktualizowano';
 }
 else{

   if($r[Aktywne]==1) $pow = '<b>Powód zmiany</b><textarea name="powod" class="form-control" rows="2" required></textarea>';
echo '<h2>Edycja '.$r[Tytul].'<br /><small>'.$r[DataU].'</small></h2>
    <form method="post" action="strony.adm.php?id='.$id.'&cmd=edit">
    <b>Tytuł</b><input type="text" name="tytul" value="'.$r[Tytul].'" class="form-control" required/>
    <b>Treść</b><textarea name="tresc" class="form-control" id="redactor_content" required>'.$r[Tresc].'</textarea>
    '.$pow.'
    kolejnosc
    <input type="submit" name="co" value="aktualizacja" class="form-control btn btn-success"/>
    </form> ';




   echo '<hr>';
   echo '<div class="well small">
   Liczba wyświetleń strony: <b>'.$r[V].'</b><br />
   Opublikował: <b>'.$r[Pimie].' '.$r[Pnazwisko].'</b><br />
   Data utworzenia: <b>'.$r[DataD].'</b> <br />
   Historia edycji:  <br />
   </div>';
   }

}
function delete_news($id){
      global $baza;
$res = mysqli_query($baza, "UPDATE _strony SET Aktywne=0, Usuniete = 1, DataDel = NOW() WHERE Id='".esc($id)."'");



}
function publikuj_news($id){
      global $baza;
$res = mysqli_query($baza, "UPDATE _strony SET Aktywne=1, DataD = NOW() WHERE Id='".esc($id)."'");
//$r = mysqli_fetch_array($res);
echo 'Publikacja pomyślna';
add_log('Publikacja strony '.$id.'');
}


function tresc(){
      if(is_login()<>'yes'){login_form();}else {
      
 if(isset($_GET['id']) AND !isset($_GET['cmd'])) news($_GET['id']);
//  elseif($_GET[cmd]=='dodaj') dodaj();
//  elseif($_GET[id] AND $_GET[cmd]=='edit') edit_news($_GET[id]);
//  elseif($_GET[id] AND $_GET[cmd]=='delete') delete_news($_GET[id]);
//  elseif($_GET[id] AND $_GET[cmd]=='publikuj') publikuj_news($_GET[id]);
 else lista();
 }
}


include('_szab.adm.php');
?>

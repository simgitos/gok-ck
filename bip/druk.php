<?
include('__conf.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>BIP GOK & CK w Lipniku</title>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
 <?

function strona($id){
      global $baza;




$r = $baza->query("SELECT * FROM _strony WHERE Id = ? AND Aktywne = 1 AND Usuniete = 0 AND Aktualna = 1 ", $id)->fetchArray();



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

function news($id){
      global $baza;
      //licznik('_news', $id);     url='".esc($_GET[url])."'
$r = $baza->query("SELECT * FROM _news WHERE Id = ? AND Aktywne = 1 AND Usuniete = 0 AND Aktualna = 1 ", $id)->fetchArray();


echo '<div class="container"><h2>'.$r['Tytul'].'<br /><small>'.$r['DataU'].'</small></h2>';
   echo $r['Tresc'];
   echo '<hr>';
   echo '<div class="well small">
   Liczba wyświetleń strony: <b>'.$r['V'].'</b><br />
   Opublikował: <b>'.$r['Pimie'].' '.$r['Pnazwisko'].'</b><br />
   Data utworzenia: <b>'.$r['DataU'].'</b> <br />
   Historia edycji:  <br />
   </div>
   </div>';

}



if($_GET['id']){
 if($_GET['druk'] == 'news') news($_GET['id']);
 if($_GET['druk'] == 'strona') strona($_GET['id']);
}
 
 else lista();
?>

</body>
</html>

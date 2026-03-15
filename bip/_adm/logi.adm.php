<?
include('../__conf.php');
include('_main.adm.php');
function tresc(){
global $baza;
     if(is_login()=='yes' ){
     if(isset($_SESSION['up']) && $_SESSION['up']=='A'){
      echo '<h1>Logi</h1>';

  echo '   <table class="table table-hover">
     <tr>
     <td><b>Data</b></td><td><b>Administrator</b></td><td><b>Opis</b></td><td><b>IP/Host</b></td></tr>';
    $res = $baza->query("SELECT * FROM _logi ORDER BY Id DESC")->fetchAll();
foreach($res as $r){


    echo ' <tr><td>'.$r['DataL'].'</td><td>'.$r['Imie'].' '.$r['Nazwisko'].'<br />'.$r['Email'].'</td><td>'.$r['Tresc'].'</td><td>'.$r['URL'].'<br />'.$r['Host'].'</td></tr>';
     }

     echo '</table>  ';
     }else echo 'Nie masz uprawnień do przeglądania tej strony';

      }else login_form();
      }
include('_szab.adm.php');
?>

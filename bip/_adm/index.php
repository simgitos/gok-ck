<?


include('../__conf.php');
include('_main.adm.php');
function tresc(){
     if(is_login()=='yes'){
      echo '<h1>Panel Administracyjny BIP</h1>';
      }else login_form();
      }
include('_szab.adm.php');
?>

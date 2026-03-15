<?

function menu(){
      global $baza;

$res = $baza->query("SELECT * FROM _strony WHERE Aktywne = 1 AND Usuniete = 0 AND Aktualna = 1 AND Menu = 1 ORDER BY Kolejnosc ASC ")->fetchAll();
 echo '<ul class="nav nav-pills nav-stacked">
 <li role="presentation" class="active"><a href="/bip">Aktualności</a></li>
 ';
foreach($res as $r) {
      
   echo '<li role="presentation"><a href="strona.php?id='.$r['Id'].'">'.$r['Tytul'].'</a></li>';

      }
      echo '</ul>  ';
}

function licznik($co, $id){
      global $baza;
$baza->query("UPDATE $co SET V=V+1 WHERE Id=?", $id);
}

// function esc($esc){
//       global $baza;
// $esc = mysqli_real_escape_string($baza, $esc);
// return $esc;
// }

function add_log($tresc){
   global $baza;
   
$url = getenv("REMOTE_ADDR");
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   
    $baza->query("INSERT INTO _logi VALUES('', ?, ?, ?, NOW(), ?, 0, ?, ?)", 
$_SESSION['Pimie'],
$_SESSION['Pnazwisko'],
$_SESSION['ml'],
$tresc,
$_SERVER['REMOTE_ADDR'],
$host
);

}

?>

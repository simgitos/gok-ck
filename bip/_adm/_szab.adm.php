<?
//session_start();
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
  <style>
    .wrapp {
      min-height: 200px;
      background: url(../img/a.png) no-repeat scroll;
      background-position: 50% 0;
      background-size: cover;
      background-color: #186dbf;
      color: white;
    }

    .thumbnail {
      display: inline;
    }

    .footer {
      /* position: absolute; */
      /* bottom: 0; */
      width: 100%;
      height: 60px;
      background-color: #f5f5f5;
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="wrapp">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3>Gminny Ośrodek Kultury we Włostowie<br />Centrum Kształcenia w Lipniku</h3>
          <br /><img src="../img/lipnik.png" class="thumbnail " style="max-height:100px;">
          <img src="../img/bip.png" class="thumbnail " style="max-height:100px;">
        </div>
      </div>
    </div>
  </div>

  <div class="container">


    <? if (is_login() == 'yes') {
      echo '<div class="well">
         Jesteś zalogowany jako:  <b>' . $_SESSION['Pimie'] . ' ' . $_SESSION['Pnazwisko'] . '</b>
         <a href="/bip/_adm/login.adm.php?cmd=logout" class="btn btn-danger">Wyloguj się</a></div>';
    }
    ?>


    <div class="row panel">

      <? if (is_login() == 'yes') {
        echo '

  <div class="col-md-4">
<ul class="nav nav-pills nav-stacked">
 <li role="presentation" class="active"><a href="/bip/_adm">Strona główna Administracji</a></li>
 <li role="presentation" class="active"><a href="/bip/_adm/newsy.adm.php">Aktualności</a></li>
 <li role="presentation" class="active"><a href="/bip/_adm/strony.adm.php">Strony</a></li>
 <li role="presentation" class="active"><a href="/bip/_adm/user.adm.php">Użytkownicy</a></li>
 <li role="presentation" class="active"><a href="/bip/_adm/logi.adm.php">Logi</a></li>
  </ul>
  </div>
  ';
      }
      ?>

      <div class="col-md-8">

        <?
        tresc();
        ?>



      </div>
    </div>


  </div>


  <footer class="footer footer-inverse">
    <div class="container">
      <p class="text-muted text-right">igama.pl</p>
    </div>
  </footer>















  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" href="js/redactor.css" />
  <script src="js/redactor.min.js"></script>
  <script type="text/javascript" src="js/pl.js"></script>
  <script src="js/fontcolor.js"></script>
  <script type="text/javascript">
    $(document).ready(
      function() {
        $('#redactor_content').redactor({
          convertDivs: false,
          lang: 'pl',
          MinHeight: 500,
          pastePlainText: true,
          imageUpload: 'upload_redactor.php',
          shortcuts: false,
          imageGetJson: false,
          toolbarFixed: true,
          plugins: ['fontcolor'],
          autoresize: true,
          fileUpload: 'upload_pliki.php'
        })

      }
    );
  </script>


  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
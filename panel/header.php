<?php
session_start();

if (empty($_SESSION['access_strona'])) {
  header("Location: logowanie.php"); // Przekierowanie na stronę logowania
  exit;
}

?>


<!doctype html>
<html lang="pl">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="igama.pl">

  <title>Panel administracyjny</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" type="text/css" href="style.css" />
  <script src="js/jquery-1.9.0.min.js"></script>
  <!-- <script type="text/javascript" src="js/jquery-ui-1.10.4.min.js"></script> -->

  <script src="js/redactor/redactor.min.js"></script>
  <script type="text/javascript" src="js/redactor/pl.js"></script>
  <link rel="stylesheet" href="js/redactor/redactor.css" />
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
          autoresize: true,
          fileUpload: 'upload_pliki.php'
        })

      }
    );
  </script>


  <!--  <link rel="stylesheet" type="text/css" href="a/style.css">
<script type="text/javascript" src="a/mootools.js"></script>
<script type="text/javascript" src="a/calendar.js"></script>//-->
  <!-- <script>
    function przepisz() {
      if (!document.form.name.value) {
        document.form.name.value = document.form.menu.value;
        document.form.title.value = document.form.menu.value;
        document.form.naglowek.value = document.form.menu.value;
      } else {
        document.form.name.value = '';
        document.form.title.value = '';
        document.form.naglowek.value = '';
      }
    }
  </script> -->
  <link href="uploadfile.css" rel="stylesheet">
  <script src="jquery.uploadfile.js"></script>
  <script src="jquery.form.js"></script>



  <meta name="theme-color" content="#712cf9">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="dashboard.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
</head>

<body>

  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="<?= SITE_URL ?>" target="_blank">Strona główna</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <? if (isset($_SESSION['alert'])) : ?>
      <div class="alert alert-warning alert-dismissible fade show my-1 py-2 form-control" role="alert">
        <?= $_SESSION['alert'] ?>
      </div>
      <script>
        setTimeout(() => document.querySelector(".alert").remove(), 4000);
      </script>
    <? unset($_SESSION['alert']);
    endif; ?>

    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="logowanie.php?wyloguj=yes">Wyloguj się</a>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3 sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">

                <i class="bi bi-speedometer2 me-2"></i>Panel

              </a>
            </li>
            <hr>
            <li class="nav-item">
              <a class="nav-link" href="strony.php?cmd=pokaz_strony">

                <i class="bi bi-collection me-2"></i>Strony
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="newsy.php?cmd=news">

                <i class="bi bi-pin-angle me-2"></i>Posty
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="galeria.php?cmd=news"><i class="bi bi-pin-angle me-2"></i>Galeria</a>
            </li>


            <li>
              <a class="nav-link collapsed dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="collapse" data-bs-target="#addon-collapse" aria-expanded="false">
                <i class="bi bi-plug me-2"></i>Dodatki
              </a>
              <ul class="collapse  list-unstyled ps-5" id="addon-collapse" aria-labelledby="navbarDropdown">
                <li class="dropdown-item"><a class="nav-link" href="sidebar.php">Sidebar</a></li>
                <li class="dropdown-item"><a class="nav-link" href="galeria.php?cmd=pliki&dir=_slider">Slider</a></li>
              </ul>
            </li>


            <li class="nav-item">
              <a class="nav-link" href="konfiguracja.php">
                <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                <i class="bi bi-sliders me-2"></i>Konfiguracja
              </a>
            </li>

            <hr>
            <li class="nav-item">
              <a class="nav-link" href="pay.php">
                <span data-feather="file-text" class="align-text-bottom"></span>
                <i class="bi bi-currency-dollar me-2"></i>Rozliczenia
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user.php">
                <span data-feather="file-text" class="align-text-bottom"></span>
                <i class="bi bi-person me-2"></i>Użytkownik
              </a>
            </li>


          </ul>
          <div class="fixed-bottom m-2 text-start">

            <a href="https://www.igama.pl">GAMA</a> &copy 2007-<?= date('Y') ?> v. 6.10 Beta


          </div>

        </div>


      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2"><?= $pageTitle ?></h1>
          <!-- <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar" class="align-text-bottom"></span>
              This week
            </button>
          </div> -->
        </div>
        <!-- 
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->
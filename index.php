<?
session_start();

if (!empty($_GET['font']) <> '') {
    $_SESSION['font'] = $_GET['font'];
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '');
    exit;
}
if (!empty($_GET['kontrast'] <> '')) {
    if ($_GET['kontrast'] == 'no') {
        $_SESSION['kontrast'] = '';
        $_SESSION['font'] = '';
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '');
    } else
        $_SESSION['kontrast'] = $_GET['kontrast'];
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '');
    exit;
}
include('config.php');
include('funkcje.php');
?>

<!doctype html>
<html lang="pl">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="style2.css" type="text/css" media="screen" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title><?= x(SITE_TITLE) ?> - <?= x($title) ?></title>
    <meta name="Description" content="<?= x($descr); ?>" />

</head>

<body class="kontrast">
    <header>
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light border-1 border-bottom border-dark shadow"
            aria-label="Eighth navbar example">
            <div class="container">
                <a class="navbar-brand animate__animated animate__pulse " href="<?= SITE_URL ?>">
                    <h1><img src="pliki/logo.png" class="img-fluid" alt="Logo <?= SITE_TITLE ?>"></h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample07">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <? navbar(); ?>
                    </ul>

                </div>
                <div class="text-end">
                    <a href="https://www.facebook.com/gokwlostowicklipnik" class="btn btn-primary text-white"
                        target="_blank"><i class="bi bi-facebook"></i></a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        title="Ustawienia dostępności"><i class="fa fa-wheelchair"></i>
                    </button>
                </div>
            </div>
        </nav>

    </header>
    <main>



        <?

        if (empty($_GET['name']) && empty($_GET['news']) && empty($_GET['blog'])):

            fullslider(); ?>
            <section id="oddzialy" class="pasek bg-dark">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 text-light">


                            <div class="row g-4d px-3 py-5 row-cols-1 row-cols-lg-3">
                                <div class="col d-flex my-2 align-items-start">
                                    <div>
                                        <h6 class=" text-uppercase fw-bold text-white">
                                            Oferujemy
                                        </h6>
                                        <ul class="nav flex-column ">
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Zajęcia
                                                    muzyczne</a></li>
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Zajęcia
                                                    plastyczne</a></li>
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Zajęcia
                                                    ruchowe</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col d-flex my-2 align-items-start">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">
                                            Imprezy
                                        </h6>
                                        <ul class="nav flex-column ">
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Biesiada
                                                    Świętojańska</a></li>
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Dożynki
                                                    Gminne</a></li>
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Imprezy
                                                    okolicznościowe</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col d-flex my-2 align-items-start">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">
                                            Oddziały
                                        </h6>
                                        <ul class="nav flex-column ">
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Gminny
                                                    Ośrodek Kultury we Włostowie</a></li>
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Centrum
                                                    kształcenia w Lipniku</a></li>
                                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0  text-light">Świetlica
                                                    Usarzów</a></li>
                                        </ul>
                                    </div>
                                </div>


                            </div>





                        </div>
                        <div class="col-md-4 bg-warning p-4">
                            <h3>Film promocyjny</h3>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/796GFK07CFk?rel=0" frameborder="0"
                                    allowfullscreen></iframe>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        <?php else: ?>
            <section id="top" class=" bg-dark py-4">
                &nbsp;
                </div>
            </section>
        <? endif; ?>


        <section id="main">
            <div class="container">
                <div class="row">

                    <div class="col-md-8 p-5">
                        <?
                        if (isset($_GET['name'])) {
                            strony($_GET['name']);
                        } elseif (isset($_GET['news'])) {
                            news($_GET['news']);
                        } elseif (isset($_GET['blog'])) {
                            blog($_GET['blog']);
                        } else {

                            strony('index');
                            last_post();
                            // calendar();
                        
                        }
                        //}
                        ?>




                    </div>
                    <div class="content col-md-4 bg-light p-3 border pt-5 ">
                        <? sidebar() ?>
                    </div>
                </div>
            </div>
        </section>




    </main>
    <? include('views/app/footer.php'); ?>
</body>

</html>
<?
if ($_SESSION['font'] <> '')
    echo ' <style>       body { font-size: ' . x($_SESSION['font']) . 'rem; } </style>';
if ($_SESSION['kontrast'] == 'bw')
    echo ' <style>      .kontrast, .nav-link, a, h1, h2, h3 { background-color: white!important; color:black!important; font-weight:600;}  a {text-decoration:underline;}</style>';
if ($_SESSION['kontrast'] == 'by')
    echo ' <style>       .kontrast, .nav-link, a, h1, h2, h3 { background-color: black!important; color:yellow!important; font-weight:600;}
  a {text-decoration:underline;
  }</style>';
if ($_SESSION['kontrast'] == 'gr')
    echo ' <style>      .kontrast { filter: grayscale(100%);}</style>';
?>
<?php
session_start();
$pageTitle = 'Rozliczenia';

include('../config.php');
include('header.php');
//------------------------------------------------//

$uslugi = $db->query("SELECT * FROM uslugi WHERE firma=?", $_SESSION['id'])->fetchAll();
include('views/pay/index.php');

//------------------------------------------------//
include('footer.php');
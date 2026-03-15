<?php
session_start();
$pageTitle = 'Panel administracyjny';

include('../config.php');
include('header.php');
//------------------------------------------------//
$pages = $db->query("SELECT id FROM $table")->numRows();
$posts = $db->query("SELECT id FROM $news_table")->numRows();
$images = $db->query("SELECT id FROM $img_table")->numRows();

include('views/home/index.php');

//------------------------------------------------//
include('footer.php');

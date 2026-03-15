<?php

//Definiowanie stałych
$mainConfiguration = $db->query("SELECT * FROM _admin WHERE login = ?", $prefix)->fetchArray();
if(!empty($mainConfiguration['width_max'])) DEFINE('WIDTH_MAX', $mainConfiguration['width_max']); else DEFINE('WIDTH_MAX', 700);
if(!empty($mainConfiguration['width_min'])) DEFINE('WIDTH_MIN', $mainConfiguration['width_min']); else DEFINE('WIDTH_MIN', 300);
if(!empty($mainConfiguration['width_slider'])) DEFINE('WIDTH_SLIDER', $mainConfiguration['width_slider']); else DEFINE('WIDTH_SLIDER', 1000);
DEFINE('SITE_TITLE', $mainConfiguration['site_title']);
DEFINE('SITE_URL', $mainConfiguration['url']);




//filtrowanie $_GET
$_GET = array_map(function($wartosc) {
    return htmlspecialchars(strip_tags($wartosc), ENT_QUOTES, 'UTF-8');
}, $_GET);

//slugi
function seo($doseo)
{
	$text = iconv('UTF-8', 'ASCII//TRANSLIT', $doseo);
	$text = preg_replace('/[^a-zA-Z0-9]+/', '_', $text);
	return strtolower($text);
}


//filtrowanie zmiennej przed wyswietleniem
function x($data)
{
	return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}


function dd($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
	exit;
}

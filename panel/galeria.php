<?
session_start();
ob_start();
$pageTitle = 'Galeria ';
include('../config.php');
include('header.php');
//---------------------------
require './vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

//------------------------------------------------//

if ($_GET['cmd'] == 'rm_dir') {
	rm_dir();
	echo '<br /><br />';
	pokaz_dir();
} elseif ($_GET['cmd'] == 'add_dir') {
	add_dir();
	pokaz_dir();
} elseif ($_GET['cmd'] == 'aktualizuj_dir') {
	aktualizuj_dir();
} elseif ($_GET['cmd'] == 'pliki') {
	pokaz();
} elseif ($_GET['cmd'] == 'pokaz_dir') {
	add_dir();
	pokaz_dir();
} else pokaz_dir();

//------------------------------------------------//
include('footer.php');




function pokaz_dir()
{ //
	global $db, $img_table, $table, $news_table;

	include('views/galery/add.php');

	$dir = '../galeria/';

	if ($d = opendir($dir)) {
		$pliki = array();
		while ($f = readdir($d)) {
			if ($f != '_slider' && $f != '.ftpquota' && $f != '_pliki' && $f != '_zamowienia' && $f != '_slider' && $f != '_losowe' && $f != '.' && $f != '..' && !is_dir($f)) {
				$pliki[$f] = filectime($dir . $f);
			}
		}
	}

	arsort($pliki);
	reset($pliki);

	if (is_dir('../galeria/_losowe')) $folders[] = ['nazwa' => '_losowe', 'czas' => null, 'str' => ''];

	foreach ($pliki as $nazwa => $czas) {
		$str = '';
		$a = $db->query("SELECT title FROM $table WHERE dirs=?", $nazwa)->fetchAll();
		foreach ($a as $rr) {
			$str .= 'Strona: ' . $rr['title'] . ' <br />';
		}
		$b = $db->query("SELECT title_news FROM $news_table WHERE galery_news=?", $nazwa)->fetchAll();
		foreach ($b as $rr2) {
			$str .= 'News: ' . $rr2['title_news'] . '<br />';
		}
		$folders[] = ['nazwa' => $nazwa, 'czas' => $czas, 'str' => $str];
	}

	include('views/galery/index.php');
}

function aktualizuj_dir()
{ //
	global $img_table, $db;


	$akt_dir = $_GET['akt_dir'];
	$path = '../galeria/' . $akt_dir . '/';

	$openFolder = opendir($path);
	while ($r = readdir($openFolder)) {
		if ($r != '.' and $r != 'mini' and $r != '..') {

			$fileArray[] = $r;
		}
	}
	if (!empty($fileArray)) {

		sort($fileArray);
		
		$total = count($fileArray);
		
		if ($total > 0) {
			for ($x = 0; $x <= $total - 1; $x++) {

				$org = $fileArray[$x];
				$old = explode(".", $org);
				$opis = $old[0];


				if ($db->query("SELECT * FROM $img_table WHERE dir=? AND obrazek=?", $akt_dir, $org)->numRows() <> 1) {

					$db->query("INSERT INTO $img_table VALUES('', ?, '', '', ?, '')", $org, $akt_dir);


					$id = $db->lastInsertID();

					if (!empty($org)) {
						ini_set('memory_limit', '512M');

						$new = 'galeria_' . $id . '.jpg';
						$org = $path . $org;
						// create new image instance
						$manager = new ImageManager(Driver::class);

						$image = $manager->read($org);

						$big = $path . $new;
						$mini = $path . 'mini/' . $new;

						if ($akt_dir === '_slider') $width_max = WIDTH_SLIDER;
						else $width_max = WIDTH_MAX;
						if ($image->scaleDown(width: $width_max)->save($big)->toJpeg() && $image->scaleDown(width: WIDTH_MIN)->save($mini)->toJpeg()) {

							unlink($org);
						} else {
							echo 'Nie udało się zapisać obrazu';
							exit;
						}
					}


					$db->query("UPDATE $img_table SET obrazek=?, pos=?, opis=? WHERE id=?", $new, $id, $opis, $id);
				}
			}
		}
		//usuwanie pustych rekordów
		$images = $db->query("SELECT * FROM $img_table WHERE dir=? ORDER BY id ASC", $akt_dir)->fetchAll();
		foreach ($images as $image) {
			$id = $image['id'];
			$obrazek = $image['obrazek'];

			if (!is_file($path . $obrazek))


				if ($db->query("DELETE FROM $img_table WHERE id=? AND dir=? AND obrazek=?  LIMIT 1", $id, $akt_dir, $obrazek)) {
					unlink($path . 'mini/' . $obrazek);
				}
		}


		$_SESSION['alert'] = 'Poprawnie zapisano zdjęcia';
		header('Location: galeria.php?cmd=pliki&dir=' . $_GET['akt_dir'] . '');
		exit();
	} else {
		$_SESSION['alert'] = 'Brak plików do aktualizacji';
		header('Location: galeria.php?cmd=pliki&dir=' . $_GET['akt_dir'] . '');
		exit();
	}
}

function add_dir()
{
	if ($_POST['add'] == 'add') {
		$add_dir = seo($_POST['add_dir']);
		$dat = date('Y-m-d');
		if ($_POST['dat'] == 'yes') $add_dir = "$dat-$add_dir";
		mkdir("../galeria/$add_dir", 0777);
		mkdir("../galeria/$add_dir/mini", 0777);

		$_SESSION['alert'] = 'Dodano folder galerii';
		header("Location: galeria.php?cmd=pliki&dir=$add_dir");
		exit();
	}
}


function rm_dir()
{ //
	if (rmdir('../galeria/' . $_GET['rm_dir'] . '/mini') && rmdir('../galeria/' . $_GET['rm_dir'] . '')) {
		$_SESSION['alert'] = 'Usunięto katalog  - <b>' . $_GET['rm_dir'] . '</b>';
		header("Location: galeria.php");
		exit();
	} else {
		$_SESSION['alert'] = 'Nie można było usunąć katalogu <b>' . $_GET['rm_dir'] . '</b> - być może nie jest pusty</b>';
		header("Location: galeria.php");
		exit();
	}
}


function pokaz()
{   ///
	global $img_table, $db;
	//$dirs = opendir('../galeria/' . $_GET['dir'] . '');
	$_SESSION['updir'] = '../galeria/' . $_GET['dir'] . '';

	$images = $db->query("SELECT * FROM $img_table WHERE dir=? ORDER BY pos ASC", $_GET['dir'])->fetchAll();
	include('views/galery/show.php');
}

<?

//podpięcie danych przed wyświetleniem

if (!empty($_GET['name'])) {
	$row = $db->query("SELECT * FROM $table WHERE name=?", $_GET['name'])->fetchArray();
	$title = $row['title'];
	$descr = substr(strip_tags($row['text1']), 0, 200);
} elseif (!empty($_GET['news'])) {
	$row = $db->query("SELECT * FROM $news_table WHERE id=?", $_GET['news'])->fetchArray();
	$title = $row['title_news'];
	$descr = substr(strip_tags($row['text_news']), 0, 200);
} else {
	$title = 'Witamy';
}


function show_meta() {}

function fullslider()
{
	global $db, $img_table;
	$slides = $db->query("SELECT * FROM $img_table WHERE dir='_slider' ORDER BY pos ASC")->fetchAll();

	include('views/modules/fullslider.php');
}



function news($news)
{
	global $db, $news_table;

	if (!empty($news)) {


		$news = $db->query("SELECT * FROM $news_table WHERE id=?", $news)->fetchArray();
		if (!empty($news)) {

			$text_news = $news['text_news'];

			$text_news = str_replace("<iframe", '<div class="embed-responsive embed-responsive-16by9"> <iframe', $text_news);
			$text_news = str_replace("</iframe>", '</iframe></div>', $text_news);

			include('views/modules/news.php');
		}
	}
} //function

function show_gal($dir = '')
{
	global  $db, $img_table;

	$images = $db->query("SELECT * FROM $img_table WHERE dir=? ORDER BY pos ASC", $dir)->fetchAll();

	if (!empty($images)) {

		include('views/modules/galery.php');
	}
}


function blog($rok)
{
	global $db, $news_table;

	$posts = $db->query("SELECT * FROM $news_table WHERE od LIKE ?  ORDER BY od DESC, id DESC ", $rok . '%')->fetchAll();

	if (!empty($posts)) {

		include('views/modules/blog.php');
	} else {
		echo 'Brak wpisów w tym roku';
	}
}



function sidebar()
{
	global $db, $meta_table;

	$sidebar = $db->query("SELECT * FROM $meta_table WHERE typ=?", 'sidebar')->fetchArray();

	echo $sidebar['tresc'];
}





function strony($name)
{
	global $db, $table;

	$page = $db->query("SELECT * FROM $table WHERE name=?", $name)->fetchArray();
	if (!empty($page)) {
		include('views/modules/page.php');
	}
}


function mapa()
{
	global $db, $table, $news_table;

	$sql = "
    SELECT p1.id AS parent_id, p1.name AS parent_name, p1.menu AS parent_menu,
           p2.id AS child_id, p2.name AS child_name, p2.menu AS child_menu
    FROM $table p1
    LEFT JOIN $table p2 ON p2.submenu = p1.id
    WHERE p1.submenu = ''
    ORDER BY p1.pos ASC, p2.pos ASC";

	$pages = $db->query($sql)->fetchAll();


	$menu = [];

	foreach ($pages as $page) {
		$parent_id = $page['parent_id'];

		// Tworzymy główną stronę w tablicy, jeśli jeszcze nie istnieje
		if (!isset($menu[$parent_id])) {
			$menu[$parent_id] = [
				'name' => x($page['parent_name']),
				'menu' => x($page['parent_menu']),
				'children' => []
			];
		}

		// Jeśli istnieje submenu, dodajemy go do "children"
		if (!empty($page['child_id'])) {
			$menu[$parent_id]['children'][] = [
				'name' => x($page['child_name']),
				'menu' => x($page['child_menu'])
			];
		}
	}


	$newsy = $db->query("SELECT * FROM $news_table ORDER BY od DESC, id DESC ")->fetchAll();

	include('views/modules/mapa.php');
}





function navbar()
{
	global $db, $table, $url, $news_table;

	$sql = "
    SELECT p1.id AS parent_id, p1.name AS parent_name, p1.menu AS parent_menu, p1.type AS parent_type,
           p2.id AS child_id, p2.name AS child_name, p2.menu AS child_menu
    FROM $table p1
    LEFT JOIN $table p2 ON p2.submenu = p1.id AND p2.pos <> '0'
    WHERE p1.submenu = '' AND p1.pos <> '0'
    ORDER BY p1.pos ASC, p2.pos ASC";

	$pages = $db->query($sql)->fetchAll();
	$menu = [];

	foreach ($pages as $page) {
		$parent_id = $page['parent_id'];

		if (!isset($menu[$parent_id])) {
			$menu[$parent_id] = [
				'name' => x($page['parent_name']),
				'menu' => x($page['parent_menu']),
				'type' => $page['parent_type'],
				'children' => []
			];
		}

		if (!empty($page['child_id'])) {
			$menu[$parent_id]['children'][] = [
				'name' => x($page['child_name']),
				'menu' => x($page['child_menu'])
			];
		}
	}


	$blog_years = [];
	$years = $db->query("SELECT DISTINCT YEAR(od) AS rok FROM $news_table ORDER BY rok DESC")->fetchAll();
	foreach ($years as $year) {
		$blog_years[] = x($year['rok']);
	}
	include('views/modules/navbar.php');
}


function last_post()
{
	global $db, $news_table;


	$posts = $db->query("SELECT * FROM $news_table  ORDER BY od DESC LIMIT 4 ")->fetchAll();


	include('views/modules/lastPost.php');
}

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


function flash()
{
	global $db, $news_table;
	// 1. Pobranie danych z bazy
	// Szybkie wiadomości (flash)
	$flash_news = $db->query("SELECT * FROM $news_table WHERE kategoria = 'flash' ORDER BY od DESC LIMIT 3")->fetchAll();
	include('views/modules/flash.php');
}

function home()
{
	global $db, $news_table;
	
	// Wszystkie wydarzenia do kalendarza (zarówno przyszłe, jak i przeszłe)
	$upcoming_events = $db->query("SELECT * FROM $news_table WHERE data_wydarzenia IS NOT NULL AND data_wydarzenia != '0000-00-00' AND (kategoria != 'flash' OR kategoria IS NULL) ORDER BY data_wydarzenia ASC")->fetchAll();
	// if (count($upcoming_events) < 3) {
	// 	$exclude_ids = array_column($upcoming_events, 'id');
	// 	$needed = 3 - count($upcoming_events);
	// 	if (!empty($exclude_ids)) {
	// 		$extra_events = $db->query("SELECT * FROM $news_table WHERE id NOT IN (" . implode(',', $exclude_ids) . ") ORDER BY od DESC LIMIT $needed")->fetchAll();
	// 	} else {
	// 		$extra_events = $db->query("SELECT * FROM $news_table ORDER BY od DESC LIMIT 3")->fetchAll();
	// 	}
	// 	$upcoming_events = array_merge($upcoming_events, $extra_events);
	// }

	// Relacje z wydarzeń (wpisy z galeriami)
	$event_relations = $db->query("SELECT * FROM $news_table WHERE (data_wydarzenia < CURDATE() OR data_wydarzenia IS NULL) AND kategoria = '' ORDER BY data_wydarzenia DESC, id DESC LIMIT 3")->fetchAll();
	// if (count($event_relations) < 3) {
	// 	$exclude_ids = array_column($event_relations, 'id');
	// 	$needed = 3 - count($event_relations);
	// 	if (!empty($exclude_ids)) {
	// 		$extra_relations = $db->query("SELECT * FROM $news_table WHERE id NOT IN (" . implode(',', $exclude_ids) . ") ORDER BY od DESC LIMIT $needed")->fetchAll();
	// 	} else {
	// 		$extra_relations = $db->query("SELECT * FROM $news_table ORDER BY od DESC LIMIT 3")->fetchAll();
	// 	}
	// 	$event_relations = array_merge($event_relations, $extra_relations);
	// }

	include('views/modules/home.php');



}

function show_meta()
{
}


function calendar()
{
	global $db, $news_table;

	// Pobranie parametrów roku i miesiąca z GET (z fallbackiem do bieżącego)
	$year = isset($_GET['cal_year']) ? (int) $_GET['cal_year'] : (int) date('Y');
	$month = isset($_GET['cal_month']) ? (int) $_GET['cal_month'] : (int) date('n');

	// Zakres bezpieczeństwa dla miesięcy
	if ($month < 1) {
		$month = 12;
		$year--;
	}
	if ($month > 12) {
		$month = 1;
		$year++;
	}

	// Pobranie filtrów z GET
	$selected_kat = isset($_GET['cal_kat']) ? trim($_GET['cal_kat']) : '';
	$selected_tag = isset($_GET['cal_tag']) ? trim($_GET['cal_tag']) : '';

	// Pobranie unikalnych kategorii z bazy
	$kategorie_rows = $db->query("SELECT DISTINCT kategoria FROM $news_table WHERE kategoria != '' AND kategoria IS NOT NULL ORDER BY kategoria ASC")->fetchAll();
	$all_kategorie = array_column($kategorie_rows, 'kategoria');

	// Pobranie unikalnych tagów z bazy
	$tagi_rows = $db->query("SELECT tagi FROM $news_table WHERE tagi != '' AND tagi IS NOT NULL")->fetchAll();
	$all_tags = [];
	foreach ($tagi_rows as $row) {
		$exploded = explode(',', $row['tagi']);
		foreach ($exploded as $t) {
			$trimmed = trim($t);
			if ($trimmed !== '' && !in_array($trimmed, $all_tags)) {
				$all_tags[] = $trimmed;
			}
		}
	}
	sort($all_tags);

	// Budowanie zapytania SQL na wydarzenia w wybranym miesiącu na podstawie data_wydarzenia
	$sql = "SELECT id, title_news, kategoria, tagi, data_wydarzenia FROM $news_table WHERE YEAR(data_wydarzenia) = ? AND MONTH(data_wydarzenia) = ?";
	$params = [$year, $month];

	if ($selected_kat !== '') {
		$sql .= " AND kategoria = ?";
		$params[] = $selected_kat;
	}

	if ($selected_tag !== '') {
		$sql .= " AND (tagi LIKE ? OR tagi = ?)";
		$params[] = '%' . $selected_tag . '%';
		$params[] = $selected_tag;
	}

	// Wykonanie zapytania
	$events = $db->query($sql, $params)->fetchAll();

	// Grupowanie wydarzeń po dniach na podstawie data_wydarzenia
	$events_by_day = [];
	foreach ($events as $event) {
		$day = (int) date('j', strtotime($event['data_wydarzenia']));
		$events_by_day[$day][] = $event;
	}

	// Obliczenia kalendarza
	$days_in_month = (int) date('t', mktime(0, 0, 0, $month, 1, $year));
	$first_day_of_week = (int) date('N', mktime(0, 0, 0, $month, 1, $year));

	$polish_months = [
		1 => 'Styczeń',
		2 => 'Luty',
		3 => 'Marzec',
		4 => 'Kwiecień',
		5 => 'Maj',
		6 => 'Czerwiec',
		7 => 'Lipiec',
		8 => 'Sierpień',
		9 => 'Wrzesień',
		10 => 'Październik',
		11 => 'Listopad',
		12 => 'Grudzień'
	];
	$month_name = $polish_months[$month];

	// Obliczenia dla nawigacji
	$prev_month = $month - 1;
	$prev_year = $year;
	if ($prev_month < 1) {
		$prev_month = 12;
		$prev_year--;
	}

	$next_month = $month + 1;
	$next_year = $year;
	if ($next_month > 12) {
		$next_month = 1;
		$next_year++;
	}

	// Zachowywanie innych parametrów URL przy generowaniu linków
	$buildUrl = function ($changes) {
		$params = $_GET;
		foreach ($changes as $key => $val) {
			if ($val === null) {
				unset($params[$key]);
			} else {
				$params[$key] = $val;
			}
		}
		return 'index.php?' . http_build_query($params);
	};

	// Dane dzisiejszej daty
	$today_d = (int) date('j');
	$today_m = (int) date('n');
	$today_y = (int) date('Y');

	// Przygotowanie siatki
	$grid = [];
	for ($i = 1; $i < $first_day_of_week; $i++) {
		$grid[] = null;
	}
	for ($d = 1; $d <= $days_in_month; $d++) {
		$grid[] = $d;
	}
	while (count($grid) % 7 !== 0) {
		$grid[] = null;
	}
	$weeks = array_chunk($grid, 7);

	include('views/modules/calendar.php');

}

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
	global $db, $img_table;

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

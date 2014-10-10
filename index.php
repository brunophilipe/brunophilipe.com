<?php

global $root_folder;
$root_folder = getcwd();

if (isset($_GET['route'])) {
	$route = $_GET['route'];
	if (strcmp($route, "project") == 0 && isset($_GET['id'])) {
		render_projectpage($_GET['id']);
	} else if (strcmp($route, "page") == 0 && isset($_GET['name'])) {
		render_page($_GET['name']);
	} else {
		print_r($_GET);
	}
} else {
	render_homepage();
}

function render_homepage()
{
	global $root_folder;

	if (isset($_GET['search']) && isset($_GET['tag'])) {
		$searching = TRUE;
		$searchingTag = $_GET['tag'];
	} else {
		$searching = FALSE;
	}

	// Get main contents
	$html_main = file_get_contents($root_folder."/assets/templates/main.html");
	$html_bulk = "";

	// Get menu
	$html_menu = _renderMenu(0);

	// Get data
	$entries_json = file_get_contents($root_folder."/assets/data/entries.json");
	$entries = json_decode($entries_json);

	if ($searching) {
		$entries = _entriesForTag($entries, $searchingTag);
		$html_bulk = "<p>Searching for tag: ".$searchingTag."</p>";

		$html_menu = _renderMenu(-1);
	}

	usort($entries, '_sort_objects_by_id_inverse');

	// Get entry html
	$html_entry = file_get_contents($root_folder."/assets/templates/entry.html");

	foreach ($entries as $entry) {
		$thisEntry = $html_entry;
		$thisEntry = str_replace("{title}", 	$entry->title, $thisEntry);
		$thisEntry = str_replace("{image}", 	$entry->image, $thisEntry);
		$thisEntry = str_replace("{id}", 		$entry->id, $thisEntry);
		$thisEntry = str_replace("{subtitle}", 	$entry->subtitle, $thisEntry);
		$thisEntry = str_replace("{tags}", 		_processTags($entry->tags), $thisEntry);
		$html_bulk .= $thisEntry;
	}

	$html_main = str_replace("{menu}", $html_menu, $html_main);
	$html_main = str_replace("{content}", $html_bulk, $html_main);

	echo $html_main;
}

function render_projectpage($project_id)
{
	global $root_folder;

	// Get main contents
	$html_main = file_get_contents($root_folder."/assets/templates/main.html");
	$html_bulk = "";

	// Get menu
	$html_menu = _renderMenu(-1);

	// Get data
	$entries_json = file_get_contents($root_folder."/assets/data/entries.json");
	$entries = json_decode($entries_json);

	// Get entry html
	$html_entry = file_get_contents($root_folder."/assets/templates/article.html");

	$entry = _entryForID($entries, $project_id);
	$html_entry = str_replace("{title}",		$entry->title, $html_entry);
	$html_entry = str_replace("{image}",		$entry->image, $html_entry);
	$html_entry = str_replace("{content}",		$entry->content, $html_entry);
	$html_entry = str_replace("{link_address}",	$entry->link_address, $html_entry);
	$html_entry = str_replace("{link_title}",	$entry->link_title, $html_entry);
	$html_entry = str_replace("{tags}",			_processTags($entry->tags), $html_entry);
	$html_bulk .= $html_entry;

	$html_main = str_replace("{menu}", $html_menu, $html_main);
	$html_main = str_replace("{content}", $html_bulk, $html_main);

	echo $html_main;
}

function render_page($page_slug)
{
	global $root_folder;

	// Get main contents
	$html_main = file_get_contents($root_folder."/assets/templates/main.html");

	// Get menu
	switch ($page_slug) {
		case "contact":
			$html_menu = _renderMenu(2);
			break;

		case "about":
			$html_menu = _renderMenu(1);
			break;

		default:
			$html_menu = _renderMenu(-1);
			break;
	}

	// Get data
	$pages_json = file_get_contents($root_folder."/assets/data/pages.json");
	$pages = json_decode($pages_json, true);

	$content = $pages[$page_slug]["content"]."";

	$html_main = str_replace("{menu}", $html_menu, $html_main);

	if (strlen($content) > 0)
	{
		$html_main = str_replace("{content}", $pages[$page_slug]["content"], $html_main);
	}
	else
	{
		http_response_code(404);
		$html_main = str_replace("{content}", "<h1>404 – Not Found</h1><p>Are you sure you have the right address?</p>", $html_main);
	}

	echo $html_main;
}

function _renderMenu($active = 0)
{
	global $root_folder;

	$html_menu = file_get_contents($root_folder."/assets/templates/menu.html");
	$html_bulk = "";

	$menu_json = file_get_contents($root_folder."/assets/data/menu.json");
	$menu = json_decode($menu_json, true);

	for ($i=0; $i < count($menu); $i++) {
		$html_bulk .= "<li".($i == $active ? " class=\"active\"" : "")."><a href=\"".$menu[$i]["path"]."\">".$menu[$i]["title"]."</a></li>";
	}

	return str_replace("{menu}", $html_bulk, $html_menu);
}

function _processTags($tags)
{
	$bulk = "";

	foreach ($tags as $tag) {
		$plainTag = str_replace(" ", "%20", $tag);
		$bulk .= "<li><a href=\"/search/".$plainTag."\">".$tag."</a></li>";
	}

	return $bulk;
}

function _entriesForTag($entries, $tag)
{
	$array = array();

	foreach ($entries as $entry)
	{
		if (in_array($tag, $entry->tags)) {
			array_push($array, $entry);
		}
	}

	return $array;
}

function _entryForID($entries, $id)
{
	foreach ($entries as $entry)
	{
		if ($entry->id == $id) {
			return $entry;
		}
	}
}

function _sort_objects_by_id_inverse($a, $b) {
	if($a->id == $b->id){ return 0 ; }
	return ($a->id < $b->id) ? 1 : -1;
}

?>
<?php
require_once '../../config/core.conf.php';

header('Content-type: text/html; charset='.Lang::$encoding);



$source = file_get_contents('source.txt');
$separator = PHP_EOL.PHP_EOL;
// FIX MAC OS end lines
//$separator = "\r\n\r\n";

$contents = explode($separator, $source);

$results = array();
for($i = 0; $i < 50; $i++) {

	$content = $contents[$i];
	$first_space = strpos($content, ' ');
	$first_point = strpos($content, '.');

	$author = substr($content, 0, $first_space);
	$title = substr($content, $first_space + 1, $first_point - $first_space);
	$content  = substr($content, $first_point + 2);
	// If content contains break lines
	//$content = nl2br($content);
	// Else insert break lines
	$content = wordwrap($content, 200, '.<br /><br />');

	$date = Utils::getRandomDate(array(2014, 2015));

	$results[] = array(
		'author' => ucfirst($author),
		'title' => ucfirst($title),
		'content' => ucfirst($content),
		'date' => $date
	);

}

//var_dump($results);

$db = Db::getInstance();

$query = $db->prepare('INSERT INTO posts (author, title, content, date) VALUES (:author, :title, :content, :date)');

$query->bindParam('author', $author);
$query->bindParam('title', $title);
$query->bindParam('content', $content);
$query->bindParam('date', $date);

foreach($results as $key => $result) {
	$author = $result['author'];
	$title = $result['title'];
	$content = $result['content'];
	$date = $result['date'];

	$query->execute();

	$last_insert_id = $db->lastInsertId();

	echo var_dump($result, true).' => '.($last_insert_id > 0 ? 'OK' : 'NOK').'<br><br>';
}
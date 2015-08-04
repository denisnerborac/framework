<?php
set_time_limit(0);

require_once '../../config/core.conf.php';

header('Content-type: text/html; charset=utf-8');

$feeds = array(
	'lequipe' => 'http://www.lequipe.fr/rss/actu_rss_Football.xml',
	//'lequipe' => 'http://localhost/wf3/framework/',
);

$news = array();
foreach($feeds as $key => $xml_feed) {

	echo '<strong>'.$xml_feed.'</strong><br>';

	$curl = new Curl($xml_feed);

	$result = $curl->exec();

	$feed = json_decode(json_encode(simplexml_load_string($result)), true);

	foreach($feed['channel']['item'] as $key => $item) {
		$news[] = array(
			'hash' => md5($item['title']),
			'title' => $item['title'],
			'content' => $item['description'],
			'date' => date('Y-m-d H:i:s', strtotime($item['pubDate'])),
			'picture' => !empty($item['enclosure']['@attributes']['url']) ? $item['enclosure']['@attributes']['url'] : '',
			'link' => $item['link']
		);
	}

	echo '<pre>';
	print_r($news);
	echo '</pre>';

	/*
	$sql = 'INSERT INTO news SET hash = :hash, title = :title, content = :content, date = :date, picture = :picture, link = :link
			ON DUPLICATE KEY UPDATE hash = :hash, title = :title, content = :content, date = :date, picture = :picture, link = :link';

	$query = Db::getInstance()->prepare($sql);

	$query->bindParam('hash', $hash);
	$query->bindParam('title', $title);
	$query->bindParam('content', $content);
	$query->bindParam('date', $date);
	$query->bindParam('picture', $picture);
	$query->bindParam('link', $link);

	foreach($news as $key => $article) {

		$hash = $article['hash'];
		$title = $article['title'];
		$content = $article['content'];
		$date = $article['date'];
		$picture = $article['picture'];
		$link = $article['link'];

		$result = $query->execute();

		echo $key.'. '.$date.' - '.$title.' '.($result ? 'OK' : 'NOK').'<br>';
	}
	*/

	echo '<hr>';
}
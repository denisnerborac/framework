<?php
require_once 'Twitter/twitteroauth.php';

class API_Twitter {

	const TWITTER_API_KEY = null;
	const TWITTER_SECRET_KEY = null;
	const TWITTER_ACCESS_TOKEN = null;
	const TWITTER_ACCESS_TOKEN_SECRET = null;
	const TWITTER_USERNAME = null;
	const TWITTER_LIMIT = 50;

	public static $default_params = array(
		'screen_name' => self::TWITTER_USERNAME,
		'exclude_replies' => true,
		'include_rts' => false,
		'count' => self::TWITTER_LIMIT
	);

	public static function getChannel($params = array()) {

		if (!strlen(self::TWITTER_API_KEY) ||
			!strlen(self::TWITTER_SECRET_KEY) ||
			!strlen(self::TWITTER_ACCESS_TOKEN) ||
			!strlen(self::TWITTER_ACCESS_TOKEN_SECRET)) {
			throw new Exception(__CLASS__.' Error - Invalid Twitter API configuration');
		}

		$params = array_merge(self::$default_params, $params);

		if (empty($params['screen_name'])) {
			throw new Exception(__CLASS__.' Error - Undefined Username');
		}

		$twitter = new TwitterOAuth(self::TWITTER_API_KEY, self::TWITTER_SECRET_KEY, self::TWITTER_ACCESS_TOKEN, self::TWITTER_ACCESS_TOKEN_SECRET);

		$feed = $twitter->get('statuses/user_timeline', $params);

		if (!empty($feed->errors)) {
			throw new Exception(__CLASS__.' Error - '.$feed->errors[0]->code.' - '.$feed->errors[0]->message);
		}

		return $feed;
	}

	public static function getPosts($params = array()) {

		$channel = self::getChannel($params);

		$posts = array();

		if(!empty($channel)) {

			foreach($channel as $post) {

		        $created_at = $post->created_at;
		        $time = strtotime($created_at);
		        $date = date('d/m/Y H:i', $time);
		        $short_date = date('d/m/Y', $time);
		        $short_time = strtotime(date('Y-m-d', $time));

		        $content = Utils::linkify($post->text);
		       	$content = Utils::linkifyTwitterUser($content);
		       	$content = Utils::linkifyHashtag($content);

		       	$picture = '';
		       	if (!empty($post->entities->media[0]->media_url)) {
		       		$picture = $post->entities->media[0]->media_url;
		       	}

				$posts[] = array(
					'time' => $time,
					'date' => $date,
					'content' => $content,
					'picture' => $picture
				);
		    }
		}

		return $posts;
	}
}
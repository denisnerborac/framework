<?php

//if (version_compare(PHP_VERSION, '5.3.0') >= 0) {}
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphObject;

class API_Facebook {

	const FACEBOOK_APP_ID = null;
	const FACEBOOK_SECRET_KEY = null;

	public static $post_types = array(
		'photo',
		'video',
		'link'
	);

	public static function getChannel($channel) {

		if (empty($channel)) {
			throw new Exception(__CLASS__.' Error - Undefined Facebook channel');
		}

		$app_id = self::FACEBOOK_APP_ID;
		if (empty($app_id)) {
			throw new Exception(__CLASS__.' Error - Undefined FACEBOOK_APP_ID');
		}

		$secret_key = self::FACEBOOK_SECRET_KEY;
		if (empty($secret_key)) {
			throw new Exception(__CLASS__.' Error - Undefined FACEBOOK_SECRET_KEY');
		}

		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			return self::_getChannelV4($channel);
		}
		return self::_getChannelV3($channel);
	}

	private static function _getChannelV3($channel) {

		require_once 'Facebook_v3/facebook.php';

		try {

			$config = array(
				'appId' => self::FACEBOOK_APP_ID,
				'secret' => self::FACEBOOK_SECRET_KEY,
				'allowSignedRequest' => false
			);

			$facebook = new Facebook($config);

			return $facebook->api('/'.$channel.'/posts?fields=type,created_time,message,picture,object_id,link','GET');

		} catch(FacebookApiException $e) {
			throw new Exception(__CLASS__.' Error - '.$e->getType().' - '.$e->getMessage());
		}
	}

	private static function _getChannelV4($channel) {


		FacebookSession::setDefaultApplication(self::FACEBOOK_APP_ID, self::FACEBOOK_SECRET_KEY);
		$session = FacebookSession::newAppSession(self::FACEBOOK_APP_ID, self::FACEBOOK_SECRET_KEY);

		$request = new FacebookRequest(
			$session,
			'GET',
			'/'.$channel.'/posts?fields=type,created_time,message,picture,object_id,link'
		);

		$response = $request->execute();
		$graphObject = $response->getGraphObject();
		return $graphObject->getPropertyAsArray('data');
	}

	public static function getPosts($channel) {

		$channel = self::getChannel($channel);

		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			return self::_getPostsV4($channel);
		}
		return self::_getPostsV3($channel);
	}

	private static function _getPostsV3($channel) {

		$posts = array();

		if (!empty($channel['data'])) {

			foreach($channel['data'] as $key => $item) {

				$type = $item['type'];

				if (!in_array($type, self::$post_types)) {
					continue;
				}

				$content = $item['message'];
				$created_time = $item['created_time'];
				$time = strtotime($created_time);
				$date = date('d/m/Y H:i:s', $time);

				$picture = !empty($item['picture']) ? $item['picture'] : '';
				if (!empty($item['object_id'])) {
					$picture = 'http://graph.facebook.com/'.$item['object_id'].'/picture';
				}

				$link = '';
				if ($type == 'link' || $type == 'video') {
					$link = $item['link'];
				}

				$content = Utils::linkify($content);

				$posts[] = array(
					'type' => $type,
					'time' => $time,
					'date' => $date,
					'content' => $content,
					'picture' => $picture,
					'link' => $link
				);
			}
		}

		return $posts;
	}

	private static function _getPostsV4($channel) {

		$posts = array();

		foreach($channel as $key => $val) {

			$content = $val->getProperty('message');
			$type = $val->getProperty('type');

			if (!in_array($type, self::$post_types)) {
				continue;
			}

			$created_time = $val->getProperty('created_time');
			$time = strtotime($created_time);
			$date = date('d/m/Y H:i:s', $time);

			$picture = $val->getProperty('picture');
			$object_id = $val->getProperty('object_id');
			$full_picture = $picture;
			if (!is_null($object_id)) {
				$full_picture = 'http://graph.facebook.com/'.$object_id.'/picture';
			}

			$link = '';
			if ($type == 'link' || $type == 'video') {
				$link = $val->getProperty('link');
			}

			$content = Utils::linkify($content);

			$posts[] = array(
				'type' => $type,
				'time' => $time,
				'date' => $date,
				'content' => $content,
				'picture' => $full_picture,
				'link' => $link
			);
		}

		return $posts;
	}
}
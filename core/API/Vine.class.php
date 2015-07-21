<?php
class API_Vine {

	public static $default_params = array(
		'maxwidth' => null, // Set the maximum width of the displayed embed in whole pixels.
		'maxheight' => null, // Set the maximum height of the displayed embed in whole pixels.
		'omit_script' => null, // Do not include the Vine embed JavaScript in the response.
	);

	public static function getUser($user_name) {

		if (empty($user_name)) {
			throw new Exception(__CLASS__.' Error - Undefined Username');
		}

		$feed = @file_get_contents('https://api.vineapp.com/users/search/'.$user_name);

		if (empty($feed)) {
			throw new Exception(__CLASS__.' Error - '.$http_response_header[0]);
		}

		$feed = json_decode($feed);

		if (empty($feed->data->records)) {
			throw new Exception(__CLASS__.' Error - User "'.$user_name.'" not found');
		}

		return $feed->data->records[0];
	}

	public static function getUserId($user_name) {
		$user = self::getUser($user_name);
		return number_format($user->userId, 0, '', '');
	}

	public static function getChannel($user_id) {

		if (empty($user_id)) {
			throw new Exception(__CLASS__.' Error - Undefined User Id');
		}

		if (!is_numeric($user_id)) {
			$user_id = self::getUserId($user_id);
		}

		$feed = @file_get_contents('https://api.vineapp.com/timelines/users/'.$user_id);

		if (empty($feed)) {
			throw new Exception(__CLASS__.' Error - '.$http_response_header[0]);
		}

		return json_decode($feed);
	}

	public static function getVideos($user_id) {

		$feed = self::getChannel($user_id);

		$videos = array();

		if (!empty($feed->data->records)) {

			foreach($feed->data->records as $video) {

				$time = strtotime($video->created);
				$date = date('d-m-Y H:i:s', $time);
				$link = $video->permalinkUrl;

				$videos[] = array(
					'id' => str_replace('https://vine.co/v/', '', $link),
					'username' => $video->username,
					'avatar' => $video->avatarUrl,
					'time' => $time,
					'date' => $date,
					'low' => $video->videoLowURL,
					'standard' => $video->videoUrl,
					'high' => $video->videoDashUrl,
					'thumbnail' => $video->thumbnailUrl,
					'description' => $video->description,
					'link' => $link,
					'explicit' => $video->explicitContent
				);

			}
		}

		return $videos;
	}

	public static function getVideo($id, $params = array()) {
		$params = array_merge(self::$default_params, $params);
		$query_string = http_build_query($params);

		$feed = @file_get_contents('https://vine.co/oembed.json?id='.$id.'&'.$query_string);

		if (empty($feed)) {
			throw new Exception(__CLASS__.' Error - '.$http_response_header[0]);
		}

		return json_decode($feed);
	}
}
<?php
class API_Youtube {

	const MAX_RESULTS = 50;
	const YOUTUBE_API_KEY = null;

	public static $default_params = array(
		'rel' 			 => 1, 	   // Affiche des vidéos similaires à la fin de la vidéo
		'modestbranding' => 0, 	   // Masques l'identité youtube
		'controls' 		 => 1, 	   // Affiche les boutons de controle du lecteur
		'showinfo' 		 => 1, 	   // Affiche les infos de la vidéos titre, auteur
		'autoplay' 		 => 0, 	   // Démarre automatiquement la vidéo
		'enablejsapi'    => 1, 	   // Autorise le javascript à controler le lecteur
		'cc_load_policy' => 1, 	   // Affichage des sous-titres
		'iv_load_policy' => 1, 	   // 1 = affiche les annotations vidéo, 3 = n'affiche pas les annotations vidéo,
		'theme'			 => 'dark' // Theme de couleur dark/light
	);

	public static function getChannel($channel) {

		if (!strlen(self::YOUTUBE_API_KEY)) {
			throw new Exception(__CLASS__.' Error - Undefined Youtube API configuration');
		}

		if (empty($channel)) {
			throw new Exception(__CLASS__.' Error - Undefined Youtube Channel');
		}

		$feed = @file_get_contents('https://www.googleapis.com/youtube/v3/search?key='.self::YOUTUBE_API_KEY.'&channelId='.$channel.'&part=snippet,id&order=date&maxResults='.self::MAX_RESULTS);

		if (empty($feed)) {
			throw new Exception(__CLASS__.' Error - '.$http_response_header[0]);
		}

		return json_decode($feed);
	}

	public static function getVideo($channel, $id) {

		$videos = self::getVideos($channel);

		$video = array();

		foreach($videos as $_video) {
			if ($_video['id'] == $id) {
				$video[] = $_video;
			}
		}
		return $video;
	}


	public static function getVideos($channel) {

		$channel = self::getChannel($channel);

		$videos = array();

		if(!empty($channel->items)) {
			foreach($channel->items as $item) {

				if ($item->id->kind != 'youtube#video') {
					continue;
				}

				$time = strtotime($item->snippet->publishedAt);
				$date = date('d-m-Y H:i:s', $time);

				$videos[] = array(
					'id' => $item->id->videoId,
					'title' => $item->snippet->title,
					'description' => $item->snippet->description,
					'time' => $time,
					'date' => $date,
					'thumbnail' => array(
						'small' => $item->snippet->thumbnails->default->url,
						'medium' => $item->snippet->thumbnails->medium->url,
						'large' => $item->snippet->thumbnails->high->url
					)
				);
			}
		}

		return $videos;
	}

	public static function getVideoUrl($id, $params = array()) {
		$params = array_merge(self::$default_params, $params);
		$query_string = http_build_query($params);
		return 'https://www.youtube.com/v/'.$id.'&version=3&'.$query_string;
	}

}
<?php
require_once 'Instagram/instagram.class.php';

class API_Instagram {

	const INSTAGRAM_API_KEY = null;

	private static $instance;

	public static function getInstance() {

		if (!strlen(self::INSTAGRAM_API_KEY)) {
			throw new Exception(__CLASS__.' Error - Invalid Instagram API configuration');
		}

		if(!isset(self::$instance)) {
			self::$instance = new Instagram(self::INSTAGRAM_API_KEY);
		}
		return self::$instance;
	}

	public static function getUserId($user_name) {

		$user = self::getUser($user_name);

		return number_format($user->id, 0, '', '');
	}

	public static function getUser($user_name) {

		if (empty($user_name)) {
			throw new Exception(__CLASS__.' Error - Empty User Name');
		}

		$api = self::getInstance();

		$user = $api->searchUser($user_name, 1);

		if (empty($user->data)) {
			throw new Exception(__CLASS__.' Error - User "'.$user_name.'" not found');
		}

		return $user->data[0];
	}

	public static function getPhotos($user_id) {

		$api = self::getInstance();

		if (!is_numeric($user_id)) {
			$user_id = self::getUserId($user_id);
		}

		$feed = $api->getUserMedia($user_id, 100);

		$photos = array();

		if (!empty($feed->data)) {

			foreach($feed->data as $key => $photo) {

				$photos[] = array(
					'small' => array(
						'url' => $photo->images->thumbnail->url,
						'width' => $photo->images->thumbnail->width,
						'height' => $photo->images->thumbnail->height
					),
					'medium' => array(
						'url' => $photo->images->low_resolution->url,
						'width' => $photo->images->low_resolution->width,
						'height' => $photo->images->low_resolution->height
					),
					'large' => array(
						'url' => $photo->images->standard_resolution->url,
						'width' => $photo->images->standard_resolution->width,
						'height' => $photo->images->standard_resolution->height
					),
					'desc' => $photo->caption->text,
					'link' => $photo->link
				);
			}
		}

		return $photos;
	}

}
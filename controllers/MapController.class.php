<?php

class MapController extends BaseController {

	const GOOGLE_API_KEY = 'AIzaSyCIp4-ox_FmzOnBzOegq3WaNkKfKkyqQ-M';

	public function geolocation() {

		$this->render('map/geolocation.tpl');
	}

	public function geocoding() {

		$address = $this->request->get('address', '18 rue Geoffroy l\'Asnier, 75004 Paris');
		$result = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key='.self::GOOGLE_API_KEY));

		$this->render('map/geocoding.tpl', array('result' => $result, 'address' => $address));
	}

}
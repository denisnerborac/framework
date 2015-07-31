<?php

class MapController extends BaseController {

	const GOOGLE_API_KEY = 'AIzaSyBivWJcv6tz5xumeovxT-MaXlJEutRHubE';

	public function geolocation() {

		$this->render('map/geolocation.tpl');
	}

	public function geocoding() {

		$address = $this->request->get('address', '18 rue Geoffroy l\'Asnier, 75004 Paris');
		$result = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key='.self::GOOGLE_API_KEY));

		echo '<pre>'.print_r($result, true).'</pre>';
	}

}
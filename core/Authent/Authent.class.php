<?php

class Authent {

	const REMEMBER_ME_SECRET_KEY = 'ImNH7OI%$n7E$pi?8ZHB3ugOB3t*gx&I';

	/*
	Default expiration = 604800 (60 * 60 * 24 * 7 = 7 days)
	*/
	public static function setRememberMe($user_id, $expiration = 604800) {

		$protocol = $_SERVER['REQUEST_SCHEME']; // Contient le protocole en cours http ou https
		$current_time = time(); // On définit le timestamp actuel

		// On définit l'empreinte de l'utilisateur, url en cours et user agent
		$footprints = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].$_SERVER['HTTP_USER_AGENT'];

		// On crée un jeton qui contient la clé secrète concaténée avec l'empreinte de l'utilisateur
		$token = REMEMBER_ME_SECRET_KEY.$footprints;

		// On définit une chaîne qui contient nos infos en clair
		$user_data = $current_time.'.'.$user_id;

		// On crypte les informations en clair concaténées avec le jeton
		$crypted_token = hash('sha256', $token.$user_data);

		// On stock les infos en clair et les infos cryptées dans des cookies
		setcookie('rememberme_data', $user_data, $current_time + $expiration);
		setcookie('rememberme_token', $crypted_token, $current_time + $expiration);
	}

	/*
	Default expiration = 604800 (60 * 60 * 24 * 7 = 7 days)
	*/
	public static function getRememberMe($expiration = 604800) {

		if (empty($_COOKIE['rememberme_data']) || empty($_COOKIE['rememberme_token'])) {
			return false;
		}

		$protocol = $_SERVER['REQUEST_SCHEME']; // Contient le protocole en cours http ou https
		$current_time = time(); // On définit le timestamp actuel

		// On définit l'empreinte de l'utilisateur, url en cours et user agent
		$footprints = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].$_SERVER['HTTP_USER_AGENT'];

		// On crée un jeton qui contient la clé secrète concaténée avec l'empreinte de l'utilisateur
		$token = REMEMBER_ME_SECRET_KEY.$footprints;

		// On crypt les informations du cookie concaténées avec le jeton
		$crypted_token = hash('sha256', $token.$_COOKIE['rememberme_data']);

		// On vérifie que le jeton du cookie est égal au jeton crypté au dessus
		if(strcmp($_COOKIE['rememberme_token'], $crypted_token) !== 0) {
			return false;
		}

		// On récupère les infos du cookie dans 2 variables, correspondant aux 2 entrées du tableau renvoyé par explode
		list($user_time, $user_id) = explode('.', $_COOKIE['rememberme_data']);

		// On vérifie que le timestamp défini dans le cookie expire dans le futur et qu'il a été défini dans le passé
		if($user_time + $expiration > $current_time && $user_time < $current_time) {
			return $user_id;
		}
		return false;
	}


}
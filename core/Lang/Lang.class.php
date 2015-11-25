<?php
class Lang {

    const GETTEXT_MODE_NATIVE = 1;
    const GETTEXT_MODE_LIBRARY = 2;

    public static $encoding = 'UTF-8';

	public static $default_locale = 'fr_FR';
	public static $default_lang   = 'fr';

	public static $locales = array(
		'fr' => 'fr_FR',
		'en' => 'en_US',
		'es' => 'es_ES',
		'de' => 'de_DE'
	);

    private $_lang;
    private $_locale;
    private $config;

    public function __construct($locale = null) {

        if (!is_null($locale)) {
            $user_locale = self::checkLocale($locale);
        }
        if (empty($user_locale)) {
            $user_locale = self::acceptFromHttp();
        }
        if (empty($user_locale)) {
            $user_locale = self::$default_locale;
        }

        $this->setUserLocale($user_locale);
        $this->setUserLang(substr($user_locale, 0, 2));

        return $this->_setLocaleConfig();
    }

    public function setUserLang($user_lang) {
        $this->_lang = $user_lang;
    }

    public function setUserLocale($user_locale) {
        $this->_locale = $user_locale;
    }

    public function getUserLang() {
        return $this->_lang;
    }

    public function getUserLocale() {
        return $this->_locale;
    }

    public static function getDefaultLang() {
        return self::$default_lang;
    }

    public static function getDefaultLocale() {
        return self::$default_locale;
    }

    private static function _getTextMode() {
        if (!function_exists('getText') || strncasecmp(PHP_OS, 'WIN', 3) == 0) {
            require_once('gettext.inc');
            return self::GETTEXT_MODE_LIBRARY;
        }
        return self::GETTEXT_MODE_NATIVE;
    }

    public static function getText($text) {
        if (self::_getTextMode() == self::GETTEXT_MODE_NATIVE) {
            return _($text);
        }
        return __($text);
    }

    public static function _($text) {
        return self::getText($text);
    }

    public static function getPluralText($singular, $plural, $number) {
        if (self::_getTextMode() == self::GETTEXT_MODE_NATIVE) {
            return ngettext($singular, $plural, $number);
        }
        return _ngettext($singular, $plural, $number);
    }

    private function _setLocaleConfig() {

        $config = array(
            'locale'         => $this->getUserLocale(),
            'lang'           => $this->getUserLang(),
            'encoding'       => 'UTF-8',
            'encoding_light' => 'utf8',
            'domain'         => $this->getUserLang(),
            'path'           => realpath('./lang')
        );

        if (self::_getTextMode() == self::GETTEXT_MODE_NATIVE) {
            putenv("LANG=".$config["locale"].'.'.$config["encoding_light"]);
            putenv("LC_ALL=".$config["locale"].'.'.$config["encoding_light"]);
            putenv("LANGUAGE=".$config["locale"].'.'.$config["encoding_light"]);
            setlocale(LC_ALL, $config["locale"].'.'.$config["encoding_light"]);

            bindtextdomain($config["domain"], $config["path"]);
            bind_textdomain_codeset($config["domain"], $config["encoding"]);
            textdomain($config["domain"]);
        } else {
            T_setlocale(LC_MESSAGES, $config['locale']);
            T_bindtextdomain($config['domain'], LOCALE_PATH);
            T_bind_textdomain_codeset($config['domain'], $config['encoding']);
            T_textdomain($config['domain']);
        }

        return true;
    }

	public static function getAcceptLocales() {
		return !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
	}

    public static function acceptFromHttp() {

        $accept_locales = self::getAcceptLocales();
        if (empty($accept_locales)) {
            return self::$default_locale;
        }

		if (class_exists('Locale') && method_exists('Locale', 'acceptFromHttp')) {
			$accept_locale = self::checkLocale(Locale::acceptFromHttp($accept_locales));
			if (!empty($accept_locale)) {
				return $accept_locale;
			}
		}

		$locales = array();
        foreach (preg_split('/,\s*/', $accept_locales) as $accept_locale) {

            $result = preg_match('/^([a-z]{1,8}(?:[-_][a-z]{1,8})*)(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accept_locale, $match);

            if (!$result) {
                continue;
            }

            $quality = 1.0;
            if (isset($match[2])) {
                $quality = (float) $match[2];
            }

            $countries = explode('-', $match[1]);
            $region = array_shift($countries);
            $country_sub = explode('_', $region);
            $region = array_shift($country_sub);

            foreach($countries as $country) {
                $locales[$region . '_' . strtoupper($country)] = $quality;
            }

            foreach($country_sub as $country) {
                $locales[$region . '_' . strtoupper($country)] = $quality;
            }
            $locales[$region] = $quality;
        }

        if (empty($locales)) {
        	return self::$default_locale;
        }

        arsort($locales);

        foreach($locales as $locale => $quality) {
        	$accept_locale = self::checkLocale($locale);
        	if (!empty($accept_locale)) {
        		return $accept_locale;
        	}
        }
        return self::$default_locale;
    }

    public static function checkLocale($locale) {
    	if (in_array($locale, self::$locales)) {
			return $locale;
		}
		if (isset(self::$locales[$locale])) {
			return self::$locales[$locale];
		}
    	return false;
    }
}
<?php
class Utils {

	public static function isDecimal($input){
	    return !(ctype_digit(strval($input)));
	}

	public static function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	public static function lcfirst() {
		return (string)(strtolower(substr($str,0,1)).substr($str,1));
	}

	public static function cutString($text, $max_length = 0, $end = '...') {
		if ($max_length > 0 && strlen($text) > $max_length) {
			$text = wordwrap($text, $max_length, '|', true);
			$text = explode('|', $text);
			return $text[0].$end;
		}
		return $text;
	}

	public static function camelCase($str) {
		return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
	}

	public static function cleanString($str, $delimiter='-') {
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		return $clean;
	}

	public static function stripslashes($value) {
		if(is_array($value)) {
			return array_map(array(self, 'stripslashes'), $value);
		} else {
			return stripslashes($value);
		}
	}

	public static function linkify($str) {

		preg_match_all("/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/", $str, $urls);

		if (!empty($urls[0])) {
			foreach($urls[0] as $k => $url) {
				$str = str_replace($url, '<a href="'.$url.'" target="_blank">'.$url.'</a>', $str);
			}
		}

		return $str;
	}

	public static function linkifyTwitterUser($str) {
		return preg_replace("/@(\\w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $str);
	}

	public static function linkifyHashtag($str) {
		return preg_replace("/#(\\S+)/", '<a href="http://twitter.com/search?q=$1" target="_blank">#$1</a>', $str);
	}

	public static function redirectJs($page, $delay = 1) {
		return '<script>setTimeout(function() { window.location.href = "'.$page.'"; }, '.($delay * 1000).');</script>';
	}

	public static function getSize($bytes)	{
	    $units = array('o','ko','mo','go','to','po');
	    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2).' '.$units[$i];
	}

	public static function getRandomTime() {
		return strtotime(getRandomDate());
	}

	public static function getRandomDate($range_years = array()) {

		$random_year = sprintf('%1$04d', $range_years ? rand($range_years[0], $range_years[1]) : rand(1970, date('Y')));
		$random_month = sprintf('%1$02d', rand(1, 12));
		$random_day = sprintf('%1$02d', rand(0, cal_days_in_month(CAL_GREGORIAN, $random_month, $random_year)));
		$random_hour = sprintf('%1$02d', rand(0, 23));
		$random_minute = sprintf('%1$02d', rand(0, 59));
		$random_second = sprintf('%1$02d', rand(0, 59));

		$random_date = $random_year.'-'.$random_month.'-'.$random_day.' '.$random_hour.':'.$random_minute.':'.$random_second;

		return $random_date;
	}

}
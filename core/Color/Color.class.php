<?php

class Color {

	private $color;

	public function __construct($color)	{
		try {
			$this->color = cleanColorHex($color);
		}
		catch (Exception $e) {
			Logger::log($e);
		}
	}

	public function __get($value) {
		return $this->$value;
	}

	public function __set($key, $value) {
		$this->$key = $value;
	}

	public static function cleanColorHex($color) {
		$color = (false === strpos($color, '#') ? '#'.$color : $color);
		if (strlen($color) == 7)
			return $color;

		if (strlen($color) < 7) {
			if (strlen($color) == 4) {
				$color .= substr($color,1);
			} else {
				//$color = '#'.$color[1].$color[1].$color[2].$color[2].$color[3].$color[3];
				$color = "#".sprintf("%06d",$color);
			}
			return $color;
		}

		if (strlen($color) > 7)
			return substr($color, 0, 7);

		return false;
	}

	public static function getMidColors($rgb1,$rgb2,$nb) {
		$rgb1 = explode(",",$rgb1);
		$rgb2 = explode(",",$rgb2);
		for($i=0;$i<3;$i++){
			for($j=1;$j<=$nb;$j++) {
				if($rgb1[$i]<$rgb2[$i]) {
					@$rgb_mid[$j].= round(((max($rgb1[$i],$rgb2[$i])-min($rgb1[$i],$rgb2[$i]))/($nb+1))*$j  + min($rgb1[$i],$rgb2[$i]));
				}
				else {
					@$rgb_mid[$j].= round(max($rgb1[$i],$rgb2[$i])-((max($rgb1[$i],$rgb2[$i])-min($rgb1[$i],$rgb2[$i]))/($nb+1))*$j);
				}
				if($i!=2) {
					$rgb_mid[$j].=",";
				}
			}
		}
		return $rgb_mid;
	}

	public static function adMidColors($src_colors,$nb_inter) {
		for($i=0;$i<count($src_colors);$i++) {
			$dest_colors[]=$src_colors[$i];
			if($i<count($src_colors)-1) {
				if(is_array($nb_inter)) {
					$nb = $nb_inter[$i];
				}
				else {
					$nb = $nb_inter;
				}
				$new_colors = getMidColors($src_colors[$i],$src_colors[$i+1],$nb);
				foreach($new_colors as $new_color)
					$dest_colors[]= $new_color;
			}
		}
		return $dest_colors;
	}

	public static function getColor($var,$src_colors) {

		$colors_keys = array_keys($src_colors);
		$colors_RGB = array_values($src_colors);

		for($i=0;$i<sizeof($src_colors);$i++) {

			if($var>=$colors_keys[$i]&&$var<$colors_keys[$i+1]) {

				$rgb1 = explode(",",$colors_RGB[$i]);
				$rgb2 = explode(",",$colors_RGB[$i+1]);

				for($j=0;$j<3;$j++) {
					$c = (max($rgb1[$j],$rgb2[$j]) - min($rgb1[$j],$rgb2[$j])) / (max($colors_keys[$i],$colors_keys[$i+1]) - min($colors_keys[$i],$colors_keys[$i+1]));
					if($rgb1[$j]<$rgb2[$j]) {
						$dest_color .= round(max($rgb1[$j],$rgb2[$j]) - ((max($colors_keys[$i],$colors_keys[$i+1]) - $var)*$c));
					}
					else {
						$dest_color .= round(min($rgb1[$j],$rgb2[$j]) + ((max($colors_keys[$i],$colors_keys[$i+1]) - $var)*$c));
					}
					if($j!=2) {
						$dest_color.=",";
					}
				}
			}
		}
		if($var<=$colors_keys[0]){$dest_color = $colors_RGB[0];}
		if($var>=$colors_keys[sizeof($src_colors)-1]){$dest_color = $colors_RGB[sizeof($src_colors)-1];}

		return $dest_color;
	}

	public static function convertColor($color) {
		$hex_RGB='';
		// convert hexadecimal to RGB
		if(!is_array($color) && preg_match("/^[#]([0-9a-fA-F]{6})$/",$color)) {
			$hex_R = substr($color,1,2);
			$hex_G = substr($color,3,2);
			$hex_B = substr($color,5,2);
			$RGB = hexdec($hex_R).",".hexdec($hex_G).",".hexdec($hex_B);

			return $RGB;
		}

		// convert RGB to hexadecimal
		if(!is_array($color)) {
			$color = explode(",",$color);
		}

		foreach($color as $value) {
			$hex_value = dechex($value);
			if(strlen($hex_value)<2) {
				$hex_value="0".$hex_value;
			}
			$hex_RGB.=$hex_value;
		}

		return "#".$hex_RGB;
	}

	public static function getWebSafeColor($color) {
		$color = (0 === strpos($color,'#') ? substr($color,1) : $color);

		$vals['r'] = hexdec(substr($color, 0, 2));
		$vals['g'] = hexdec(substr($color, 2, 2));
		$vals['b'] = hexdec(substr($color, 4, 2));

		$web_safe_color='';

		foreach($vals as $val) {
			$val = ( round($val/51) * 51 );
			$web_safe_color .= str_pad(dechex($val), 2, '0', STR_PAD_LEFT);
		}

		//Logger::log('WEB SAFE COLOR >> '.$web_safe_color);

		return '#'.$web_safe_color;
	}

	public static function getColorsGradient($color='#444444',$_webSafeColors=false)
	{
		$color = Color::cleanColorHex($color);
		$color = (true===$_webSafeColors? Color::getWebSafeColor($color) : $color);

		$user_rgb_color = Color::convertColor($color);

		$user_rgb_color_array = explode(',', $user_rgb_color);
		$user_rgb_color_count = (int) $user_rgb_color_array[0] + (int) $user_rgb_color_array[1] + (int) $user_rgb_color_array[2];

		$gradient_start_color = '255,255,255';

		$colors[] = (((0.213 * (int)$user_rgb_color_array[0]) + (0.715 * (int)$user_rgb_color_array[1]) + (0.072 * (int)$user_rgb_color_array[2])) / 100) < 3 ? '#FFF' : '#666';

		$gradient_end_color = $user_rgb_color;

		$gradient_rgb_color_array = Color::getMidColors($gradient_start_color, $gradient_end_color, 12);
		$gradient_hex_color_array = array();

		foreach($gradient_rgb_color_array as $k => $gradient_rgb_color)
		{
			$gradient_hex_color_array[] = (true===$_webSafeColors?Color::getWebSafeColor(Color::convertColor($gradient_rgb_color)):Color::convertColor($gradient_rgb_color));
		}

		$colors[] = $gradient_hex_color_array[0];
		$colors[] = $gradient_hex_color_array[2];
		$colors[] = $gradient_hex_color_array[5];
		$colors[] = $gradient_hex_color_array[8];
		$colors[] = $gradient_hex_color_array[11];

		return $colors;
	}



}
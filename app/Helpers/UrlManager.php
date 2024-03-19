<?php

/* This helper is for legacy theme compability purposes */

class UrlManager
{


	public static function seo_url($string)
	{

		$string = explode("/", $string);

		if (count($string) > 1) {

			$url = "";

			foreach ($string as $slug) {
				$url .= "/" . str_slug($slug, "-");
			}

			return ltrim($url, "/");
		} else {
			return str_slug($string[0], "-");
		}
	}


	public static function http_protocol($string)
	{

		if (strpos($string, 'http') === false) {
			$string = "http://" . $string;
		}

		return $string;
	}
}

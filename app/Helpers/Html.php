<?php

/**
 * @deprecated deprecated since version 1.0.0
 */
class Html {

	/**
	 * @deprecated deprecated since version 1.0.0
	 */
	public static function cssFile($file){
		return "<link rel='stylesheet' type='text/css' media='all' href='".$file."' />";
	}

	/**
	 * @deprecated deprecated since version 1.0.0
	 */
	public static function jsFile($file){
		return "<script src='".$file."' type='text/javascript' charset='utf-8'></script>";
	}

	/**
	 * @deprecated deprecated since version 1.0.0
	 */
	public static function meta($property,$content){
		return "<meta property='".$property."' content='".$content."' />";
	}

	/**
	 * @deprecated deprecated since version 1.0.0
	 */
	public static function favicon($string){

		$ext = pathinfo($string, PATHINFO_EXTENSION);

		return "<link rel='shortcut icon' type='image/".$ext."' href='".$string."'/>";
	}


}
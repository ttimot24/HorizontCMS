<?php

class Html {


	public static function cssFile($file){
		return "<link rel='stylesheet' type='text/css' media='all' href='".$file."' />";
	}


	public static function jsFile($file){
		return "<script src='".$file."' type='text/javascript' charset='utf-8'></script>";
	}

	public static function meta($property,$content){
		return "<meta property='".$property."' content='".$content."' />";
	}

	public static function favicon($string){

		$ext = pathinfo($string, PATHINFO_EXTENSION);

		return "<link rel='shortcut icon' type='image/".$ext."' href='".$string."'/>";
	}


}
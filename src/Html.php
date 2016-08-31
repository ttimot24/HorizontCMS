<?php

class Html{


	public static function cssFile($file){
		return "<link rel='stylesheet' type='text/css' media='all' href='".$file."' />";
	}


	public static function jsFile($file){
		return "<script src='".$file."' type='text/javascript' charset='utf-8'></script>";
	}

	public static function meta($property,$content){
		return "<meta property='".$property."' content='".$content."' />";
	}

	public static function img($src,$attr=NULL){
		return "<img src='".$src."' ".$attr." />";
	}

	public static function title($string){
		return "<title>".$string."</title>";
	}


	public static function inputField($name,$value,$reguired){
		return "<input type='text' name='".$name."' value='".$value."' ".$required."/>";
	}

	public static function a($name,$link,$attr){
		return "<a href='".$link."' ".$attr.">".$name."</a>";
	}






}




?>
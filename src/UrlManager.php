<?php 

class UrlManager{


	public static function get_slugs(){

		if(isset($_GET['url'])){
			$url = rtrim($_GET['url'],"/"); 
			$url = explode("/",$url);
			return $url;
		}else if(isset($_GET['route'])){
			$url = rtrim($_GET['route'],"/"); 
			$url = explode("/",$url);
			return $url;
		}
		else{
			return NULL;
		}
		
	}



	public static function seo_url($string){

	    $string = strtolower($string);

	 //   $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

	    $string = preg_replace("/[\s-]+/", " ", $string);

	    $string = preg_replace("/[\s_]/", "-", $string);

	    $string = str_replace(str_split(",'?!"), "-", $string);

	    return $string;
	}

	public static function prepare_slug($string){
		return str_replace("-","%",$string);
	}


	public static function http_protocol($string){

		if (strpos($string, 'http') === false) {
		    $string = "http://".$string;
		}

		return $string;
	}


	public static function controller($string){

		return "admin/".$string;
	}





}



?>
<?php 

class UrlManager{


	public static function get_slugs(){

		if(isset($_GET['r'])){
			$url = rtrim($_GET['r'],"/"); 
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

		$string = explode("/",$string);

		if(count($string)>1){

			$url = "";

			foreach ($string as $slug) {
				$url .= "/".str_slug($slug, "-");	
			}

			return ltrim($url,"/");
		}else{
			return str_slug($string[0], "-");
		}

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



}



?>
<?php 

namespace App\Libs;

use App\Model\Plugin;

class PluginManager extends Model{
	
	public static function render($shortcode){
		eval("?>".\App\Libs\ShortCode::resolve($shortcode)."<?php");
	}


	public static function area($area_num){
		
		$plugins = array();

		foreach(\App\Libs\ShortCode::getAll() as $widget){
			if($widget->area==$area_num){

			}
		}

	}


	
}
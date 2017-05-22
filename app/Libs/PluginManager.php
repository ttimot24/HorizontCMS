<?php 

namespace App\Libs;

use App\Model\Plugin;

class PluginManager extends Model{
	
	public static function render($shortcode){
		eval("?>".\App\Libs\ShortCode::resolve($shortcode)."<?php");
	}


	public static function area($area_num){

		foreach(app()->plugins as $widget){
			if($widget->area==$area_num){
				self::render($widget->root_dir);
			}
		}

	}

	
}
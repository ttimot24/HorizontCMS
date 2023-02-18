<?php 

namespace App\Libs;

class PluginManager extends Model{


	public static function area($area_num){

		foreach(app()->plugins as $widget){
			if($widget->area==$area_num){
				echo $widget->getShortCode();
			}
		}

	}

	
}
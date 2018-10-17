<?php 

namespace App\Libs;

use App\Model\Plugin;

class PluginManager extends Model{


	public static function area($area_num){

		foreach(app()->plugins as $widget){
			if($widget->area==$area_num){
				echo $widget->getShortCode();
			}
		}

	}

	
}
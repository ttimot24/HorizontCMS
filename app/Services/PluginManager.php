<?php 

namespace App\Services;

/**
 * @deprecated deprecated since version 1.0.0
 */
class PluginManager extends Model {

	/**
	 * @deprecated deprecated since version 1.0.0
	 */
	public static function area($area_num){

		foreach(app()->plugins as $widget){
			if($widget->area==$area_num){
				echo $widget->getShortCode();
			}
		}

	}

	
}
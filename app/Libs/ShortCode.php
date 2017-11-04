<?php 

namespace App\Libs;

use \App\Model\Plugin as Plugin;

class ShortCode extends Model{

	public $table = 'plugins';
	private static $widgets = array();

	public static function initalize(){

		foreach(app()->plugins as $plugin){


			if(Plugin::exists($plugin->root_dir) && $plugin->hasRegister('widget')){
				\View::addNamespace('plugin', [
												$plugin->getPath()."/app".DIRECTORY_SEPARATOR."View",
												$plugin->getPath()."/app".DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR."views"
												]);

				self::$widgets["{[".$plugin->root_dir."]}"] = $plugin->getRegister('widget');
			}


		}

	}

	public static function getAll(){
		return self::$widgets;
	}

	public static function resolve($shortcode){

		echo isset(self::$widgets["{[".$shortcode."]}"])? self::$widgets["{[".$shortcode."]}"] : "";
	}


	public static function compile($page){

		echo count(self::$widgets) === 0? $page : str_replace(array_keys(self::$widgets), array_values(self::$widgets), $page); 
	}


}
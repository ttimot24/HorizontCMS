<?php 

namespace App\Libs;

use \App\Model\Plugin as Plugin;

class ShortCode extends Model{

	public $table = 'plugins';
	private static $widgets = array();

	public static function initalize(){

		foreach(app()->plugins as $plugin){

			$namespace = "\Plugin\\".$plugin->root_dir."\\Register";

			if(Plugin::exists($plugin->root_dir) && method_exists($namespace, 'widget')){
				\View::addNamespace('plugin', [
												'plugins'.DIRECTORY_SEPARATOR.$plugin->root_dir.DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."View",
												'plugins'.DIRECTORY_SEPARATOR.$plugin->root_dir.DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR."views"
												]);

				self::$widgets["{[".$plugin->root_dir."]}"] = $namespace::widget();
			}


			/*if(Plugin::exists($plugin->root_dir) && $plugin->active==1){
				self::$widgets["{[".str_slug($plugin->root_dir,"_")."]}"] = (new Plugin($plugin->root_dir))->getWidget();
			}*/
		}

	}

	public static function getAll(){
		return self::$widgets;
	}

	public static function resolve($shortcode){

		return isset(self::$widgets["{[".$shortcode."]}"])? eval("?>".self::$widgets["{[".$shortcode."]}"]."<?php") : NULL;
	}


	public static function compile($page){

		return count(self::$widgets) === 0? $page : eval("?>".str_replace(array_keys(self::$widgets), array_values(self::$widgets), $page)."<?php"); 
	}


}
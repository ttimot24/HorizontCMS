<?php 

namespace App\Libs;

class ShortCode extends Model{

	public $table = 'plugins';
	private static $widgets;

	public static function initalize(){

		$all_plugin = self::all();

		foreach($all_plugin as $plugin){
			if(\App\Model\Plugin::exists($plugin->root_dir) && $plugin->active==1){
				self::$widgets[str_slug($plugin->root_dir,"_")] = new \App\Model\Plugin($plugin->root_dir);
			}
		}

	}

	public static function getAll(){
		return self::$widgets;
	}

	public static function resolve($shortcode){

		return isset(self::$widgets[$shortcode])? self::$widgets[$shortcode]->getWidget() : NULL;
	}


	public static function render($page){



	}


}
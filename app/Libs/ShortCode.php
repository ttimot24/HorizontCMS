<?php 

namespace App\Libs;

use \App\Model\Plugin as Plugin;

class ShortCode extends Model{

	public $table = 'plugins';
	private $widgets = array();

	public function initalize(){

		foreach(app()->plugins as $plugin){


			if(Plugin::exists($plugin->root_dir) && $plugin->hasRegister('widget')){
				\View::addNamespace('plugin', [
												$plugin->getPath()."/app".DIRECTORY_SEPARATOR."View",
												$plugin->getPath()."/app".DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR."views"
												]);

				$this->widgets[$plugin->getShortCode()] = $plugin->getRegister('widget');
			}


		}

	}

	public function getAll(){
		return $this->widgets;
	}

	public function resolve($shortcode){

		return isset($this->widgets[$plugin->getShortCode()])? $this->widgets[$plugin->getShortCode()] : "";
	}


	public function compile($page){

		return count($this->widgets) === 0? $page : str_replace(array_keys($this->widgets), array_values($this->widgets), $page); 
	}


}
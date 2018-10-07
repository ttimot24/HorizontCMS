<?php 

namespace App\Libs;

use \App\Model\Plugin as Plugin;

class ShortCode{

	private $widgets = array();

	public function initalize($plugins){

		foreach($plugins as $plugin){


			if(Plugin::exists($plugin->root_dir) && $plugin->hasRegister('widget')){
				\View::addNamespace('plugin', [
												$plugin->getPath()."/app".DIRECTORY_SEPARATOR."View",
												$plugin->getPath()."/app".DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR."views"
												]);

				$this->addWidget($plugin->getShortCode(),$plugin->getRegister('widget'));
			}


		}

	}

	public function addWidget($key,$value){
		$this->widgets[$key] = $value;
	}

	public function getWidget($key){
		return $this->widgets[$key];
	}

	public function getAll(){
		return $this->widgets;
	}

	public function compile($page){

		return count($this->widgets) === 0? $page : str_replace(array_keys($this->widgets), array_values($this->widgets), $page); 
	}


}
<?php 

namespace App\Libs;

use App\Model\Plugin;

class PluginManager{

	protected $container;

	public function installPlugin(Plugin $plugin){
		$plugin->save();
	}

	public function registerPlugin(Plugin $plugin){
		$this->container[] = $plugin;
	}



	
}
<?php 

namespace App\Libs;

use App\Model\Plugin;

class PluginManager{

	protected $container;

	public function registerPlugin(Plugin $plugin){
		$plugin->save();
	}


	
}
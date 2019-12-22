<?php
/*
|--------------------------------------------------------------------------
| HorizontCMS Module Auto Loader
|--------------------------------------------------------------------------
|
| Defines the autoloader for the modules added in config/horizontcms.php
| modules section.
|
*/
function module_loader($class){

	$split = explode("\\",$class);

	$class = array_pop($split);

	//$modules = config('horizontcms.modules',[]);

	$config = require('config'.DIRECTORY_SEPARATOR.'horizontcms.php');

	if(!isset($split[0])){ return; }

	if(!in_array($split[0],array_keys($config['modules']))){ return; }

	$module_base = base_path($config['modules'][$split[0]].DIRECTORY_SEPARATOR.$split[1]);

	$in_app = false;


		foreach(array_slice($split,2) as $each){

				if($in_app){
					$module_base .= DIRECTORY_SEPARATOR.$each;
				}else{
					$module_base .= DIRECTORY_SEPARATOR.strtolower($each);
				}

			if($each=='App'){ $in_app = true; }	
		}


	$file = $module_base.DIRECTORY_SEPARATOR.$class.".php";

	if(file_exists($file)){
		require_once($file);
	}

};
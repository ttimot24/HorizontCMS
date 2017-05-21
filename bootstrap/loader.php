<?php


function module_autoloader($class){

	$split = explode("\\",$class);

	$class = array_pop($split);

	$modules = \Config::get('horizontcms.modules',[]);

	if(!in_array($split[0],array_keys($modules))){ return; }

	$module_base = /*base_path().DIRECTORY_SEPARATOR.*/$modules[$split[0]].DIRECTORY_SEPARATOR.$split[1];

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

}






spl_autoload_register('module_autoloader');





$plugin_autoloaders = glob('plugins/*/vendor/autoload.php');


foreach($plugin_autoloaders as $autoloader){
	require_once($autoloader);
}
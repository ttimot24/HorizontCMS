<?php 

if(file_exists("vendor/autoload.php")){
	require_once("vendor/autoload.php");
}


function __autoload($class){


	$load_paths = [
				"model" => MODEL_DIR.$class.".php",
				"libs" => LIB_DIR.ucfirst($class).".php",
				"helpers" => "src/".ucfirst($class).".php",
				"interface" => "src/Interface/".$class.".php",
				"http" => "src/Http/".$class.".php",
				"plugin" => "plugins/".strtolower($class)."/model/".$class.".php",
				
				];



		if(file_exists($load_paths['model'])){
			require_once($load_paths['model']);	
		}
		else if(file_exists($load_paths['libs'])){
			require_once($load_paths['libs']);
		}
		else if(file_exists($load_paths['helpers'])){
			require_once($load_paths['helpers']);
		}
		else if(file_exists($load_paths['interface'])){
			require_once($load_paths['interface']);
		}
		else if(file_exists($load_paths['http'])){
			require_once($load_paths['http']);
		}
		else if(file_exists($load_paths['plugin'])){
			require_once($load_paths['plugin']);
		}

}





spl_autoload_register('__autoload');
//spl_autoload_register('plugin_dependency_loader');




?>
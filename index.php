<?php 

require_once("core/define.php");
require_once("core/paths.php");
require_once("src/Autoloader.php");

if(file_exists("core/config.php")){
	require_once("core/config.php");
}

try{

	$app = new Horizontcms(
							new Request($_GET,$_POST), 
							new Router()
						  );

	$app->configure(require_once('core/init.php'));


	$app->run();

}
catch(Error $e){
	$e->showException();
}



?>
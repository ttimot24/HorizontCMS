<?php

class Horizontcms{

	protected $config;


	public function __construct(Request $request,Router $router){
		$this->request = $request;
		$this->router = $router;

		if(PHP_VERSION<5.4){
			throw new Error(1,"<b>PHP 5.4.+</b> required. Your version is lower: ".PHP_VERSION);
		}

	}


	public function configure(Array $config){
		$this->config = $config;

		$this->router->setPrefix($this->config['backend_prefix']);
		$this->errorDisplay($this->config['error_reporting']);

	}


	public function run(){



/*		$this->router->set('config',$this->config);

		$this->router->setPrefix($this->config['backend_prefix']);

    	$this->router->resolve($this->request,$this->config['default_controller']);

    	if(!$this->isInstalled() && $this->router->getController() != 'install'){
    		header('Location: admin/install');
    	}

 	 	$this->router->go();
*/


		$url = UrlManager::get_slugs();

		if($this->isInstalled()){

			if($url[0]!=$this->config['backend_prefix']){
				$this->prepareWebsite($url);
			}
			else{
				$this->prepareAdminArea($url);
			}
		}
		else{
				$this->prepareInstall($url);
			}

		

		$controller_file = CONTROLLER_DIR.ucfirst($this->controller).".controller.php";

		if(file_exists($controller_file)){
			require $controller_file;
		}else{
			throw new Error(0,"Can't find <b>".$controller_file."</b> file for <b>".$this->controller."</b> controller!");
			exit;
		}

		$controller_name = ucfirst($this->controller)."Controller";

		$controller = new $controller_name($this->request,$this->config);

		!method_exists($controller, 'before' )? : $controller->before();

		if(isset($this->function)){
			$controller->{$this->function}($this->args);
		}
		else{
			$controller->index();
		}


	}



	public function isInstalled(){
		return file_exists("core/config.php");
	}


	public function prepareInstall($url){

		@array_shift($url);
		@$_GET['url'] = implode("/",$url);

		$this->controller = "install";
		$this->function = isset($url[1])? $url[1] : "index";
		$this->args = '';

	}


	public function prepareWebsite($url){

		$this->controller = "website";
		$this->function = NULL;
		$this->args = !isset($url[2])? : array_slice($url, 2);
	}


	public function prepareAdminArea($url){
		array_shift($url);
		$_GET['url'] = implode("/",$url);
	//	$this->request->setGet('route',$_GET['url']);



		$this->controller = isset($url[0])? $url[0]: $this->config['default_controller'];
		$this->function = isset($url[1]) && $url[1]!=""? $url[1]: NULL;
		$this->args = array_slice($url, 2);
	}



	private function errorDisplay($e){
		error_reporting($e*(-1));
		date_default_timezone_set("Europe/Budapest");
		ini_set('display_startup_errors', $e);
		@ini_set('display_errors', $e);
	}


}




?>
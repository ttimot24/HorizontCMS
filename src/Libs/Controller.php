<?php 

class Controller{


	public function __construct(Request $request, array $config){
		$this->request = $request;
		$this->config = $config;

		$this->load_model('Settings');	
		$language = $this->load_language($this->settings->get_setting('language'));

		Session::start();
		//Session::secure_start();

		$this->childClass = str_replace("Controller","",get_called_class());

		$this->system = new System();

		$this->view = new View(new Navigation(require(CORE_DIR."navs.php"),$language),$language);
		

		if(file_exists("core/config.php") && Session::get('username')!=NULL){
			$this->view->js('resources/scripts/notifications.js');
		}

		
		if(get_called_class()!='LoginController'){
			Security::checkAuth();
	    }


		if(file_exists(MODEL_DIR.$this->childClass.".php")){
			$this->load_model($this->childClass,'model');
		}


		$this->load_plugins();

	}


	public function redirect($path){

		header('Location: http://'.$_SERVER['SERVER_NAME'] .BASE_DIR .$path);
		exit;
	}

	public function redirect_to_self(){
		$redirect = parse_url($_SERVER['HTTP_REFERER']);

		if(BASE_DIR!=DIRECTORY_SEPARATOR){
			$redirect['path'] = str_replace(BASE_DIR,"",$redirect['path']);
		}
		else{
			$redirect['path'] = ltrim($redirect['path'],DIRECTORY_SEPARATOR);
		}

		
		$this->redirect($redirect['path']);
		exit;
	}


	public function __call($function,$args){

		throw new Error(2,"No such function: <b>".$function."</b>");

	}






	public function load_model($class,$name=NULL){

		if(file_exists(MODEL_DIR.$class.".php")){

			isset($name)? : $name=$class;

		//	require_once("model/".$class.".php");

			$this->{strtolower($name)} = new $class();
		}
		else{
			throw new Error(5,'Model not found: <b>'.$class.'</b>');
		}


	}


	public function load_language($language){
		if(file_exists("resources/languages/".strtolower($language).".php")){
			return require_once("resources/languages/".strtolower($language).".php");
		}
		else{
			throw new Error(8,"Can't find language file: <b>".$language."</b>");
		}
	}


	private function load_plugins(){

		$this->load_model('Plugin');
		$current_controller = strtolower($this->childClass);

		foreach($this->plugin->get_all() as $each_plugin){

			if($each_plugin->active==0){continue;}
			if(!file_exists("plugins/".$each_plugin->dir."/config.php")){continue;}
				
				$config = include("plugins/".$each_plugin->dir."/config.php");

				if(isset($config['adminLinks'])){
					$this->view->navigation->mergeCustomMenuItems($config['adminLinks']['mainmenu']);
				}
				
				foreach($config['jsfiles'] as $key => $value){
					if($current_controller == $key){
							$this->view->js("plugins/".$each_plugin->dir."/".$value);
					}else if($key == 'all'){
						$this->view->js("plugins/".$each_plugin->dir."/".$value);
					}
				}

				foreach($config['cssfiles'] as $key => $value){
					if($current_controller == $key){
							$this->view->css("plugins/".$each_plugin->dir."/".$value);
					}else if($key == 'all'){
						$this->view->css("plugins/".$each_plugin->dir."/".$value);
					}
				}





		}

	}










}



?>
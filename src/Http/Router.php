<?php 



class Router{

	protected $controller;

	protected $action;

	protected $args;

	protected $prefix;


	public function resolve(Request $request,$default_controller){
		$this->request = $request;
		$this->default_controller = $default_controller;

		$route = $request->getGet('url',$default_controller);

		$routeAttributes = $this->resolvePrefix(explode('/',$route));


		$this->controller = isset($routeAttributes[0]) && $routeAttributes[0]!=""? $routeAttributes[0]: $default_controller;
		$this->action = isset($routeAttributes[1]) && $routeAttributes[1]!=""? $routeAttributes[1]: NULL;
		$this->args = array_slice($routeAttributes, 2);
		
	}


	public function go(){

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


		if($this->controller == $this->getPrefix()){
			if(isset($this->action)){
				$controller->{$this->action}($this->args);
			}
			else{
				$controller->index();
			}
		}
		else{
			if(method_exists($controller,$this->action)){
				$controller->{$this->action}($this->args);
			}
			else{
				$controller->index();	
			}

		}

	}


	public function setPrefix($pref){
		$this->prefix = $pref;
	}


	private function resolvePrefix($attributes){
		if($attributes[0]==$this->getPrefix()){
			array_shift($attributes);
		}else{
			array_unshift($attributes, 'website');
			if($attributes[1] == $this->getDefaultController()){
				unset($attributes[1]);
				$attributes = array_values($attributes);
			}
		}	
	
		return $attributes;
	}

	public function set($var,$val){
		$this->{$var} = $val;
	}

	public function getPrefix(){
		return $this->prefix;
	}

	public function getController(){
		return $this->controller;
	}


	public function getAction(){
		return $this->action;
	}

	public function getParams(){
		return $this->args;
	}

	public function getDefaultController(){
		return $this->default_controller;
	}


}
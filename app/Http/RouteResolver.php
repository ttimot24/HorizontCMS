<?php 

namespace App\Http;

class RouteResolver{

	private $defaultNamespace = "\App\\Controllers\\";

	public function __construct(){
		$this->resetNamespace();
	}

	public function resetNamespace(){
		$this->namespace = $this->defaultNamespace;
	}

	public function changeNamespace($namespace){
		$this->namespace = $namespace;
	}

	public function resolve($controller = 'dashboard',$action = null, $args = null){

				$action!="" || $action===null ? : $action='index';
		
				$controller_name = studly_case($controller).'Controller';

		        $controllerClass = $this->namespace.$controller_name;


				if(!class_exists($controllerClass)){

					throw new \App\Exceptions\FileNotFoundException('<b>'.$controllerClass.'.php'.'</b>');
				} 


		        $controller = \App::make($controllerClass);

		        $action = studly_case($action);


		      	if(method_exists($controllerClass, 'before')){
		            $controller->callAction('before', [$args]);
		        }


		        if(method_exists($controllerClass, $action)){
		          
		            return $controller->callAction($action, [$args]);
		        }
		        else{
		            throw new \BadMethodCallException("Couldn't find action: <b>".lcfirst($action)."</b>");
		        }

	}











}
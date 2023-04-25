<?php 

namespace App\Http;

class RouteResolver{

	private $defaultNamespace = "\App\\Controllers\\";

	private $namespace;

	public function __construct(){
		$this->resetNamespace();
	}

	public function resetNamespace(){
		$this->namespace = $this->defaultNamespace;
	}

	public function changeNamespace($namespace){
		$this->namespace = $namespace;
	}


	public function resolveControllerClass($controller){

		$controller_name = studly_case($controller).'Controller';

		$controllerClass = $this->namespace.$controller_name;


		if(!class_exists($controllerClass)){

			throw new \App\Exceptions\FileNotFoundException('<b>'.$controllerClass.'.php'.'</b>');
		} 

		return $controllerClass;
	}


	public function resolve($controller = 'dashboard',$action = null, $args = null){

				$action!="" || $action===null ? : $action='index';		

		        $controllerClass = \App::make($this->resolveControllerClass($controller));

		        $action = studly_case($action);


		      	if(method_exists($controllerClass, 'before')){
		            $controllerClass->callAction('before', [$args]);
		        }


		        if(method_exists($controllerClass, $action)){
		          
		            return $controllerClass->callAction($action, [$args]);
		        }
		        else{
		            throw new \BadMethodCallException("Couldn't find action: <b>".lcfirst($action)."</b>");
		        }

	}











}
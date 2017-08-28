<?php 

namespace App\Http;

class RouteResolver{

	private $namespace = "\App\\Controllers\\";

	public function changeNamespace($namespace){
		$this->namespace = $namespace;
	}


	public function resolve($controller = 'dashboard',$action = 'index', $args = null){

				$action!=""? : $action='index';
		
				$controller_path = lcfirst(ltrim(str_replace("\\",DIRECTORY_SEPARATOR,camel_case($this->namespace)),DIRECTORY_SEPARATOR));
				$controller_name = studly_case($controller).'Controller';

		        $controllerClass = $this->namespace.$controller_name;

				//if(!file_exists($controller_path.$controller_name.'.php')){
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
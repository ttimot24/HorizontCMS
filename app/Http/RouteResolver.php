<?php 

namespace App\Http;

class RouteResolver{


	public function resolve($controller = 'dashboard',$action = 'index', $args = null){

				$controller_name = ucfirst($controller).'Controller';

				if(!file_exists('app'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controller_name.'.php')){
					throw new \Exception('No such file <b>'.$controller_name.'.php'.'</b>');
				} 

		        $controllerClass = 'App\\Controllers\\'.$controller_name;
		        $controller = \App::make($controllerClass);

		        $action = studly_case($action);
		        

		      	if(method_exists($controllerClass, 'before')){
		            $controller->callAction('before', [$args]);
		        }

		        if(method_exists($controllerClass, $action)){
		          
		            return $controller->callAction($action, [$args]);
		        }
		        else{
		            throw new \Exception("Couldn't find action: <b>".$action."</b>");
		        }

	}











}
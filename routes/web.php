<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::any('/{slug?}/{args?}',function($slug="",$args = null){

	$route = new \App\Http\RouteResolver();

	try{

		$route->changeNamespace("Theme\\".Settings::get('theme')."\\App\\Controllers\\");

		$action = explode("/",$args)[0];

		return $route->resolve($slug,$action,ltrim($args,$action."/"));

	}catch(Exception $e){


		$controller = \App::make('\App\Controllers\WebsiteController');

		$controller->before();

		if(method_exists($controller, $slug)){
			          
			return $controller->callAction($slug, [$slug,$args]);
		}


		return $controller->callAction('index',[$slug,$args]);

	}


})->where('args', '(.*)');



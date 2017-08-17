<?php

Route::group(['prefix'=>'/install'],function(){

	Route::any('/{action?}/{args?}/', 
		function($action = 'index', $args = null){

		       $route = new \App\Http\RouteResolver();

		        return $route->resolve('install',$action,$args);

  		 })->where('args', '(.*)');
	
});



Route::auth();



Route::group(['middleware' => ['admin','plugin']],function(){


	Route::any('/plugin/run/{plugin}/{controller?}/{action?}/{args?}/', 
		function($plugin,$controller = 'start', $action = 'index', $args = null){

		       $route = new \App\Http\RouteResolver();

		       $route->changeNamespace("\Plugin\\".studly_case($plugin)."\\App\\Controllers\\");

		       return $route->resolve($controller,$action,$args);

  		 })->where('args', '(.*)');
	



	Route::any('/{controller?}/{action?}/{args?}/', 
		function($controller = 'dashboard', $action = 'index', $args = null){

		       $route = new \App\Http\RouteResolver();

		        return $route->resolve($controller,$action,$args);

  		 })->where('args', '(.*)');
	
});
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

Route::get('/laravelwelcome', function () {
    return view('auth.welcome');
});


Route::group(['prefix'=> Config::get('horizontcms.backend_prefix').'/install'],function(){

	Route::any('/{action?}/{args?}/', 
		function($action = 'index', $args = null){

		       $route = new \App\Http\RouteResolver();

		        return $route->resolve('install',$action,$args);

  		 })->where('args', '(.*)');
	
});


Route::get('admin/register', 'Auth\RegisterController@showRegistrationForm');

Route::post('admin/register', 'Auth\RegisterController@register');

Route::get('admin/login', 'Auth\LoginController@showLoginForm');

Route::post('admin/login', 'Auth\LoginController@login');

Route::post('admin/logout', 'Auth\LoginController@logout');


Route::group(['prefix'=> Config::get('horizontcms.backend_prefix'),'middleware' => 'admin'],function(){

	Route::any('/{controller?}/{action?}/{args?}/', 
		function($controller = 'dashboard', $action = 'index', $args = null){

		       $route = new \App\Http\RouteResolver();

		        return $route->resolve($controller,$action,$args);

  		 })->where('args', '(.*)');
	
});


Route::any('/{slug?}', 'WebsiteController@index')->where('slug', '(.*)');



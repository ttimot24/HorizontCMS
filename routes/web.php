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
    return view('welcome');
});


//Auth::routes();


Route::group(['prefix'=>'install'],function(){
	///Route::any('/{controller?}/{action?}/{args?}', 'InstallController@index')->where('args', '(.*)');
});


Route::get('admin/register', 'Auth\RegisterController@showRegistrationForm');

Route::post('admin/register', 'Auth\RegisterController@register');

Route::get('admin/login', 'Auth\LoginController@showLoginForm');

Route::post('admin/login', 'Auth\LoginController@login');

Route::post('admin/logout', 'Auth\LoginController@logout');


Route::group(['prefix'=> Config::get('horizontcms.backend_prefix'),'middleware' => 'auth'],function(){

	Route::any('/{controller?}/{action?}/{args?}/', 
		function($controller, $action = 'index', $args = null){
		        $controllerClass = 'App\\Http\\Controllers\\'.ucfirst($controller).'Controller';

		        $action = studly_case($action); // optional, converts foo-bar into FooBar for example

		        if(method_exists($controllerClass, $action)){
		            $controller = App::make($controllerClass);
		            return $controller->callAction($action, [$args]);
		        }
		        else{
		            return "Can't find controller action!";
		        }
  		 })->where('args', '(.*)');
	
});


Route::any('/{slug?}', 'WebsiteController@index')->where('slug', '(.*)');



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
		function($controller = 'dashboard', $action = 'index', $args = null){

				if(!file_exists('app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.ucfirst($controller).'Controller.php')){
					throw new Exception('No such file <b>'.ucfirst($controller).'Controller.php'.'</b>');
				} 

		        $controllerClass = 'App\\Http\\Controllers\\'.ucfirst($controller).'Controller';

		        $action = studly_case($action); // optional, converts foo-bar into FooBar for example

		        if(method_exists($controllerClass, $action)){
		            $controller = App::make($controllerClass);
		            return $controller->callAction($action, [$args]);
		        }
		        else{
		            throw new Exception("Couldn't find action: <b>".$action."</b>");
		        }
  		 })->where('args', '(.*)');
	
});


Route::any('/{slug?}', 'WebsiteController@index')->where('slug', '(.*)');



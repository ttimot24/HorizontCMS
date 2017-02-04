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


//Route::any('/{slug?}','\App\Controllers\WebsiteController@index')->where('slug', '(.*)');

Route::any('/{slug?}/{args?}',function($slug="",$args = null){

	$controller = \App::make('\App\Controllers\WebsiteController');

	if(method_exists($controller, $slug)){
		          
		return $controller->callAction($slug, [$slug,$args]);
	}


	return $controller->callAction('index',[$slug,$args]);
})->where('args', '(.*)');



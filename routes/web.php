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


Route::any('/{slug?}','\App\Controllers\WebsiteController@index')->where('slug', '(.*)');



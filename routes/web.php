<?php

use Illuminate\Support\Facades\Route;
use \App\Model\Settings;
use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;

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

/* Route::group(['prefix'=>'/'],function(){
	Route::resource('/', \App\Controllers\WebsiteController::class);
}); */

$_THEME_NAME = Settings::get('theme');

if (!defined('THEME_CONTROLLER_PATH')) {
	define('THEME_CONTROLLER_PATH', 'themes'.DIRECTORY_SEPARATOR.$_THEME_NAME.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Controllers');
}

foreach(array_diff(scandir(THEME_CONTROLLER_PATH), ['.', '..', 'WebsiteController.php']) as $file){
	if(is_file(THEME_CONTROLLER_PATH."/".$file)){
		$actualName = pathinfo($file, PATHINFO_FILENAME);
		$controller_route = strtolower(str_replace("Controller","",$actualName));


		Route::resource("/".$controller_route , "\Theme\\".$_THEME_NAME."\App\Controllers\\".$actualName )
		->names(collect(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])->mapWithKeys(function($item) use ($controller_route){
			return [$item => 'theme.'.$controller_route.'.'.$item];
		})->toArray());
	}
}

Route::any('/{slug?}/{args?}', function ($slug = "", $args = null, Request $request, Container $container) {

	try {

		try {

			$this->router->changeNamespace("Theme\\" . Settings::get('theme') . "\\App\\Controllers\\");

			$action = explode("/", $args)[0];

			return $this->router->resolve($slug, $action, ltrim($args, $action . "/"));
		} catch (Exception $e) {


			if ($e instanceof \App\Exceptions\FileNotFoundException || $e instanceof BadMethodCallException) {

				$controller = \App::make('\App\Controllers\WebsiteController');

				$controller->before();

				if (method_exists($controller, $slug)) {

					return $controller->callAction($slug, [$slug, $args]);
				}

				
				//TODO change to show method
				return $controller->callAction('show', [$slug, $args]);
			}


			throw $e;
		}
	} catch (Exception $e) {
		$handler = new \App\Exceptions\WebsiteExceptionHandler($container);

		return $handler->render($request, $e);
	}
})->where('args', '(.*)');

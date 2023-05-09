<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const CONTROLLER_PATH = 'app'.DIRECTORY_SEPARATOR.'Controllers';

Route::group(['prefix'=>'/install'],function(){

	Route::any('/{action?}/{args?}/', 
		function($action = 'index', $args = null){

		        return $this->router->resolve('install',$action,$args);

  		 })->where('args', '(.*)');
	
});

Route::auth();

Route::group(['middleware' => ['admin','plugin','can:global-authorization']],function(){

	app()->plugins->each(function($plugin){

		foreach(array_diff(scandir($plugin->getPath().DIRECTORY_SEPARATOR.CONTROLLER_PATH), ['.', '..']) as $file){
			if(is_file($plugin->getPath().DIRECTORY_SEPARATOR.CONTROLLER_PATH."/".$file)){
				$actualName = pathinfo($file, PATHINFO_FILENAME);

				$plugin_name_prefix = 'plugin.'.str_slug($plugin->root_dir).'.'.strtolower(str_replace("Controller","",$actualName));

				Route::resource(
					"/plugin/".str_slug($plugin->root_dir).'/'.strtolower(str_replace("Controller","",$actualName)), 
					"\Plugin\\".studly_case($plugin->root_dir)."\\App\\Controllers\\".$actualName 
				)->names(collect(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])->mapWithKeys(function($item) use ($plugin_name_prefix){
					return [$item => $plugin_name_prefix.'.'.$item];
				})->toArray())
					->missing(function (Request $request) {

					});

			}
		}

	});
	

	foreach(array_diff(scandir(CONTROLLER_PATH), ['.', '..']) as $file){
		if(is_file(CONTROLLER_PATH."/".$file)){
			$actualName = pathinfo($file, PATHINFO_FILENAME);
			Route::resource("/".strtolower(str_replace("Controller","",$actualName)), "\App\Controllers\\".$actualName )
					->missing(function (Request $request) {
						return redirect('admin/dashboard/notfound');
					});
		}
	}


	Route::any('/plugin/run/{plugin}/{controller?}/{action?}/{args?}/', 
		function($plugin,$controller = 'start', $action = 'index', $args = null){

		       $this->router->changeNamespace("\Plugin\\".studly_case($plugin)."\\App\\Controllers\\");

		       return $this->router->resolve($controller,$action,$args);

  		 })->where('args', '(.*)');


	Route::any('/{controller?}/{action?}/{args?}/', 
		function($controller = 'dashboard', $action = 'index', $args = null){

		        return $this->router->resolve($controller,$action,$args);

  		 })->where('args', '(.*)');
	
});
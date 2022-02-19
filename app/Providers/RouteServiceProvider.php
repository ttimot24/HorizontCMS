<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    //protected $namespace = 'App\Http\Controllers';
    protected $namespace = 'App\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->router = new \App\Http\RouteResolver();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapPluginRoutes();

        $this->mapBackendRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => ['website','web'],
           // 'namespace' => 'Theme\\'.\Settings::get('theme').'\\App\Controllers',
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api/v1',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }


    protected function mapBackendRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
            'prefix' => \Config::get('horizontcms.backend_prefix'),
        ], function ($router) {
            require base_path('routes/backend.php');
        });
    }


    protected function mapPluginRoutes(){

    	if(!isset($this->app->plugins)){ return false; }

    	foreach($this->app->plugins as $plugin){

    		if(file_exists($plugin->getPath().'/routes/plugin.php')){

                $options = $plugin->getRegister('routeOptions',[]);

		        Route::group([
                    'middleware' => isset($options['middleware'])? $options['middleware'] : "",
                    'namespace' => isset($options['namespace'])? $options['namespace'] : "",
                    'prefix' => isset($options['prefix'])? $options['prefix'] : "",
                    ], function($router) use ($plugin) {
		            require base_path($plugin->getPath().'/routes/plugin.php');
		        });

	    	}

		}

    }


}

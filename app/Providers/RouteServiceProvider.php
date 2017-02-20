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
            'middleware' => ['web'],
          // 'namespace' => 'Theme\\'.\Settings::get('theme').'\\Controllers',
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
            'prefix' => 'api',
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


    	foreach($this->app->plugins as $plugin){

    		if(file_exists('plugins/'.$plugin->root_dir.'/routes/plugin.php')){

    			$namespace = "\\Plugin\\".$plugin->root_dir."\Register";

	    		$options = method_exists($namespace, 'routeOptions')? $namespace::routeOptions() : [];

		        Route::group($options, function ($router) use ($plugin) {
		            require base_path('plugins/'.$plugin->root_dir.'/routes/plugin.php');
		        });

	    	}

		}

    }


}

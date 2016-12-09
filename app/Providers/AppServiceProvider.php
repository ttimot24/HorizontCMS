<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        if (env('APP_ENV') === 'local') {
                \DB::connection()->enableQueryLog();
            }
            if (env('APP_ENV') === 'local') {
                \Event::listen('kernel.handled', function ($request, $response) {
                    if ( $request->has('sql-debug') ) {
                        $queries = \DB::getQueryLog();
                        dd($queries);
                    }
                });
            }


        if(\App\HorizontCMS::isInstalled()){
    	  
           if(\Request::is(\Config::get('horizontcms.backend_prefix')."/plugin/run/*")){
                $plugin_name = studly_case(explode("/",str_replace(\Config::get('horizontcms.backend_prefix')."/plugin/run/","",\Request::path()))[0]);
               
                $this->loadTranslationsFrom(base_path("/plugins/".$plugin_name."/lang"), 'plugin');
            }else if(!\Request::is(\Config::get('horizontcms.backend_prefix')."/*")){
                $this->loadTranslationsFrom(base_path("/themes/".\App\Model\Settings::get('theme')."/lang"), 'website');
            }
        }
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

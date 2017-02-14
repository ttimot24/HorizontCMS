<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    
        if($this->app->isInstalled()){
            $this->app->plugins = \App\Model\Plugin::where('active','1')->get();
        }
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


    }
}

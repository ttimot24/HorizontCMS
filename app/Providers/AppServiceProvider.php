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

    	$this->loadTranslationsFrom(base_path("/themes/".\App\Model\Settings::get('theme')."/lang"), 'website');
        //DB::listen(function ($query) {
            //catch all sql that runs inside the app;
        //});
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

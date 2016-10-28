<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LoaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       require_once base_path().'/app/Helpers/Functions/link.php';
    }
}

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

        if ($this->app->environment("local")) {
                \DB::connection()->enableQueryLog();
            }
            if ($this->app->environment("local")) {
                \Event::listen('kernel.handled', function ($request, $response) {
                    if ( $request->has('sql-debug') ) {
                        $queries = \DB::getQueryLog();
                        dd($queries);
                    }
                });
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

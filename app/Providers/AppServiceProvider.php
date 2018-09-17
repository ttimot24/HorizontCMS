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

        if ($this->app->environment("local") || $this->app->environment("testing") ) {
                \DB::connection()->enableQueryLog();

                \Event::listen('kernel.handled', function ($request, $response) {
                    if ( $request->has('sql-debug') ) {
                        $queries = \DB::getQueryLog();
                        dd($queries);
                    }
                });


                $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
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

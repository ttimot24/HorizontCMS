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

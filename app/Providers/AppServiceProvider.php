<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Events\RequestHandled;

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

                if ( $this->app->request->has('sql-debug') ) {
                    \Event::listen(RequestHandled::class, function(RequestHandled $event) {
                            $queries = \DB::getQueryLog();
                            dd($queries);
                    });
                }

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

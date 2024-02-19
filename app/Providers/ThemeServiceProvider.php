<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // For website
        if (!app()->runningInConsole() && !\Request::is(\Config::get('horizontcms.backend_prefix') . "/*")) {
            $theme = \App\Model\Settings::get('theme');
            $this->loadJsonTranslationsFrom(base_path("themes/" . $theme . "/resources/lang"));
        }

        // For everything
        if(!app()->runningInConsole()){
            $theme = \App\Model\Settings::get('theme');
            \View::addNamespace('theme', [
                "themes/".$theme."/app".DIRECTORY_SEPARATOR."View",
                "themes/".$theme."/resources".DIRECTORY_SEPARATOR."views",
            ]);
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

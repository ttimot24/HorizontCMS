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

        if (!\Request::is(\Config::get('horizontcms.backend_prefix') . "/*")) {
            $theme = \App\Model\Settings::get('theme');
            $this->loadJsonTranslationsFrom(base_path("themes/" . $theme . "/resources/lang"));
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

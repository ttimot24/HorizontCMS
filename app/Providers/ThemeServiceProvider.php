<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use \App\Services\Theme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->isInstalled()) {

            $theme = new Theme(\App\Model\Settings::get('theme'));

            $this->app->singleton(Theme::class, function ($app) use($theme) {
                return $theme;
            });


            $this->registerTranslations($theme);

            $this->registerThemeViews($theme);

            $this->registerThemeRoutes($theme);

        }
    }

    protected function registerTranslations(Theme $theme){
        if (!\Request::is(\Config::get('horizontcms.backend_prefix') . "/*")) {
            $this->loadJsonTranslationsFrom(base_path($theme->getPath() . "resources/lang"));
        }
    }

    protected function registerThemeViews(Theme $theme){
        \View::addNamespace('theme', [
            $theme->getPath() . "app" . DIRECTORY_SEPARATOR . "View",
            $theme->getPath() . "resources" . DIRECTORY_SEPARATOR . "views",
        ]);
    }

    protected function registerThemeRoutes(Theme $theme)
    {

        if (file_exists($theme->getPath() . 'routes/web.php')) {

            Route::group(
                ['middleware' => 'web'],
                function ($router) use ($theme) {
                    require base_path($theme->getPath() . '/routes/web.php');
                }
            );
        }

        if (file_exists($theme->getPath() . 'routes/api.php')) {

            Route::group(
                ['middleware' => 'api'],
                function ($router) use ($theme) {
                    require base_path($theme->getPath() . '/routes/api.php');
                }
            );
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

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

            $this->app->singleton(Theme::class, function ($app) use ($theme) {
                return $theme;
            });

            $this->registerThemeAutoLoaders($theme);

            $this->registerTranslations($theme);

            $this->registerThemeViews($theme);

            $this->registerThemeRoutes($theme);

            $this->registerThemeConsoleCommands($theme);
        }
    }

    private function registerThemeAutoLoaders(Theme $theme)
    {




        $autoloader = $theme->getPath() . "/vendor/autoload.php";
        if (file_exists($autoloader)) {
            require_once($autoloader);
        }
    }

    protected function registerTranslations(Theme $theme)
    {
        if (!\Request::is(\Config::get('horizontcms.backend_prefix') . "/*")) {
            $this->loadJsonTranslationsFrom(base_path($theme->getPath() . "resources/lang"));
        }
    }

    protected function registerThemeViews(Theme $theme)
    {
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

    private function registerThemeConsoleCommands(Theme $theme)
    {

        try {
            $_THEME_COMMANDS_PATH = $theme->getPath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Console';

            foreach (array_diff(scandir($_THEME_COMMANDS_PATH), ['.', '..']) as $file) {
                if (is_file($_THEME_COMMANDS_PATH . "/" . $file)) {

                    require_once($_THEME_COMMANDS_PATH . "/" . $file);
                    $actualName = pathinfo($file, PATHINFO_FILENAME);

                    if (class_exists("\Theme\\" . $theme->getName() . "\App\Console\\" . $actualName, true)) {
                        $this->commands(["\Theme\\" . $theme->getName() . "\App\Console\\" . $actualName]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}
}

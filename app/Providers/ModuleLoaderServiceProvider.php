<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleLoaderServiceProvider extends ServiceProvider
{
   
    private $moduleLoader;


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){

        $this->moduleLoader = require_once(base_path('bootstrap'.DIRECTORY_SEPARATOR.'loader.php'));
    
    }



    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

       spl_autoload_register($this->moduleLoader);


       require_once app_path('Helpers/Functions/link.php');

       
       foreach(glob('plugins/*/vendor/autoload.php') as $autoloader){
            require_once($autoloader);
       }


    }

}

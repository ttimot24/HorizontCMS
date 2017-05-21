<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    
        if($this->app->isInstalled()){
            $this->app->plugins = \App\Model\Plugin::where('active','1')->get();


            $this->registerPluginProviders();
            $this->registerPluginEvents();
            $this->registerPluginLanguage();


        }
        
    }



    private function registerPluginProviders(){

            foreach($this->app->plugins as $plugin){

                $register_namespace = $plugin->getRegisterClass();

                if(method_exists($register_namespace,'addProviders')){
                    foreach($register_namespace::addProviders() as $provider){
                        $this->app->register($provider);
                    }
                }

            }

    }



    public function registerPluginEvents(){

             foreach($this->app->plugins as $plugin){

                $plugin_namespace = $plugin->getRegisterClass();

                if(!method_exists($plugin_namespace,'eventHooks')){
                    continue;
                }

                foreach($plugin_namespace::eventHooks() as $key => $value){
                    foreach($value as $do){
                        \Event::listen($key,$do);
                    }
                }


             }

    }



    private function registerPluginLanguage(){

           if(\Request::is(\Config::get('horizontcms.backend_prefix')."/plugin/run/*")){
                $plugin_name = studly_case(explode("/",str_replace(\Config::get('horizontcms.backend_prefix')."/plugin/run/","",\Request::path()))[0]);
               
                $this->loadTranslationsFrom(base_path("/plugins/".$plugin_name."/resources/lang"), 'plugin');
            }else if(!\Request::is(\Config::get('horizontcms.backend_prefix')."/*")){
                $this->loadTranslationsFrom(base_path("/themes/".\App\Model\Settings::get('theme')."/lang"), 'website');
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

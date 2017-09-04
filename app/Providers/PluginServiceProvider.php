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

                foreach($plugin->getRegister('addProviders',[]) as $provider){
                    $this->app->register($provider);
                }

            }

    }



    public function registerPluginEvents(){

             foreach($this->app->plugins as $plugin){

                foreach($plugin->getRegister('eventHooks',[]) as $key => $value){
                    foreach($value as $do){
                        \Event::listen($key,$do);
                    }
                }


             }

    }



    private function registerPluginLanguage(){

           if(\Request::is(\Config::get('horizontcms.backend_prefix')."/plugin/run/*")){
      
                $plugin_name = studly_case(\Request::segment(4));

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

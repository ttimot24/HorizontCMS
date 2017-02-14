<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],

        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UserEventListener@countLogin',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {


    if(\App\HorizontCMS::isInstalled()){
        //$all_plugin = \App\Model\Plugin::where('active','1')->get();


      //  if($this->app->plugins->count()>0){
            
             foreach($this->app->plugins as $plugin){

                $plugin_namespace = "\Plugin\\".$plugin->root_dir."\Register";

                if(!method_exists($plugin_namespace,'eventHooks')){
                    continue;
                }


                $this->listen = array_merge_recursive($this->listen,$plugin_namespace::eventHooks());


             }
            
      //  }
    }


        parent::boot();

        //
    }
}

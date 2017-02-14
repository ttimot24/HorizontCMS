<?php

namespace App\Http\Middleware;

use Closure;

class NavbarPluginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

       // $all_plugin = \App\Model\Plugin::where('active','1')->get();

        if(!app()->plugins->isEmpty()){

            $main_menu = \Menu::get('MainMenu');
            $right_menu = \Menu::get('RightMenu');

            foreach(app()->plugins as $plugin){

                $plugin_namespace = "\Plugin\\".$plugin->root_dir."\Register";

                if(!method_exists($plugin_namespace,'navigation')){
                    continue;
                }

                $plugin_nav = $plugin_namespace::navigation();

                foreach($plugin_nav as $key => $item){

                  if(!isset($item['menu']) || $item['menu']=='main'){  
                    if(isset($item['submenu_of'])){
                        $main_menu->find($item['submenu_of'])->add($item['label'],$item['url'])->id($key);
                    }
                    else{
                        $main_menu->add($item['label'],$item['url'])->id($key);
                    }
                  }else if(isset($item['menu']) && $item['menu']=='right'){
                    if(isset($item['submenu_of'])){
                        $right_menu->find($item['submenu_of'])->add($item['label'],$item['url'])->id($key);
                    }
                    else{
                        $right_menu->add($item['label'],$item['url'])->id($key);
                    }
                  }
                }
            }
        }

        return $next($request);
    }
}

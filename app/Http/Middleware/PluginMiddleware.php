<?php

namespace App\Http\Middleware;

use Closure;

class PluginMiddleware
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


        if($request->is(config('horizontcms.backend_prefix')."/plugin/run/*")){

            $plugin = app()->plugins->get(studly_case($request->segment(4)));

            if(isset($plugin)){

                \View::addNamespace('plugin', [
                                            $plugin->getPath().DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."View",
                                            $plugin->getPath().DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR."views",
                                        ]);
            }

        }


        return $next($request);
    }
}

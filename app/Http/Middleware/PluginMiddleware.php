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

        $plugin_name = studly_case(explode("/",str_replace(\Config::get('horizontcms.backend_prefix')."/plugin/run/","",$request->path()))[0]);

        \View::addNamespace('plugin', [
                                        'plugins'.DIRECTORY_SEPARATOR.$plugin_name.DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."View",
                                        'plugins'.DIRECTORY_SEPARATOR.$plugin_name.DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR."views",
                                    ]);
        return $next($request);
    }
}

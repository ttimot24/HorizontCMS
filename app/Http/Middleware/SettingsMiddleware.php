<?php

namespace App\Http\Middleware;

use Closure;

class SettingsMiddleware
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

        if(\App\HorizontCMS::isInstalled()){
            $settings = new \App\Model\Settings();
            $settings->assignAll();
            $request->settings = json_decode(json_encode($settings->settings), true);
        }


        return $next($request);
    }
}

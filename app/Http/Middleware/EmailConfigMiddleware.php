<?php

namespace App\Http\Middleware;

use Closure;

class EmailConfigMiddleware
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
        //    \Config::set('mail.from.address',$request->settings['default_email']);
         //   \Config::set('mail.from.name',$request->settings['site_name']);
        }


        return $next($request);
    }
}

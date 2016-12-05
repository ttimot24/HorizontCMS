<?php

namespace App\Http\Middleware;

use Closure;

class InstallerMiddleware
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
        
        if(!\App\HorizontCMS::isInstalled() && strpos(\Request::path(), \Config::get('horizontcms.backend_prefix').'/install') === false){
          
            \Auth::logout();
            return redirect(\Config::get('horizontcms.backend_prefix').'/install');

        }else if(\App\HorizontCMS::isInstalled() && strpos(\Request::path(), \Config::get('horizontcms.backend_prefix').'/install') !== false){
           
            return redirect(\Config::get('horizontcms.backend_prefix').'/login');
        }

        return $next($request);
    }
}

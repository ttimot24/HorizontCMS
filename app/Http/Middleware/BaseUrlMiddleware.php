<?php

namespace App\Http\Middleware;

use Closure;

class BaseUrlMiddleware
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

        $base_url = "//".$request->headers->get('host').$request->getBaseUrl()."/";
        \Config::set('app.url',$base_url);


        return $next($request);
    }
}

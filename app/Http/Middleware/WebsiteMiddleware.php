<?php

namespace App\Http\Middleware;

use Closure;

class WebsiteMiddleware
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
        $response = $next($request);

        $widgets = new \App\Libs\ShortCode();
        $widgets->initalize(app()->plugins);

        $response->setContent($widgets->compile($response->getContent()));

        return $response;
    }
}

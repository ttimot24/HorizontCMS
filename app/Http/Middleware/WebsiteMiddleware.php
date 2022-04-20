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


        \View::addNamespace('theme', [
            "themes/".$request->settings['theme']."/app".DIRECTORY_SEPARATOR."View",
            "themes/".$request->settings['theme']."/resources".DIRECTORY_SEPARATOR."views",
        ]);

        $response = $next($request);

        $widgets = new \App\Libs\ShortCode();
        $widgets->initalize(app()->plugins);

        $response->setContent($widgets->compile($response->getContent()));

        return $response;
    }
}

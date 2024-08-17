<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebsiteMiddleware
{

    private $widgets;

    public function __construct(\App\Libs\ShortCode $shortcode_engine){
        $this->widgets = $shortcode_engine;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $this->widgets->initalize(app()->plugins);

        $response->setContent($this->widgets->compile($response->getContent()));

        return $response;
    }
}

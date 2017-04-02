<?php

namespace App\Http\Middleware;

use Closure;

class HttpsMiddleware
{

    public function handle($request, Closure $next){

        if(\App\HorizontCMS::isInstalled()){

	        if (\Settings::get('use_https')==1 && !$request->secure()) {
	            return redirect()->secure($request->getRequestUri());
	        }

	        if(\Settings::get('use_https')==1){
	        	\URL::forceSchema('https');
	        }

   		}

        return $next($request); 
    }

}
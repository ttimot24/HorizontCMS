<?php

namespace App\Http\Middleware;

use Closure;

class HttpsMiddleware
{

    public function handle($request, Closure $next){

        if(\App\HorizontCMS::isInstalled()){

	        if ($request->settings['use_https']==1 && !$request->secure()) {
	            return redirect()->secure($request->getRequestUri());
	        }

	        if($request->settings['use_https']==1){
	        	\URL::forceScheme('https');
	        }

   		}

        return $next($request); 
    }

}
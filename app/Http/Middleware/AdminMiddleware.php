<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        
        if(!$request->user()->isAdmin() || !$request->user()->isActive()){

            \Auth::logout();
            return redirect()->back();
        }

        return $next($request);
    }
}

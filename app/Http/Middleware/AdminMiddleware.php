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
        
        if(!$request->user()->hasRole('admin_area')){

            \Auth::logout();
            return redirect()->back();
        }

        return $next($request);
    }
}

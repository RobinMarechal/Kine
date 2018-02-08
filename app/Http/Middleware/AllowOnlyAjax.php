<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class AllowOnlyAjax
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
        if(env("APP_DEBUG") == true)
            return $next($request);

    	if(!$request->ajax()){
            return response(view('errors.404'));
        }

        return $next($request);
    }
}

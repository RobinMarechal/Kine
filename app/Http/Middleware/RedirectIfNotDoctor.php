<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class RedirectIfNotDoctor
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
		if(!isAdmin())
		{
		    if($request->ajax()){
                return response('Unauthorized.', 401);
            }

			Flash::error('Cette section est réservée aux administrateurs.');
			return Redirect::back();
		}

		return $next($request);
	}
}

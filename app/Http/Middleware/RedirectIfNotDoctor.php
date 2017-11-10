<?php

namespace App\Http\Middleware;

use Closure;

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
			Flash::error('Cette section est réservée aux administrateurs.');
			return Redirect::back();
		}

		return $next($request);
	}
}

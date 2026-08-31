<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogoutProCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {  		
		if(empty(session()->has('user_data')))
		{
			 return redirect('login');
		}
		
		header('Cache-Control: no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');
		header('Expires: 0');
        return $next($request);
		
		
    }
}

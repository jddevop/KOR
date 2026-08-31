<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogoutAdminCheckMiddleware
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
		if(empty(session()->has('admin_data')))
		{
			 return redirect('admin/login');
		}
		header('Cache-Control: no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');
		header('Expires: 0');
        return $next($request);
    }
}

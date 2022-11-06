<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Can
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $action
     * @param $section
     * @return mixed
     */
    public function handle($request, Closure $next, $action, $section)
    {
        return $next($request)
        	->header('Access-Control-Allow-Origin', '*')
	        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}

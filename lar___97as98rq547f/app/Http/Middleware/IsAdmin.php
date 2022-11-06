<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
{
    
    $host = $request->getHttpHost();
    
    if( $host == 'en.setaat.com' ){
        return redirect( 'https://www.setaat.com/admin' );
    }
    
     if ( !Auth::user()  ||  Auth::user()->role_id == null) {
         return abort(404); 
     }else{
         if( Auth::user()->role_id == 8 ){
             return abort(404);
         }
         
         

            return $next($request);
     }

    return redirect('/');
}
}
<?php

namespace App\Http\Middleware;

use Closure;
use Mobile;
use Route;

class Lang
{
    public function handle($request, Closure $next)
{ 

            $pieces = explode('.', $request->getHost());
            $lang = trim($pieces[0]);
            $lang = strtolower($lang);
            if( $lang == 'en' ){ 
                \App::setLocale('en'); 
             }else{
                $session = session('locale');
                $url = $request->url();

                if( $session  && strpos($url, '/admin') !== false ){
                    \App::setLocale( $session );
                }else{
                    \App::setLocale('ar');
                }

            }

            \session( ['locale' => \App::getLocale() ] );
    return $next($request);

}

    
}
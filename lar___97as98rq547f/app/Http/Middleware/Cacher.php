<?php

namespace App\Http\Middleware;
 
use Closure;
use Cache;
use Mobile;

class Cacher
{
    public function handle($request, Closure $next)
{
    return $next($request);
    $response = $next($request);
    $buffer = $response->getContent();
    if(strpos($buffer,'<pre>') !== false)
    {
        $replace = array(
            '/<!--[^\[](.*?)[^\]]-->/s' => '',
            "/<\?php/"                  => '<?php ',
            "/\r/"                      => '',
            "/>\n</"                    => '><',
            "/>\s+\n</"                 => '><',
            "/>\n\s+</"                 => '><',
        );
    }
    else
    {
        $replace = array(
            '/<!--[^\[](.*?)[^\]]-->/s' => '',
            "/<\?php/"                  => '<?php ',
            "/\n([\S])/"                => '$1',
            "/\r/"                      => '',
            "/\n/"                      => '',
            "/\t/"                      => '',
            "/ +/"                      => ' ',
        );
    }
    $buffer = preg_replace(array_keys($replace), array_values($replace), $buffer);
    $response->setContent($buffer);
    ini_set('zlib.output_compression', 'On'); // If you like to enable GZip, too!
    return $response;
   
    /*
                   // return $next($request);
        $is_mobile = Mobile::isMobile() ? 'MOB__' : 'DESK__';
        $CachKey = $is_mobile.$request->fullUrl();
        if (Cache::has($CachKey) ){
      return response( Cache::get($CachKey), 200);
         
        }else{
            $response = $next($request);
            header('Access-Control-Allow-Origin: *');
            $content = $response->getContent();

            $Cache = \Cache::remember($CachKey, 12*60, function() use ($content ) {
             return $content;
         });
         
        }
        */

            return $next($request);

     
     

    return redirect('/');
}

    
}
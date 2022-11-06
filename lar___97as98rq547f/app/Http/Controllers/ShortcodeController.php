<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ShortcodeController extends Controller
{
    public function filter($content){

        preg_match_all("/\[shortcode(.*?)target=('|\")(.*?)('|\")(.*?)]/", $content, $shortcodes);
        if( count($shortcodes) > 0 && isset($shortcodes[3]) && count($shortcodes[3]) > 0  ){
            for( $e = 0; $e < count($shortcodes[3]); $e++ ){
                $type = $shortcodes[3][$e];
                $data = $shortcodes[5][$e];
                // dd( 'shortCodeCache__'.$type.'__'.\App::getLocale() );
                $shortcode = \Cache::remember('shortCodeCache__'.$type.'__'.\App::getLocale(), 60, function() use ($type) {
                     return   $shortcode = $this->shortcodes($type);
                });
                if( !$shortcode ) continue;

              $content = str_replace($shortcodes[0][$e], $shortcode, $content);

            }
        }
        return $content;

    }

    public function shortcodes($shortcode){
       
        $shortcodes = \Config::get('app.SetaatshortCodes');

        if( !isset($shortcodes[$shortcode]) ) return false;
        
        if( method_exists($this, "{$shortcodes[$shortcode]}" ) ){

            $shortcode = $this->{$shortcodes[$shortcode]}();
        }
        
        return $shortcode; 
    }

    public function goldprice(){
        
        $goldURL = env('egyptRatesAPI');
        $token = env('egyptRatesToken');

        if( !$goldURL || !$token ) return false;

        $goldURL = $goldURL."gold?token=$token";

        $curl = curl_init();
        curl_setopt_array($curl, 
            array(
                CURLOPT_URL => $goldURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array( 'Content-Type: application/json',),
            )
        );
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if( $response && $response = json_decode($response)){
            if( !isset($response->data) ) return ' &nbsp;  ';

            $data = $response->data;

            $table = view('layouts.templates.shortcodes.goldprice', ['data'=>$data] )->render();
            \Cache::remember('shortCodeCache__goldprice_UPdatedAt99', 60, function() use ($data) {
                return $data[0]->last_update;
            });
            return $table;

        }
  
    }
    
}

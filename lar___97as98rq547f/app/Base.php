<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Base extends Model
{
 
    /*
    public function ClearifyAttach($media, $size){
        if(@ $media->url->$size ){
            return 'https://setaat.com/wp-content/'.$media->url->$size;
        }
        foreach( $media->url as $s ){
            return 'https://setaat.com/wp-content/'.$s;
        }
    }
    */
    
    public function GetRecent(){
        // recent posts for footer menu
        
        return Cache::remember('getRecentPosts_'.\App::getLocale(), 30, function(){
            return Post::whereIn('type',['post','video'])->where('lang', \App::getLocale() )->whereNotIn('id',$GLOBALS['posts'])->where('created_at','<=',  \Carbon\Carbon::now() )->where('status',1)->select('title','slug')->limit(5)->orderBy('id','desc')->get();
        });
        
    }
}

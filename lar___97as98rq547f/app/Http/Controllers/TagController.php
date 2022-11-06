<?php

namespace App\Http\Controllers;

use App\Modules\Facades\Http\Facade as Http;
use Illuminate\Http\Request;
use App\Tag;
use DB;
use App\Post;

//use Illuminate\Support\Facades\DB;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $slugg = $slug;
        $slug = str_replace('-',' ', $slug);
        if( strpos($slug,'+') !== false ){
                    $slug = str_replace('+',' ', $slug);

            $tag = Tag::where('name', $slug)->first();
            if( $tag ) return redirect( str_replace(' ','-', $tag->name), 301);
            }
        $tag = Tag::where('name',$slug)->first();
        
        if( !$tag ){
            
            $is_post = Post::where('type','post')->where('created_at','<=',  \Carbon\Carbon::now() )->where('slug', urlencode($slugg) )->first();
            if( $is_post ){
                return redirect($slugg, 301);
            }else{
                
                $tag = Tag::where('name','like',"%$slug%")->first();
                if( $tag ){
                    return redirect(url('/tag/'.str_replace(' ','-',$tag->name) ), 301);
                }else{
                    return abort(404);
                }
            }
        }
        
        $posts = DB::table('posts_images as posts')->where('posts.type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status', 1)->where('posts.lang', \App::getLocale() )->
                    join('post_tag','post_tag.post_id','=','posts.id')
                    ->join('tags','tags.id','=','post_tag.tag_id')->where('tags.id', $tag->id)->select('posts.id','posts.created_at','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt')->orderBy('posts.created_at','DESC')->groupBy('posts.id')->paginate(12);
                    
       if( isset($posts[0]) ){
      
       $Fpost = Post::where('id', $posts[0]->id)->select('content')->first();
       $theDesc = html_entity_decode(strip_tags($Fpost->content));
       $theDesc = trim($theDesc);
       $theDesc = preg_replace('/\s+/', ' ',$theDesc);
       $theDesc = explode(' ', $theDesc);
       $theDesc = array_map('trim',$theDesc);
       $theDesc = array_filter($theDesc, function($value) { return $value !== ''; });
       
       $theDesc = array_slice($theDesc, 0, 50);
       $theDesc = implode(' ', $theDesc);
       $theDesc = preg_replace('/\s+/', ' ',$theDesc);

}else{
    $theDesc = '';
}

        // if( $posts->count() <= 0 ) return abort(404);
        
                $postCats = [];
                $postCats[0] = Collect();
                $postCats[0]->name = 'تاج '.$tag->name;
                
                $tag->theDesc = trim($theDesc);
                
        return view('layouts.tag',compact('tag','posts','postCats')); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        
    }
}

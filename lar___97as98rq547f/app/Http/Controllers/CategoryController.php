<?php

namespace App\Http\Controllers;

use App\Category;
use App\Category_post;
use App\Post;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Media;

class CategoryController extends Controller
{

    public function loadFromCategory($id){
        $posts = DB::table('posts_images as posts')->where('posts.type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status', 1)->where('posts.lang', \App::getLocale() )->join('category_post','category_post.post_id','=','posts.id')
                    ->join('categories','categories.id','=','category_post.category_id')
                    ->where('categories.id',$id)->select('posts.slug','posts.title','posts.Murl')->orderBy('posts.created_at','DESC')->groupBy('posts.id')->paginate(16);
        foreach( $posts as $post ){
            $post->Murl = Media::ClearifyAttach($post->Murl,'medium');
        }
        return $posts;
    }

    public function fetchAll(){

        $category = Collect();
        $category->name = 'ستات كوم اول شبكة نسائية عربية متكاملة - صفحة '.( isset($_GET['page']) ? $_GET['page'] : 1 );

        $category->slug = 'ستات-كوم-اول-شبكة-نسائية-عربية-متكاملة';
        
        $posts = DB::table('posts_images as posts')->where('posts.type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status', 1)->where('posts.lang', \App::getLocale() )->
                    join('category_post','category_post.post_id','=','posts.id')
                    ->join('categories','categories.id','=','category_post.category_id')->select('posts.id','posts.created_at','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt','categories.name as cname', 'categories.slug as cslug','categories.color as ccolor','categories.id as Cid' )->orderBy('posts.created_at','DESC')->groupBy('posts.id')->paginate(16);
                    
        $parents = $cats = false;
        return view('layouts.category',compact('posts','category','parents','cats'));

    }


    public function index($slug)
    { 
       
        abort_if(!$category = Category::where('slug',urlencode($slug) )->where('lang', \App::getLocale() )->where('status',1)->first(),404);

        $descendants = $this->getDescendants($category);

        $parents = $category->getParents();
        
        $cats = Category::whereIn('id', $descendants)->whereNotIn('id', [$category->id])->select('id','name','slug')->get();

        $ccc = [$category->id];
foreach( $cats as $cc ){
    $ccc[] = $cc->id;
}
   
$posts = DB::table('posts_images as posts')->whereIn('posts.type',['post','video'])->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status', 1)->where('posts.lang', \App::getLocale() )->join('category_post','category_post.post_id','=','posts.id')
                    ->join('categories','categories.id','=','category_post.category_id')
                    ->whereIn('categories.id',$ccc)->select('posts.type','posts.id','posts.created_at','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt','categories.name as cname', 'categories.slug as cslug','categories.color as ccolor','categories.id as Cid' )->orderBy('posts.created_at','DESC')->groupBy('posts.id');


if( $category->id == 11587 ){
    return app('App\Http\Controllers\CustomTemplatesController')->BreastCancer($category,$posts,$cats,$parents);
}elseif( $category->id == 11608 ){
    return app('App\Http\Controllers\CustomTemplatesController')->Autism($category,$posts,$cats,$parents);
}

$posts = $posts->paginate(16);
$blockAdsense = false;
if( in_array($category->id, [3796, 25] ) ){
    $blockAdsense = true;
}


/*
                    
        $Category_post = Category_post::select('post_id')->whereIn('category_id', $descendants)->get();
        $posts = Post::whereIn('ID', $Category_post)->orderBy('created_at', 'DESC')->paginate(16);
*/


    if( isset($_GET['amp']) ){
        return view('AMP.category',compact('category','posts','cats','parents','blockAdsense'));
    }


        return view('layouts.category',compact('category','posts','cats','parents','blockAdsense'));
    }
    public function get(Request $request){
        
        if($request->ajax()){
            return Category::all();    
        }
        return abort(404);
    }

    public function findDescendants(Category $category){
        $this->descendants[] = $category->id;
        if($category->hasChildren()){
            foreach($category->children as $child){
                $this->findDescendants($child);
            }
        }
    }

    public function getDescendants(Category $category){
        $this->findDescendants($category);
        return $this->descendants;
    }
    
    public function findParents(Category $category){
        $this->parents[] = $category->parent;

        if($parents->count()){
            foreach($parents as $parent){
                $this->findDescendants($child);
            }
        }
    }




    public function manyCats($slugs){
        $slugs = explode('/', trim($slugs));
       foreach( $slugs as $key=>$slug ){
           $cat = Category::select('id','parent_id','slug')->where('slug', urlencode($slug))->first();
           if( !$cat ) return abort(404);

           
           if( $key != 0 ){
               if( $id != $cat->parent_id ) return abort(404);
           }
           
           $id = $cat->id; $parent = $cat->parent_id;
            
       }
       
       return Redirect::to( $cat->slug, 301);

    }

    public function allPosts($page){

        if( !is_numeric($page) ){
            return app('App\Http\Controllers\PostController')->checkURL($page);
        }
        $posts = DB::table('posts_images as posts')->where('posts.type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status', 1)->where('posts.lang', \App::getLocale() )->
        join('category_post','category_post.post_id','=','posts.id')
        ->join('categories','categories.id','=','category_post.category_id')->select('posts.id','posts.created_at','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt','categories.name as cname', 'categories.slug as cslug','categories.color as ccolor','categories.id as Cid' )->orderBy('posts.created_at','DESC')->groupBy('posts.id')->paginate(12,['*'], 'page' , $page );
        $parents = false;
        $cats  = false;
        $category = Collect();
        $category->name = 'كافة المقالات - صفحة '.$page;
        $category->slug = url('/');
        $FetchAll = true;
        return view('layouts.category',compact('category','posts','cats','parents','FetchAll'));

    }

}
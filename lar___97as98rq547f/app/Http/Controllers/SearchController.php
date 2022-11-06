<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	$this->validate(request(),[

    	'q' => 'required|string|min:4',
    	]);

       /* $results = DB::table('posts_images as posts')->where('posts.type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status',1)->where('posts.lang', \App::getLocale() )->where('title', 'like', '%'.$request->search.'%')->
        join('category_post','category_post.post_id','=','posts.id')
        ->join('categories','categories.id','=','category_post.category_id')->select('posts.id','posts.created_at','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt','categories.name as cname', 'categories.slug as cslug','categories.color as ccolor','categories.id as Cid' )->orderBy('posts.created_at','DESC')->groupBy('posts.id')->paginate(12);
*/

$results = Collect();
        
    	//$results = Post::where('title', 'like', '%'.$request->search.'%')->latest()->paginate(4);

        $tags = ['title' => 'Search'];
        $postCats = [];
        $postCats[0] = Collect();
        $postCats[0]->name = ' بحث - '.$request->q;
        
       return view('layouts.templates.search-result',compact('results','tags','postCats'));

    }
}

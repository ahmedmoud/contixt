<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Config;

class SitemapController extends Controller
{

	public function index()
	{
		$view = view('sitemap.sitemap');
		return response($view, 200)
				->header('Content-Type', 'text/xml');
	}  
	
	public function pages()
	{
		if( \App::isLocale('ar') ){
			$pages = [
				url('/'),
				// url('من-نحن'),
				url('اتصل-بنا'),
				// url('اشتركي-معنا'),
				// url('أعلن-معنا'),
				// url('سياسة-الخصوصية')
			];
		}else{
			$pages = [];
		}

		$view = view('sitemap.pages', compact('pages'));
		return response($view, 200)
				->header('Content-Type', 'text/xml');
	}
	  

	  public function posts()
	  {
		$paginator = Config('app.paginator');	  	
		  $posts = Post::leftjoin('postsupdates','postsupdates.post_id','=','posts.id')->select('posts.slug','posts.updated_at','postsupdates.date')->whereIn('type',['post','video'])->where('created_at','<=',  \Carbon\Carbon::now() )->where('lang', \App::getLocale() )->where('status',1)->orderBy('created_at','desc')->paginate($paginator);
	  	$view = view('sitemap.sitemap_posts',compact('posts'));
	  	return response($view, 200)->header('Content-Type', 'text/xml');	
	  }   

	  public function posts_page()
	  {
	  	$paginator = Config('app.paginator');
	  	$posts = Post::where('type','post')->where('created_at','<=',  \Carbon\Carbon::now() )->where('lang', \App::getLocale() )->where('status',1)->count();
	  	$posts = $paginator > 0 ? $posts/$paginator : 1;
	  	$posts = ceil($posts);

	  	$view = view('sitemap.sitemap_posts_pages',compact('posts'));
	  	return response($view, 200)
                  ->header('Content-Type', 'text/xml');	
	  }

	  public function categories()
	  {
	  	$paginator = Config('app.paginator');
		  $categories = Category::where('status',1)->where('lang', \App::getLocale() )->latest()->paginate($paginator);

	  	$view = view('sitemap.sitemap_categories',compact('categories'));
	  	return response($view, 200)
                  ->header('Content-Type', 'text/xml');	
	  }   

	  public function categories_page()
	  {
	  	$paginator = Config('app.paginator');
	  	$categories = Category::where('status',1)->where('lang', \App::getLocale() )->count();
	  	$categories = $paginator > 0 ? $categories/$paginator : 1;
	  	$categories = ceil($categories);

	  	$view = view('sitemap.sitemap_categories_pages',compact('categories'));
	  	return response($view, 200)
                  ->header('Content-Type', 'text/xml');	
	  }   

	  public function tags()
	  {
	    $paginator = Config('app.paginator');
		$tags = Tag::paginate($paginator);
		  
	  	$view = view('sitemap.sitemap_tags',compact('tags'));
	  	return response($view, 200)
                  ->header('Content-Type', 'text/xml');	
	  }   

	  public function tags_page()
	  {
	    $paginator = Config('app.paginator');
	  	$tags = Tag::count();
	  	$tags = $tags/$paginator;
	  	$tags = ceil($tags);

		

	  	$view = view('sitemap.sitemap_tags_pages',compact('tags'));
	  	return response($view, 200)
                  ->header('Content-Type', 'text/xml');	
	  }   

 

 }

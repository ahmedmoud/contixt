<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Auth;
use Http;
use UPerm;

class CategoryController extends Controller
{

    public function tree(){

        $tree = Category::where('lang', \App::getLocale() )->get();
        $output = [];

        foreach( $tree as $cat ){

            $parent = $cat->parent_id ? $cat->parent_id : 0;
            $output[$parent][] = $cat;

        }
        

        return view('admin.categories.tree', compact('output') );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(! UPerm::ViewCategories() ){ return UPerm::Block(); }

        if(!$request->q){
            $categories = Category::where( 'lang', \App::getLocale() )->orderBy('id','desc')->paginate(30);
        }else{
            $categories = Category::where( 'lang', \App::getLocale() )->where('name', $request->q)->orderBy('id','desc')->get();
            }
     
        if($request->ajax()){
            return $categories;
        }else{
            return view('admin.categories.index',compact('categories'));
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(! UPerm::CreateCategories() ){ return UPerm::Block(); }
        $categories = Category::where('lang', \App::getLocale() )->get();
        return view('admin.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! UPerm::CreateCategories() ){ return UPerm::Block(); }

        $request->validate([
            'name' => 'required|unique:categories',
            'slug' => 'nullable',
            'parent_id' => 'nullable'
        ]);
        $body = $request->except('_token');
        if(!$request->slug){
            $body['slug'] = $request->name;
        }
        
        if( empty($body['slug']) || $body['slug'] == null ){
            $body['slug'] = trim($request->name);
        }

        $slug_ex = [']','[','.','/','@','#','^','*','?','+'];
        foreach( $slug_ex as $se ){
            $body['slug'] = str_replace($se, ' ', $body['slug']);
        }
        $body['slug'] = preg_replace('!\s+!', ' ', $body['slug']);
        $body['slug'] = str_replace(' ', '-', trim($body['slug']) );

        
        $body['slug'] = urldecode($body['slug']);
        $body['slug'] = urlencode($body['slug']);

        $body['lang'] = \App::getLocale();

        $body['status'] = 1;
        abort_if(!Category::create($body), 422);
        return redirect('admin/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if(! UPerm::EditCategories() ){ return UPerm::Block(); }

        $categories = Category::where('id', '!=',$category->id)->where(function($query) use ($category){
            $query->where('parent_id', '!=', $category->id)->orWhereNull('parent_id');
        })->get();
        return view('admin.categories.edit', compact('categories','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if(! UPerm::EditCategories() ){ return UPerm::Block(); }

        $body = $request->except(['_token', '_method']);
        if($request->slug == null)
        {
            $body['slug'] = str_replace(' ', '-', $request->title);
        }
        else{
            $body['slug'] = str_replace('/', '', $request->slug);
        }

        $body['slug'] = urldecode($body['slug']);
        $body['slug'] = urlencode($body['slug']);

        
        $category->update($body);
        return redirect('admin/categories');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if(! UPerm::RemoveCategories() ){ return UPerm::Block(); }
        $cPosts = $category->posts()->select('id')->get();
        foreach( $cPosts as $p ){ $p->categories()->attach([1]); }
        $category->delete();
        return redirect('admin/categories');
    }

    public function get(){
            return Category::where('lang', \App::getLocale() )->select('id','name')->get(); 
    }
}
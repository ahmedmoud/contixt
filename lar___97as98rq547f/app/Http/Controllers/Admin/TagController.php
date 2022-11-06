<?php

namespace App\Http\Controllers\Admin;

use Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;
//use Illuminate\Support\Facades\DB;
class TagController extends Controller
{

	public function __construct(){
	$this->middleware('can:view,tags')->only('index');
        $this->middleware('can:update,tags')->only('edit', 'update');
        $this->middleware('can:create,tags')->only('store','create');
        $this->middleware('can:delete,tags')->only('destroy');
	}
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->q){
            $tags = Tag::paginate();
        }else{
            $tags = Tag::where('name', $request->q)->get();
        }
        if($request->ajax()){
            return $tags;
        }else{
            return view('admin.tags.index', compact('tags'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $body = $request->except('_token');
        if(!$request->slug){
            $body['slug'] = Http::GenerateSlug('App\Category', $request->name);
        }
        $body['status'] = 1;
        Tag::create($body);

        return redirect('/admin/tags')->with('msg', 'Tag Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.create', compact('tag'));
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
        $body = array_filter($request->except(['_token', '_method']), 'strlen');
        if($tag){
            $tag->update($body);

            return redirect('/admin/tags')->with('msg', 'Tag Updated Successfully');
        }else{
            return back()->withErrors('Tag Isn\'t Exists');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        if($tag){
            $tag->delete();
            return back()->with('msg', 'Tag Deleted Successfully');
        }else{
            return back();
        }
    }
}

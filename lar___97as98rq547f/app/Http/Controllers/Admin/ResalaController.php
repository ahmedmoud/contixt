<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use UPerm;
use Auth;
use Cache;

class ResalaController extends Controller
{
    
    public function index(){
        if( !UPerm::ControlResala() ){ return UPerm::Block(); }
        $posts = new Post();
        
        if( isset($_GET['status']) ){
             $status = ($_GET['status'] == 1 )? 1 : null;
            $posts = $posts->where('status',$status);
        }
        $posts = $posts->where('type', 'resala')->orderBy('created_at','desc')->paginate(30);
        return view('admin.resala.index', compact('posts') );
    }

    public function create() 
    {

        if( UPerm::ControlResala() ){
            return view('admin.resala.create');
        }
        return UPerm::Block();
            
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return View
     */
    public function store(Request $request)
    {
        if( !UPerm::ControlResala() ){ return UPerm::Block(); }
         
        $this->validate(request(),[
            'title' => 'required|min:3',
        ]);         
         
     // DB::transaction(function() use ($request){
            $body = $request->except('_token');            
            $body['user_id'] = Auth::id();
            if( !isset($body['created_at']) ){
                $body['created_at'] = \Carbon\Carbon::now();
            }
            $body['updated_at'] = $body['created_at'];

            if( isset($body['status']) && $body['status'] == 1 ){
                Cache::forget('HomeFirstCache');
            }
            $body['type'] = 'resala';
            $body['comment_status'] = 1;
            
            $post = Post::create($body);
            $exitCode = \Artisan::call('cache:clear');

       // });
        return redirect(route('resala.index'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(! UPerm::ControlResala() ){ return UPerm::Block(); }
        $post = Post::where('type','resala')->where('id', $id)->first();
        return view('admin.resala.create', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        if(! UPerm::ControlResala() ){ return UPerm::Block(); }

        $post = Post::where('type','resala')->where('id', $id)->first();
        $body = $request->except('_token');
        

        
        
        if( $body['created_at'] > $post->updated_at ){
            $body['updated_at'] = $body['created_at'];
        }else{
            $body['updated_at'] = \Carbon\Carbon::now();
        }
        
        if(  $post->status != 1 && $request->status == 1 ){
            if( $body['created_at'] <= \Carbon\Carbon::now() ){
                $body['created_at'] = \Carbon\Carbon::now();
            }else{
                $body['updated_at'] = $body['created_at'];
            }
        }
        
        $post->update($body);
        return redirect(route('resala.index'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        if(! UPerm::ControlResala() ){ return UPerm::Block(); }
        $post = Resala::where('id', $id)->first();
        $post->delete();
        return redirect('/admin/resala');
    }
    

}
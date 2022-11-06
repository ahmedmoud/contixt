<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Http;
use App\Competition;
use Illuminate\Http\Request;
use Auth;
use DB;
use UPerm;
use App\User;
use Carbon\Carbon;
use App\CompetitionSub;

class CompetitionController extends Controller
{

    public function toggleSub(Request $request){
        $body = $request->except('_token');
        
    }
    public function hello(){
        $published = CompetitionSub::where('status', 1)->count();
        $pending = CompetitionSub::where('status', null)->count();

        $posts = CompetitionSub::paginate(30);
        foreach( $posts as $post ){
            $post->vote = $this->votes($post);
        }
        return view('admin.competitions.sub', compact('posts','published','pending'));
    }

    public function votes(CompetitionSub $post){
        return $post->votes()->select(DB::raw("AVG(vote) as vote, count(id) as total"))->first();
    }



    public function searchQuery(Request $request){
        $category = $request->category;
        $user     = $request->user;
        $query    = $request->input('query');
        $date    = $request->input('date');
        $status    = $request->status;

        $posts = Post::select('posts.*');

        if( $user ) $posts = $posts->where('posts.user_id', $user );
        if( $query ) $posts = $posts->where('posts.title','like', '%'.trim($query).'%');
        if( $date ){
            $date = trim( str_replace('/', '-', $date) );
            $posts = $posts->where('posts.created_at','like', '%'.$date.'%');
        }
        

        

        if( $status && in_array( $status, [1,2,3] ) ) $posts = $posts->where('posts.status', $status);

           $categories = Category::select('name', 'id')->get();
           $users      = User::where('role_id','!=',null)->select('id','name')->get();

         if( $category ){
            $category = ( is_array($category) )? $category : [$category];
            $posts = $posts->
            join('category_post','category_post.post_id','=','posts.id')->whereIn('category_post.category_id', $category )
            ->join('categories','categories.id','=','category_post.category_id')->whereIn('categories.id', $category );
         }


        $posts = $posts->orderBy('posts.id','desc')->paginate(30); 
        $published = $pending = $draft = false;
         $posts = $posts->appends(\Illuminate\Support\Facades\Input::except('page'));
        return view('admin.posts.search', compact('posts','categories','users'));
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AllPosts(){
        if( !UPerm::OthersPostsViews() ) return UPerm::Block();
        return $this->index(true);
    }

    public function index($allPosts = false )
    {

        /** @var Post $posts */

        $posts = Competition::orderBy('created_at', 'DESC');

        if( !$allPosts ) $posts = $posts->where('user_id', Auth::user()->id );
        
        if( $allPosts ){
            $published = number_format( Competition::where('status', 1)->count() );
            $pending = number_format( Competition::where('status', 2)->count() );
        }else{
            $published = number_format( Competition::where('user_id', Auth::user()->id )->where('status', 1)->count() );
            $pending = number_format( Competition::where('user_id', Auth::user()->id )->where('status', 2)->count() );
        }



        $posts = $posts->paginate(30); 

        return view('admin.competitions.index', compact('posts','published','pending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {

        if( UPerm::ControlCompetition() ){
            return view('admin.competitions.create');
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
        
        if( !UPerm::ControlCompetition() ){ return UPerm::Block(); }
         
        $this->validate(request(),[
            'title' => 'required|min:3',
            'content' => 'required',
            'image' => 'required',
            'status'=> 'required'
        ]);         
         



     // DB::transaction(function() use ($request){
            $body = $request->except('_token');
            $body['slug'] = str_replace(' ', '-', trim($request->slug) );
        
            if( empty($body['slug']) || $body['slug'] == null ){
                $body['slug'] = trim($request->title);
            }
                
            $slug_ex = [']','[','.','/','@','#','^','*'];
            foreach( $slug_ex as $se ){
                $body['slug'] = str_replace($se, ' ', $body['slug']);
            }
            $body['slug'] = preg_replace('!\s+!', ' ', $body['slug']);
            $body['slug'] = str_replace(' ', '-', trim($body['slug']) );

            $body['slug'] = urldecode($body['slug']);
            $body['slug'] = urlencode($body['slug']);
            
            $slugEx = Competition::where('slug', $body['slug'] )->count();
            if( $slugEx ){
                return back()->withErrors(['slug'=>'رابط المقال مستخدم من قبل ، يرجى استخدام رابط آخر'])->withInput($request->input());
            }
            
            
            $body['user_id'] = Auth::id();

            
            $post = Competition::create($body);

           if( $body['status'] == 1 ){ $exitCode = \Artisan::call('cache:clear'); }

            

       // });
        return redirect(route('competitions.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return void
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(! UPerm::ControlCompetition() ){ return UPerm::Block(); }
        $post = Competition::where('id', $id)->first();
        return view('admin.competitions.create', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        if(! UPerm::ControlCompetition() ){ return UPerm::Block(); }

        $post = Competition::where('id', $id)->first();

        if(  $post->status != 1 && $request->status == 1 ){
            $POST = Competition::where('id', $post->id)->first();
            $POST->timestamps = false;
            $POST->created_at = Carbon::now()->toDateTimeString();
            $POST->save();
        }
        

        
        $body = $request->except('_token');
        
        $body['slug'] = str_replace(' ', '-', trim($request->slug) );
        
        if( empty($body['slug']) || $body['slug'] == null ){
            $body['slug'] = trim($request->title);
        }
        if(  empty($request->slug) && $post->slug != $request->slug ){
            
            $slug_ex = [']','[','.','/','@','#','^','*'];
            foreach( $slug_ex as $se ){
                $body['slug'] = str_replace($se, ' ', $body['slug']);
            }
            $body['slug'] = preg_replace('!\s+!', ' ', $body['slug']);
        }
        $body['slug'] = str_replace(' ', '-', trim($body['slug']) );

            $body['slug'] = urldecode($body['slug']);
            $body['slug'] = urlencode($body['slug']);     
                       
                if( $body['status'] == 1 ){ $exitCode = \Artisan::call('cache:clear'); }

                //dd($body);
                $post->update($body);


                // if($request->tags){
                // 	$post->tags()->detach($request->tags);
	            //     $post->tags()->attach($request->tags);
                // }
        
        return redirect(route('competitions.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        if(! UPerm::PostRemove($post->id) ){ return UPerm::Block(); }

        $post->delete();

        return redirect($post->url->index);
    }
}

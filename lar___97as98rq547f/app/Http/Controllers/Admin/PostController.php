<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use Http;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Auth;
use DB;
use UPerm;
use App\User;
use Carbon\Carbon;
use App\Competition;
use SEOAgent;

class PostController extends Controller
{

    function search4tinymce(Request $request){
        $this->validate(request(),[
            'keyword' => 'required|min:3',
            'postID'  => 'nullable'
        ]);  
        $keyword = trim($request->keyword);
        $postID = isset($request->postID) ? $request->postID : false;
        $posts = Post::select('title','slug')->where('status', 1)->where('created_at','<',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->whereIn('posts.type',['post','video'])->limit(10)->orderBy('id','desc')->where(function ($query, $keyword) {
                $query->where('title','like',"%$keyword%")
                    ->orwhere('focuskw','like',"%$keyword%");
                            })->get();
        dd($posts);
    }
    public function searchQuery(Request $request){
       
        $category = $request->category;
        $thePostsIDs = $request->ids;
        $user     = $request->user;
        $query    = $request->input('query');
        $dateFrom    = $request->input('dateFrom');
        $dateTo    = $request->input('dateTo');
        $status    = $request->status;
        $type      = $request->type;
        $seoStatus = $request->onpage;
        $wordsLength = $request->wordsLength == '1' ? true : false;
        
        $filterCategories = $request->filterCategories;



        $posts = Post::where('posts.lang', \App::getLocale() )->leftJoin('oldposts','oldposts.post_id','=','posts.id')->select('posts.*','oldposts.id as editsID');

        if( $user ) $posts = $posts->where('posts.user_id', $user );
        if( $query ) $posts = $posts->where('posts.title','like', '%'.trim($query).'%');
        if( isset($_GET['date']) ){
            
            $dateTo = trim( str_replace('/', '-', $_GET['date']) );       
            $dateFrom = trim( str_replace('/', '-', $_GET['date']) );   
            
          //  $dateFrom = \Carbon\Carbon::parse($dateFrom)->addDays(1);
                
            $posts = $posts->whereBetween('posts.created_at',  [$dateTo, $dateFrom]);

            $_GET['dateFrom'] = $dateFrom->format('Y-m-d');
            $_GET['dateTo'] = $_GET['date'];
        }else{

            if( $dateFrom && $dateTo ){
                $dateFrom = trim( str_replace('/', '-', $dateFrom) );       
                $dateTo = trim( str_replace('/', '-', $dateTo) );

                $posts = $posts->whereBetween('posts.created_at',  [$dateTo, $dateFrom]);
            }
        }
            if( $type && in_array($type, ['resala','post','video','keyword']) ){
                $type = $type == 'keyword' ? 'null' : $type;
                $posts->where('posts.type',$type);
            }
        if( $status && in_array( $status, [1,2,3,4] ) ) $posts = $posts->where('posts.status', $status);
        if( $status == 'schedule'){
            $posts = $posts->where('status', 1)->where('created_at','>',  \Carbon\Carbon::now() );
        }

        if( isset($seoStatus) && in_array($seoStatus, ['bad','good']) ){
            if( $seoStatus == 'bad' ){
                $posts->where('seoStatus','>','0');
            }else{
                $posts->where('seoStatus','=','0');
            }
        }

           $categories = Category::select('name', 'id')->get();
           $users      = User::where('role_id','!=',null)->select('id','name')->get();

         if( $category ){
            $category = ( is_array($category) )? $category : [$category];
            $posts = $posts->
            join('category_post','category_post.post_id','=','posts.id')->whereIn('category_post.category_id', $category )
            ->join('categories','categories.id','=','category_post.category_id')->whereIn('categories.id', $category );
         }


         if( $thePostsIDs ){
            $thePostsIDs = explode("\n", $thePostsIDs);
            $posts = $posts->whereIn('posts.id', $thePostsIDs);
            $posts = $posts->orderBy(DB::raw('FIELD(posts.id,'.implode(',',$thePostsIDs).')'));
        }else{
            $posts = $posts->orderBy('id','desc');
        }

        $posts = $posts->groupBy('posts.id');


         $lengthes = 0;
         $postsLengthes = [];
         if( $wordsLength  ){

            $postss = $posts;
            $postss = $postss->get();
            foreach( $postss as $postt ){
                $pContent = trim($postt->content);
                $pContent = $pContent ? $pContent : ' ';

                $PostFUpdate = \DB::table('postsUpdates')->where('post_id', $postt->id)->orderBy('date','desc')->first();
                if( $PostFUpdate && $PostFUpdate->content ){
                   
                    $pContent = trim($PostFUpdate->content);
                    $pContent = $pContent ? $pContent : ' ';
                }


                $length = \SEOAgent::TextLength($pContent);
                $lengthes += $length;
                $postsLengthes[$postt->id] = $length;
            }
        }


        $loo = 0;
        if( $filterCategories && $wordsLength ){
            $extractor = [];
            $categories__filtered = [];
            foreach( $postss as $post ){
                
                $loo++;

                $cat = $post->categories()->first();
                if( !$cat ) continue; 
                
                    $categories__filtered[$cat->id]['posts'][] = $post->id;
                    $categories__filtered[$cat->id]['words'] = isset($categories__filtered[$cat->id]['words']) ? $categories__filtered[$cat->id]['words'] : 0;
                    $categories__filtered[$cat->id]['words'] += $postsLengthes[$post->id];
                
            }

        }else{
            $categories__filtered = false;
        }



        $paginate =  ( isset($request->paginate) && $request->paginate <= 150 ) ? $request->paginate : 60;


            $posts = $posts->orderBy('posts.id','desc')->groupBy('posts.id')->paginate($paginate); 
            $posts = $posts->appends(\Illuminate\Support\Facades\Input::except('page'));
        



        $published = $pending = $draft = false;

        return view('admin.posts.search', compact('posts','categories','users','postsLengthes','lengthes','categories__filtered'));
        
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
      
        $posts = Post::where('lang', \App::getLocale() )->orderBy('created_at', 'DESC');

        if( !$allPosts ) $posts = $posts->where('posts.user_id', Auth::user()->id );

        if( $allPosts ){
          
            $published = number_format( Post::where('posts.lang', \App::getLocale() )->where('status', 1)->count() );
            $pending = number_format( Post::where('posts.lang', \App::getLocale() )->where('status', 2)->count() );
            $draft = number_format( Post::where('posts.lang', \App::getLocale() )->where('status', 3)->count() );
            $schedule = number_format( Post::where('posts.lang', \App::getLocale() )->where('status', 1)->where('created_at','>',  \Carbon\Carbon::now() )->count() );
        }else{
            $published = number_format( Post::where('posts.lang', \App::getLocale() )->where('posts.user_id', Auth::user()->id )->where('status', 1)->count() );
            $pending = number_format( Post::where('posts.lang', \App::getLocale() )->where('posts.user_id', Auth::user()->id )->where('status', 2)->count() );
            $draft = number_format( Post::where('posts.lang', \App::getLocale() )->where('posts.user_id', Auth::user()->id )->where('status', 3)->count() );
            $schedule = number_format( Post::where('posts.lang', \App::getLocale() )->where('posts.user_id', Auth::user()->id )->where('posts.created_at','>=',  \Carbon\Carbon::now() )->where('status', 1)->count() );
        }

        $posts = $posts->where('posts.lang', \App::getLocale() )->whereIn('posts.type',['post','video'])->leftJoin('oldposts','oldposts.post_id','=','posts.id')->select('posts.*','oldposts.id as editsID')->groupBy('posts.id')->paginate(30);
       

        return view('admin.posts.index', compact('posts','published','pending','draft','schedule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        if( UPerm::PostCreate() ){
            return view('admin.posts.create', compact('categories'));
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
        
        if( !UPerm::PostCreate() ){ return UPerm::Block(); }
        $this->validate(request(),[
            'title' => 'required|min:3',
            'content' => 'nullable',
            'categories' => 'nullable',
            'image' => 'nullable',
            'status'=> 'nullable',
            'focuskw'=>'nullable'
        ]);         

        $status = UPerm::PostStatus();  
        
        if( !in_array($request->status, $status) ){
            $status = min($status);
        }else{
            $status = $request->status;
        }
        
     // DB::transaction(function() use ($request){
            $body = $request->except('_token');
            $body['slug'] = str_replace(' ', '-', trim($request->slug) );
        
            if( empty($body['slug']) || $body['slug'] == null ){
                $body['slug'] = trim($request->focuskw);
            }

            $slug_ex = [']','[','.','/','@','#','^','*','?','+'];
            foreach( $slug_ex as $se ){
                $body['slug'] = str_replace($se, ' ', $body['slug']);
            }
            $body['slug'] = preg_replace('!\s+!', ' ', $body['slug']);
            $body['slug'] = str_replace(' ', '-', trim($body['slug']) );

            $body['slug'] = urldecode($body['slug']);
            if( strlen($body['slug']) > 45 ){ $body['slug'] = mb_substr($body['slug'],0,45,'utf-8'); $body['slug'] = trim($body['slug']); }
            $body['slug'] = urlencode($body['slug']);

            $is_competition = Competition::where('slug', $body['slug'] )->count();
            
            $slugEx = Post::where('slug', $body['slug'] )->count();
            if( $is_competition || $slugEx ){
                return back()->withErrors(['slug'=>'رابط المقال مستخدم من قبل ، يرجى استخدام رابط آخر'])->withInput($request->input());
            }
            $body['status'] = $status;
            $body['user_id'] = Auth::id();
            $body['updated_at'] = $body['created_at'];
            $body['type'] = $body['type'] ? $body['type'] : 'post';



            // date of birth
            $body['dob'] = \Carbon\Carbon::now();
            $body['lang'] = \App::getLocale();


            if( isset($body['content']) ){
            $html = $body['content'];
            $html = trim($html);
            $html = str_get_html($html);
            foreach( $html->find('a') as $link ){
                $href = $link->href;
                if( strpos( strtolower($href), 'setaat.com' ) === false && !empty($href) ){
                    
if(  !UPerm::InsertotherSitesLinks() ){
return back()->withErrors([
    'content'=> 'out Links : '.$link->plaintext.' ::: '.urldecode($href)])->withInput($request->input());
                    }
                    $link->setAttribute('rel','nofollow');
                }
            }
            $body['content'] = (string)$html;
        } 
  
        if( $request->RelatedPosts ){
            $body['RelatedPosts'] = json_encode( $request->RelatedPosts );
            dd( $body );
        }
        
            $post = Post::create($body);

            $postT = Post::where('id', $post->id)->first();
            $seoStatus = SEOAgent::fetchReport( $postT, true );

        // recipe logic 
        if( $request->is_recipe == "1" || ($request->ingredient || $request->instructions || $request->calories ) ){

            $request->cookMethod= $request->cookMethod ?  implode(',', $request->cookMethod) : '';
            $request->cuisine = $request->cuisine ?  implode(',', $request->cuisine) : '';
            $request->recipeType = $request->recipeType ?  implode(',', $request->recipeType) : '';
            $request->diet = $request->diet ?  implode(',', $request->diet) : '';

            $seoStatus = '0';

            $recipe = [
                'post_id'  => $post->id,
                'recipeName' => $request->recipeName, 
                'ingredient' => $request->ingredient, 
                'protein' => $request->protein, 
                'instructions' => $request->instructions,
                'calories' => $request->calories,
                'cookTime' => $request->cookTime,
                'prepTime' => $request->prepTime, 
                'cuisine' => $request->cuisine,
                'recipeType' => $request->recipeType,
                'yield' => $request->yield,
                'cookMethod' => $request->cookMethod,
                'carbohydrates' => $request->carbohydrates,
                'fatContent' => $request->fatContent,
                'diet' => $request->diet,
                'notice' => $request->notice,
                'difficulty' => $request->difficulty,
                'videoURL' => $request->videoURL,
                'videoThumbnail' => $request->videoThumbnail,
                'mid_img' => $request->mid_img && is_array($request->mid_img) ? implode(",", $request->mid_img) : '',
            ];
            

            \App\Recipe::create($recipe);
     
        }


            $postT->update(['seoStatus'=>$seoStatus]);

           if( $body['status'] == 1 ){ $exitCode = \Artisan::call('cache:clear'); }
            $post->categories()->attach($request->categories);
            
        $tags = $request->tags;
        $tags = explode(',', $tags);
        foreach( $tags as $tag ){
            $tag = str_replace('-', ' ', $tag);
            $tag = trim($tag);
            $tagg = Tag::firstOrCreate(['name'=> $tag]);
            $taggs[] = $tagg->id;
        }
        $post->tags()->attach($taggs);

       // });
        return redirect(route('posts.index'));
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
    public function edit(Post $post)
    {

      if(! UPerm::PostEdit($post->id) ){ return UPerm::Block(); }

    
        $Tagss = array();
        $Tags = $post->tags()->get();
        foreach( $Tags as $T ){ $Tagss[] = $T->name; }
        $post->Tags = implode(',', $Tagss);
        $re = '/\[caption([^\]]+)\](\s*\<a[^>]+>)(\s*\<img[^>]+>)\s*(.*?)\s*\[\/caption\]/';
        $subst = '<div\\1 class="wp-caption">\\2     <p class="caption">\\3  \\4</p></div>';
        $result = preg_replace($re, $subst, $post->content);
        $post->content = $result; 




        if( isset($_GET['ashraf']) ){
            $b = $post->RelatedPosts;
            $b = json_decode($b);
            foreach( $b as $key=>$rPost ){

                $tempPost = \App\Post::select('title','slug')->where('id',$rPost->id)->where('status',1)->first();
                if( !$tempPost ){
                    dd( $rPost);
                }
        }
            dd( $b );
        }
      
       

        $SEOAgent = '';
        $recipesTypes = false;
        
        if( !$post->recipe ){ 
            $SEOAgent = SEOAgent::fetchReport( $post );
        }else{
            $recipesTypes = \App\Recipes_Types::all();
        }
    
        return view('admin.posts.create', compact('post','SEOAgent','recipesTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post){

        if(! UPerm::PostEdit($post->id) ){ return UPerm::Block(); }
        
        
        $status = UPerm::PostStatus();
        
        if( !in_array($request->status, $status) ){
            $status = min($status);
        }else{
            $status = $request->status;
        }
        if( $request->status == $post->status ){
            $status = $request->status;
        }

        if(  $post->status != 1 && $request->status == 1 ){
            $POST = Post::where('id', $post->id)->first();
            $POST->timestamps = false;
            if( $post->created_at <= \Carbon\Carbon::now() ){
                $POST->created_at = \Carbon\Carbon::now();
            }else{
                $POST->updated_at = $POST->created_at;
            }
            $POST->save();
        }

        $body = $request->except('_token');

if( isset($body['slug']) ){
        $body['slug'] = str_replace(' ', '-', trim($request->slug) );
        if( empty($body['slug']) || $body['slug'] == null ){
            
            $body['slug'] = trim($request->title);
        }
        if(  empty($request->slug) && $post->slug != $request->slug ){
            $is_competition = Competition::where('slug', $body['slug'] )->count();
            if( $is_competition ){
                return back()->withErrors(['slug'=>'رابط المقال مستخدم من قبل ، يرجى استخدام رابط آخر'])->withInput($request->input());
            }
            $slug_ex = [']','[','.','/','@','#','^','*','+'];
            foreach( $slug_ex as $se ){
                $body['slug'] = str_replace($se, ' ', $body['slug']);
            }
            $body['slug'] = preg_replace('!\s+!', ' ', $body['slug']);
        }
        $body['slug'] = str_replace(' ', '-', trim($body['slug']) );

            $body['slug'] = urldecode($body['slug']);
            $body['slug'] = urlencode($body['slug']);   
            $slugEx = Post::where('id', '!=', $post->id)->where('slug', $body['slug'] )->count();
            if(  $slugEx ){
                return back()->withErrors(['slug'=>'رابط المقال مستخدم من قبل ، يرجى استخدام رابط آخر'])->withInput($request->input());
            }
}   
                $body['status'] = $status;
                if( $body['status'] == 1 ){ $exitCode = \Artisan::call('cache:clear'); }

                $body['type'] = $body['type'] ? $body['type'] : 'post';


                // To track posts changes
                $this->OldPostTracking($post, $body);

                if( isset($body['content']) ){

                $html = $body['content'];
                $html = trim($html);
                $html = str_get_html($html);
                foreach( $html->find('a') as $link ){
                    $href = $link->href;
if( $href && ( 
    
strpos( strtolower($href), 'setaat.com' ) === false  && 
strpos( strtolower($href), 'facebook.com/setaatcom' ) === false  

)&& !empty($href) ){
                    
                    if(  !UPerm::InsertotherSitesLinks() ){
return back()->withErrors([
    'content'=> 'out Links : '.$link->plaintext.' ::: '.urldecode($href)])->withInput($request->input());
                    }

                    $link->setAttribute('rel','nofollow');
                }
                }

                $body['content'] = (string)$html;
            }
               $body['updated_at'] = \Carbon\Carbon::now();

               if( $request->RelatedPosts ){
                $body['RelatedPosts'] = json_encode( $request->RelatedPosts );
            }

         

                $post->update($body);

                $postT = Post::where('id', $post->id)->first();
            
                $seoStatus = SEOAgent::fetchReport( $postT, true );
            
                // recipe logic 
                if( $post->recipe || $request->is_recipe == "1" || ($request->ingredient || $request->instructions || $request->calories ) ){

                    $seoStatus = '0';

                     $recipe = [
                        'post_id'  => $post->id,
                        'recipeName' => $request->recipeName, 
                        'ingredient' => $request->ingredient, 
                        'protein' => $request->protein, 
                        'instructions' => $request->instructions,
                        'calories' => $request->calories,
                        'cookTime' => $request->cookTime,
                        'prepTime' => $request->prepTime, 
                        'yield' => $request->yield,
                        'fatContent' => $request->fatContent,
                        'carbohydrates' => $request->carbohydrates,
                        'diet' => $request->diet,
                        'notice' => $request->notice,
                        'difficulty' => $request->difficulty,
                        'videoURL' => $request->videoURL,
                        'videoThumbnail' => $request->VideoThumbnail,
                        'mid_img' => $request->mid_img && is_array($request->mid_img) ? implode(",", $request->mid_img) : '',
                    ];
                    $theRecipe = \App\Recipe::where('post_id', $post->id)->first();
                    $theRecipe->update($recipe);
                    
                    $types = [];


                    $types = is_array($request->cuisine)    ? array_merge($request->cuisine, $types ) : $types;
                    $types = is_array($request->cookMethod) ? array_merge($request->cookMethod, $types ) : $types;
                    $types = is_array($request->recipeType) ? array_merge($request->recipeType, $types ) : $types;


                    $types[] = $request->cost;

                    $theRecipe->types()->detach();
                    $theRecipe->types()->attach($types);

                }


                $postT->update(['seoStatus'=>$seoStatus]);

                $catsIDs = $post->categories()->pluck('id');
                
              
                if($request->categories){
        	        $post->categories()->detach($catsIDs);
                	$post->categories()->attach($request->categories);
                }

                $tags = $request->tags;
                $tags = explode(',', $tags);
                foreach( $tags as $tag ){
                    $tag = str_replace('-', ' ', $tag);
                    $tag = trim($tag);
                    $tagg = Tag::firstOrCreate(['name'=> $tag]);
                    $taggs[] = $tagg->id;
                }
                $post->tags()->detach();
                $post->tags()->attach($taggs);

                // if($request->tags){
                // 	$post->tags()->detach($request->tags);
	            //     $post->tags()->attach($request->tags); 
                // }
                
                if( Auth::check() && in_array(Auth::user()->id , [639, 642]) ){
                return redirect( url('/admin/posts/'.$post->id.'/edit') )->with(['Success'=>'تم الحفظ بنجاح']);

                }
                
                if( Auth::check() && Auth::user()->id != 636 ){
                return redirect( url('/admin/all-posts') )->with(['Success'=>'تم الحفظ بنجاح']);
                }
                
                return redirect( route('posts.index') )->with(['Success'=>'تم الحفظ بنجاح']);


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


    private function OldPostTracking($old, $new){
        if( $old->status == 1 ){
            $changes = false;

            $diff = ['title','content','excerpt','image','focuskw','slug','type'];

            foreach( $diff as $dif ){
                if( isset($new[$dif]) && isset($old[$dif]) && $new[$dif] != $old[$dif] ){
                    $changes = true;
                    $tracker[$dif] = $old[$dif];
                }
            }

            if( $changes ){
                $tracker['post_id'] = $old->id;
                $tracker['user_id'] = Auth::user()->id;
                \App\oldPosts::create($tracker);
            }
        }
    }

    public function postsEdits(){
        $posts = \App\oldPosts::join('posts','posts.id','=','oldposts.post_id')->select('oldposts.*','posts.title as ptitle','posts.slug as pslug','dob')->paginate(50);
        return view('admin.posts.edits', compact('posts') );
    }

    public function postIDEdits($id){
        $posts = \App\oldPosts::where('post_id', $id)->join('posts','posts.id','=','oldposts.post_id')->select('oldposts.*','posts.title as ptitle','posts.slug as pslug','dob')->paginate(50);
        return view('admin.posts.edits', compact('posts') );
    }

    public function postEdits($id){
        $old = \App\oldPosts::where('id', $id)->first();
        if( !$old ){ return abort(404); }

        $current = Post::where('id', $old->post_id)->first();
        $diff = ['title'=>'العنوان','excerpt'=>'الوصف القصير','image'=>'الصورة الاساسية','focuskw'=>'الكلمة الاساسية','slug'=>'الرابط','type'=>'النوع', 'content'=>'المحتوى'];
       
        foreach( $diff as $kk=>$difss ){
            $dif = $kk;
            if( $old->{$dif} ){
                $diffs[] = $dif;

                if( $dif == 'image' ){
                    $oimg = \DB::table('media')->where('id', $old->image)->select('url')->first();
                    $old->image = $oimg->url;
                    $cimg = \DB::table('media')->where('id', $current->image)->select('url')->first();
                    $current->image = $cimg->url;
                }
                if( $dif == 'content' ){
                    $o = str_get_html($old->content);
                    $n = str_get_html($current->content);

                    $tags = "p,a,li,th,td,span,h1,h2,h3,h4,h5,h6,blockquote,img";

                    $oTags = $o->find($tags);
                    $nTags = $n->find($tags);

                    foreach( $nTags as $k=>$nt ){
                        $op = $nt->tag == 'img' ? 'src' : 'plaintext';
                        if( isset($oTags[$k]) && $nt->{$op} != $oTags[$k]->{$op} ){
                            $nt->setAttribute('class','high');
                            @$oTags[$k]->setAttribute('class','high');
                        }
                    }
                }
            }
        }

        $current->content = $n->outertext;
        $old->content = $o->outertext;

        return view('admin.posts.OldEdit', compact('old','current','diffs','diff') );
    }






    public function bulkAction(Request $request){
        if( !\UPerm::PostsBulkAction() ){
            return back();
        }
        $this->validate(request(),[
            'bulkType' => 'required',
            'BulkPostsIDs'  => 'required'
        ]); 
        
        $msg = '';

        $bulkType = $request->bulkType;
        $BulkPostsIDs = $request->BulkPostsIDs;
        $BulkPostsIDs = trim($BulkPostsIDs,',');
        $BulkPostsIDs = explode(',', $BulkPostsIDs);

        switch($bulkType){
            case 'bekeyword':
                if( !UPerm::BeKeyword() ) return back()->withErrors(['msg'=>'ليس لديك الصلاحية']);
                
                Post::whereIn('id', $BulkPostsIDs)->update(['status'=>3, 'type'=>'null']);
                
            break;
            case 'move':
                if( !UPerm::PostsBulkAction_move() ) return back()->withErrors(['msg'=>'ليس لديك الصلاحية']);

                if( !isset($request->categories4Bulk) || $request->categories4Bulk == 0 ){
                    return back();
                }

                $categories4Bulk = trim($request->categories4Bulk);
                $out = \DB::table('category_post')->whereIn('post_id', $BulkPostsIDs)->delete();
                $new = [];
                foreach( $BulkPostsIDs as $id ){
                    $new[] = ['post_id'=> $id, 'category_id'=> $categories4Bulk];
                }
                \DB::table('category_post')->insert($new);
                $msg = 'تم النقل بنجاح';
            break;
            case 'status':
            if( !UPerm::PostsBulkAction_status() ) return back()->withErrors(['msg'=>'ليس لديك الصلاحية']);
                if( !isset($request->theStatus) || $request->theStatus == 0  || !in_array($request->theStatus , [1,2,3,4]) ){
                    return back();
                }
                $request->theStatus = trim($request->theStatus);
                $now = \Carbon\Carbon::now();
                $up = ['status'=> $request->theStatus, 'updated_at'=> $now];
                if( $request->theStatus == 1 ){
                    $up['created_at'] = $now;
                }
                $update = Post::whereIn('id', $BulkPostsIDs)->update($up);
                if( $update ){
                    $msg = 'تم تغيير الحالة بنجاح';
                }else{
                    $msg = 'حدث خطأ ما';
                }

            break;
            case 'delete':
            if( !UPerm::PostsBulkAction_delete() ) return back()->withErrors(['msg'=>'ليس لديك الصلاحية']);
                Post::whereIn('id', $BulkPostsIDs)->delete();
                $msg = 'تم الحذف بنجاح';
            break;
        }

        return back()->withErrors(['msg'=>$msg]);

    }


    function UsersWordsLength(){

    }

}
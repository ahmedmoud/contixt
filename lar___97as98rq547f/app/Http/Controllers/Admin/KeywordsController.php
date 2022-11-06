<?PHP

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use Illuminate\Support\Facades\Input;
use UPerm;

class KeywordsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $userOldReservedKws = Post::where('user_id', Auth::user()->id )->whereIn('type',['null','post'])->where('status','3')->count();
        $newKeywords = $userOldReservedKws >= 10 ? 'disabled' : '';


        if( UPerm::NoKeywordsLimit() ){
            $newKeywords = '';
        }

        $posts = Post::select('posts.id','title','focuskw','notes')->where('type','null')->where('user_id', 630)->orderBy('id','desc');

            
            if( $request->c ){
                $category = ( is_array($request->c) )? $request->c : [$request->c];
                $posts = $posts->
                join('category_post','category_post.post_id','=','posts.id')->whereIn('category_post.category_id', $category )
                ->join('categories','categories.id','=','category_post.category_id')->whereIn('categories.id', $category );
            }
            if( $request->s ){
                $s = trim($request->s);
                $posts = $posts->where(function ($query) use ($s) {
                    $query->where('title','like',"%$s%")->orwhere('focuskw','like',"%$s%")->orwhere('content','like',"%$s%")->orwhere('notes','like',"%$s%");
                });
            }
  


        $posts = $posts->paginate(30);

        return view('admin.keywords.index', compact('posts','newKeywords'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if( !UPerm::createKeywords() ){
            abort(404);
        }

        return view('admin.keywords.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        if( !UPerm::createKeywords() ){
            abort(404);
        }

        
        $len = $request->length;
        $data = trim($request->data);
        $data = explode("\n", $data);
        array_filter($data, function($value) { return $value !== ''; });
        $now = \Carbon\Carbon::now();
        $new = [
            'user_id' => 630,
            'lang'  => 'ar',
            'type'  => 'null',
            'seoStatus' => 99,
            'created_at' => $now,
            'updated_at' => $now,
            'dob' => $now
        ];
        $erros = [];
        $isRecipe = false;
        foreach( $data as $row ){
            $line = $row = trim($row);
            $row = explode('#', $row);
            $row = array_map('trim', $row); $x = 0;

            $kw = isset($row[$x]) ? $row[$x] : null;

            $slug = isset($row[++$x]) ? $row[$x] : false;


            $length = isset($row[++$x]) ? $row[$x] : null;
            $title = isset($row[++$x]) ? $row[$x] : null;
            $notes = isset($row[++$x]) ? $row[$x] : null;
            $content = isset($row[++$x]) ? $row[$x] : null;

            $notes = ['length'=> $length, 'notes'=>$notes];


            if( $request->is_recipe && $request->is_recipe == '1' ){
                $recipeName = $kw;

                if( !$title ){
                    $title = "طريقة عمل ".$recipeName;
                    $kw = $title;
                }
                $slug = $title;
                $recipe = [
                    'recipeName' => $recipeName
                ];
                $isRecipe = true;
            }else{
                $title = $title ? $title : 'ادخل عنوان مناسب يحتوي على الكلمة الأساسية';
            }


            $slug = !empty($slug) && $slug ? $slug : $kw;
            $suggg = $slug;

            $slug = $this->GSlug($slug);

            if( is_array($slug) && $isRecipe ){
                $slug99  = $this->GSlug($suggg, true);
                $slug999 = Post::where('slug', $slug99)->where('status','!=', 'null')->first();
                if( !$slug999 ){
                    $slug = $this->GSlug($suggg.'-');
                }
            }

            if( is_array($slug) ){ 
                $erros[] = ['slug'=> $slug[0], 'line'=>$line]; 
                continue; 
            }




            $body = $new;
            $body['focuskw'] = $kw;
            $body['title'] = $title;
            $body['notes'] = json_encode($notes);;
            $body['slug'] = $slug;
            $body['content'] = $content;

           $pCount = Post::where('slug', $body['slug'])->count();
           if( $pCount > 0 ) continue;


            $post = Post::create($body);
            $cats = [];
            if( $request->categories ){
                $cats = $request->categories;
            }

            if( isset($recipe) ){
                $recipe['post_id']  = $post->id;
                $cats[] = "11609";
                \App\Recipe::create($recipe);
                $taggs = [];
                foreach( ["مقادير ".$recipeName, $recipeName] as $tag ){
                    $tag = str_replace('-', ' ', $tag);
                    $tag = trim($tag);
                    $tagg = \App\Tag::firstOrCreate(['name'=> $tag]);
                    $taggs[] = $tagg->id;
                }
                $post->tags()->attach($taggs);
            }
      
            $post->categories()->attach($cats);

        }
        if( count($erros) > 0 ){
            return redirect()->back()->with('error', $erros)->withInput(Input::all());; 
        }else{
            return redirect('/admin/keywords');
        }
    }


    private function GSlug($string, $r = false){
        $body['slug'] = $string;
        $slug_ex = [']','[','.','/','@','#','^','*','?','+'];
        foreach( $slug_ex as $se ){
            $body['slug'] = str_replace($se, ' ', $body['slug']);
        }
        $body['slug'] = preg_replace('!\s+!', ' ', $body['slug']);
        $body['slug'] = str_replace(' ', '-', trim($body['slug']) );

        $body['slug'] = urldecode($body['slug']);
        if( strlen($body['slug']) > 45 ){ $body['slug'] = mb_substr($body['slug'],0,45,'utf-8'); $body['slug'] = trim($body['slug']); }
        $body['slug'] = urlencode($body['slug']);
        

        if( $r ){
            return $body['slug'];
        }

        $slugEx = Post::where('slug', $body['slug'] )->count();
        $focuskwx = Post::where('focuskw', $body['slug'] )->count();



        if( $slugEx >=1 || $focuskwx >= 1){
            return [url($body['slug'])];
        }else{
            return $body['slug'];
        }
    }

    public function BulkAction(Request $request){
 
        $this->validate(request(),[
            'bulkKeywords' => 'required',
        ]); 

        $NoKeywordsLimit = UPerm::NoKeywordsLimit();

        if( !$NoKeywordsLimit ){
            $userOldReservedKws = Post::where('user_id', Auth::user()->id )->whereIn('type',['null','post'])->where('status','3')->count();
            if( $userOldReservedKws >= 10 )    return back()->withErrors(['bulkOverflow'=> 'يجب أن يكون لديك أقل من 10 مقالات في المسودات لحجز كلمات دلالية جديدة' ]);
        }
        $now = \Carbon\Carbon::now();
        $body = [
            'user_id' => Auth::user()->id,
            'type'    => 'post',
            'created_at' => $now,
            'updated_at' => $now,
            'dob' => $now
        ];
        $PostsIDs = [];

        $bulkKeywords = trim($request->bulkKeywords);
        $bulkKeywords = explode(',', $bulkKeywords);
        
        foreach( $bulkKeywords as $key=>$bulkKeyword ){
            if( !$bulkKeyword || empty($bulkKeyword) ) continue;

            if( !$NoKeywordsLimit && $key>9 ) break;

            $PostsIDs[] = $bulkKeyword;
        }

        if( count($PostsIDs) >= 1 ){
            Post::whereIn('id', $PostsIDs)->where('type', 'null')->where('user_id', 630)->update($body);
        }


        return back()->withErrors(['bulkOverflow'=> "تم إضافة <b>".count($PostsIDs)."</b> كلمه"]);
        
       
    }

    public function GetPost(Request $request){        
        $this->validate(request(),[
            'postID' => 'required',
        ]); 


        $post = Post::where('id', $request->postID)->where('type', 'null')->where('user_id', 630)->first();
        if( !$post ) return redirect('/admin/kewords');

        if( !UPerm::NoKeywordsLimit() ){
        $userOldReservedKws = Post::where('user_id', Auth::user()->id )->whereIn('type',['null','post'])->where('status','3')->count();
        if( $userOldReservedKws >= 10 )    return back()->withErrors(['manyKeywords'=> true]);
        }

        $now = \Carbon\Carbon::now();


        $body = [
            'user_id' => Auth::user()->id,
            'type'    => 'post',
            'created_at' => $now,
            'updated_at' => $now,
            'dob' => $now
        ];
        if( $post->update($body) ){
            return redirect('/admin/posts/'.$post->id.'/edit');
        }

        return redirect('/admin/kewords');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
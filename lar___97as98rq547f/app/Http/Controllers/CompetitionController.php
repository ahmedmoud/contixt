<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use Auth;
use App\Comp_Image;
use App\Competition;
use Config;
use App\Country;
use App\Region;
use App\Job;
use App\CompetitionSub;
use Image;
use Redirect;
use App\User;
use App\CompetitionVotes;
use App\competitionsComments;

class competitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function getCountries($country){
        return Country::select('id','name')->get();
    }
    public function getRegions($country){
        return Region::where('country_id', $country)->select('id','name')->get();
    }
    public function getCity($region){
        return Country::select('id','name')->get();
    }
    public function subscribe($slug){
        if( !Auth::check() || !Auth::user()->id ){ return redirect( url('competition/'.$slug) ); }   
        $user = Auth::user();
        
        
        if( !( $user->day && $user->month && $user->year && $user->img && $user->mobile && $user->job_id ) ){
            return redirect( url('user-moreInfo').'?return='.url('competition/'.$slug.'/subscribe') );
        }
        $post = Competition::where('slug',urlencode($slug))->where('status',1)->first();
        $subscribed = CompetitionSub::where('user_id', Auth::user()->id)->where('comp_id', $post->id)->first();
        $new = false;
        return view('layouts.competitioin.subscribe', compact('post','subscribed','new'));
    }

    public function upload($slug, Request $request){

        $post = Competition::where('slug',urlencode($slug))->where('status',1)->first();
        if( !$post ) return abort(404);

        $this->validate(request(),[
            'img'    => 'required',
        ]);

        if( !Auth::check() || !Auth::user()->id ) return Redirect::back()->withErrors(['msg'=>'يرجى تسجيل الدخول أولاً']);
        
        $file       = $request->file('img');
        $extension = $file->getClientOriginalExtension();
        $fileNAME    = $file->getClientOriginalName();
        $filename = time().'.'.$extension;
        $mime = $request->img->getClientMimeType();
        if(substr($request->img->getClientMimeType(), 0, 5) == 'image') {
            $type = 'img';
            $image = $file;
            list($width, $height) = getimagesize($request->img);
            $image_resize = Image::make($image->getRealPath());
            if( $width > 900 ){
                $image_resize->resize(900, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }
        $imgName = 'uploads/users/'.$filename;
        $image_resize->save(public_path($imgName));

        $body = $request->except('_token','return','img');

        $data = [ 'img' => $imgName ];
        $body['data'] = json_encode($data);
        $body['comp_id'] = $post->id;
        $body['user_id'] = Auth::user()->id;

        $sub = CompetitionSub::firstOrNew(['user_id' => Auth::user()->id, 'comp_id' => $post->id ]);
        $sub->data = json_encode($data);
        $sub->save();
        
        return redirect()->back()->with('success', 'تم الإشتراك بنجاح!' );
    }
    public function index($slug)
    {
        $post = Competition::where('slug',urlencode($slug));
        if( !Auth::user()  ||  Auth::user()->role_id == null ){
            
            $post = $post->where('status',1);
        }
        $post = $post->first();
        if( !$post ) return abort(404);
      
       
       
        if( $post->image ){
            
        $post_image = Comp_Image::where('id', $post->id)->first();
       if( $post_image ){
            $post->Murl = $post_image->Murl;
            $post->Malt = $post_image->Malt;
       }else{
            $post->Murl  = null;
            $post->Malt  = null;
            $post_image = $post;  
       }
    }else{
    
         $post->Murl  = null;
         $post->Malt  = null;
         $post_image = $post;
        }
        

        $POST = Competition::where('id', $post->id)->first();
        $POST->timestamps = false;
        $POST->views += 1;
        $POST->save();

       $post->excerpt = trim($post->excerpt);
       if( empty($post->excerpt) || strlen($post->excerpt) <= 0 ){
           $post->excerpt = mb_substr(str_replace("\n",' ', strip_tags($post->content)), 0, 700, "utf-8");
       }

        $AD = '<!-- Setaat.com ad 1 --> <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2036644403902115" data-ad-slot="2976936841" data-ad-format="auto"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>';
       


        return view('layouts.competition',compact('post'));
    }

    public function competitionUser($slug, $user){
        $user = User::where('id', $user)->first();
        if( !$user ) return abort(404);
        $comp = Competition::where('slug', urlencode($slug) )->where('status', 1)->first();
        if( !$comp ) return abort(404);

        $compsub = CompetitionSub::where('comp_id', $comp->id)->first();
        if( !$compsub ) return abort(404);
        if( $compsub->status != 1 ){
            return Redirect::to('/competition/'.$slug.'/subscribe')->with(['UnderReview'=>true]);
        }

        $compsub->data = json_decode($compsub->data);
        if( !$compsub ) return abort(404);
        $Rates = CompetitionVotes::where('sub_id', $compsub->id)->select(\DB::raw("AVG(vote) as rate, count(id) as total"))->first();
        $myRate = CompetitionVotes::where('sub_id', $compsub->id)->where('user_id', Auth::user()->id)->select('vote')->pluck('vote');
        $comments = competitionsComments::where('sub_id',$compsub->id)->where('status',1)->get();

        return view('layouts.competitioin.compPage', compact('user', 'comp', 'compsub','Rates','myRate','comments') );
    }

    public function RateIt(Request $request){
        if( $request->ajax() ){
        $this->validate(request(),[
            'sub_id'    => 'required',
            'value'    => 'required',
        ]);
        
        if( !in_array($request->value, range(1,5) ) ) return 'bad';
        if( !Auth::check() || !Auth::user()->id ) return 'bad';
        $rate = CompetitionVotes::firstOrNew( ['user_id'=>Auth::user()->id, 'sub_id'=> $request->sub_id]);
        $rate->vote = $request->value;
        $rate->save();
        return 1;
        }
    }
    
    public function competitionCommnet(Request $request){
        if( $request->ajax() ){
        
        $this->validate(request(),[
            'sub_id'    => 'required',
            'comment'    => 'required',
        ]);
        if( !Auth::check() || !Auth::user()->id ) return json_encode(['status'=>false]);

        $body = $request->except('_token');
        $body['user_id'] = Auth::user()->id;
        $comment = competitionsComments::create($body);
        if( $comment ) {
        $html = view('layouts.templates.comment',compact('comment'))->render();
                    return response(['status'=>true,'result'=>$html]);
        }
        return json_encode(['status'=>false]);
    }
    }
    public function removeCompetitionComment(Request $request){

        if( $request->ajax() ){
            $commentID = $request->CommentID;
            $user = ( Auth::check() )? Auth::user() : false;
            if( !$user ) return response()->json(['status'=>false]);

            $comment = competitionsComments::where('id', $commentID)->first();
            if( !$comment ) return response()->json(['status'=>false]);
          
            if( $comment->user_id != $user->id ) return response()->json(['status'=>false]);
           
            $comment = competitionsComments::where('id', $commentID)->delete();
            if( $comment ) return response()->json(['status'=> true]); 
            
        }
    }

}

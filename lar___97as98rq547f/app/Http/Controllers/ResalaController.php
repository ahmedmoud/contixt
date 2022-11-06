<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Auth;
use App\User;
use Illuminate\Pagination\Paginator;


class ResalaController extends Controller
{


    public function index($id = false){
        
        $sViews = setting('ResaltSetaatViews');
        $sViews++;
        setting(['ResaltSetaatViews' => $sViews])->save();;
        if( $id ){
            $art = Post::where('id', $id)->where('type', 'resala')->where('status', 1)->first();
            if( !$art ) return redirect('رسالتك-من-ستات', 301);
            if( !$art->excerpt ){
                $art->excerpt = 'رسالتك من ستات النهارده : '.$art->title.' - '.$this->ArabicDate($art->date);
            }
        }else{
            $art = Collect();
            $art->title =  'رسالتك من ستات';
            $art->slug = 'رسالتك-من-ستات';
            $art->excerpt = 'رسالتك من ستات - رسالة يومية';
        }
        $posts = Post::where('type','resala')->where('status',1)->where('created_at','<=',  \Carbon\Carbon::now() )->orderby('created_at', 'desc')->paginate(30);
        foreach( $posts as $post ){
            $post->date = $this->ArabicDate($post->created_at);
            if( \Carbon\Carbon::parse($post->created_at)->format('y/m/d') == date('y/m/d') ){
                $post->date = 'اليوم';
            }elseif( \Carbon\Carbon::parse($post->created_at)->format('y/m/d') == date('y/m/d',strtotime("-1 days")) ){
                $post->date = 'الأمس';
            }
        }
        $postCats = [];
    $postCats[0] = Collect();
    $postCats[0]->name = 'رسالة ستات';
        return view('layouts.resala', compact('posts','art','sViews','postCats') );
        
    }

    public function getComments(Request $request){

        $this->validate(request(),[
            'id' => 'required',
        ]);

        $currentPage = isset($request->page)? $request->page : 1;

        Paginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });

        $comments = Comment::join('users','users.id','=','comments.user_id')->where('comments.post_id', $request->id)->where('comments.status', 1)->select('username','user_id','comments.id','comment')->orderBy('id','desc')->paginate(5);

        $output = ['comments'];
        foreach( $comments as $comment ){
            $outputt = [];
            $user = User::where('id', $comment->user_id)->select('username')->first();
            $outputt['user_name'] = $user->username;
            $outputt['is_owner'] = ( Auth::check() && $comment->user_id == Auth::user()->id )? true : false;
            $outputt['comment_id'] = $comment->id;
            $outputt['commentBody'] = $comment->comment;
            $output['comments'][] = $outputt;
        }
        $output['data'] = [
            'currentPage' => $comments->currentPage(), 
            'lastPage' => $comments->lastPage(), 
            'id'    => $request->id
        ];
        
        return \Response::json($output);
    }




    
    function ArabicDate($date) {
        $date = \Carbon\Carbon::parse($date);

        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");

        $en_month = $date->format('M');
        foreach ($months as $en => $ar) {
            if ($en == $en_month) { $ar_month = $ar; }
        }
    
        $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
        $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = $date->format('D'); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);
    
        $standard = array("0","1","2","3","4","5","6","7","8","9");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
        $current_date = $ar_day.' '.$date->format('d').'  '.$ar_month.'  '.$date->format('Y');
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);
    
        return $arabic_date;
    }
    

}
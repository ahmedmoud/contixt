<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use App\Posts_Image;
use Illuminate\Support\Facades\DB;
use Setting;
use Cache;
use Mobile;
use App\Resala;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slocale = \App::isLocale('en') ? 'en_' : '';
        \View::share('slocale', $slocale);
        
        @define('HOME', 'ستات دوت كوم');

        $is_mobile = Mobile::isMobile();
        // if( $is_mobile ){
        //     $resala = Post::where('type','resala')->where('created_at','<=',  \Carbon\Carbon::now() )->select('title','content')->where('status', 1)->where('posts.lang', \App::getLocale() )->orderBy('created_at', 'DESC')->limit(3)->get();
        //     return view('layouts.home',compact('is_mobile','resala'));
        // }


                $postCats = [];
                $postCats[0] = Collect();
                $postCats[0]->name = 'الصفحة الرئيسية - فودو';
                

        if( isset($_GET['amp']) ){
            // return view('AMP.home',compact('is_mobile','firstPost','rightPost','leftPost','recent', 'resala','postCats','final'));
        }

        $random = Post::where('type','post')->where('status', 1)->where('posts.lang', \App::getLocale() )->inRandomOrder()->first();
        $randomMurl = Posts_Image::select('Murl')->where('created_at','<=',  \Carbon\Carbon::now() )->where('id', $random->id)->first();
        $random->Murl = $randomMurl->Murl;

        $theRecipeTypes = $random->recipe->types()->select('name')->where('type','cuisine')->pluck('name')->toArray();
        $theRecipeTypes = $theRecipeTypes && is_array($theRecipeTypes) ? implode(' و', $theRecipeTypes) : '';

        $cookTime = $random->recipe->cookTime;
        $cookTime = explode(':', $cookTime);
        $cookTimeH = @trim($cookTime[0]);
        $cookTimeH = (int) $cookTimeH;
        $cookTimeM = @trim($cookTime[1]);
        $cookTimeM = (int) $cookTimeM;
        $cookTime = $cookTimeH > 0 ? $cookTimeH."H" : '';
        $cookTime .= $cookTimeM > 0 ? $cookTimeM."M" : '';



        $random->excerpt = "بنقدملك طريقة عمل <strong>".$random->recipe->recipeName."</strong> الشهية من المطبخ ".$theRecipeTypes." بوصفة سهلة وتقدري تعمليها فى اقل من ".$cookTimeM." دقيقة. اعرفي مكونات ومقادير ".$random->recipe->recipeName.".جربيها وبالهنا والشفا";


        return view('layouts.home',compact('is_mobile','recent','postCats', 'random'));
    }

}
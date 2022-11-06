<?php

namespace App\Http\Controllers;

use App\Category;
use App\Category_post;
use App\Post;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Media;

class CustomTemplatesController extends Controller
{

    public function BreastCancer($category,$posts,$cats,$parents){
        $posts = $posts->get()->keyBy('id');

        $d = \DB::table('settings')->where('key', 'BreastCancer')->first();
        $value = $d->value;
        $value = json_decode( $value );

        $firstFive = $value->firstFive;
        $firstFive = explode(',', $firstFive);
        $firstFivePosts = [];
        
        foreach( $firstFive as $k=>$f ){
            if( isset($posts[ $f ]) ){
                $firstFivePosts[] = $posts[ $f ];
            }
        }
        
        $output = Collect();
        $output->firstFive = $firstFivePosts;


        $secondBlock = $value->secondBlock;
        $secondBlockPosts = [];

    foreach ( $secondBlock as $n=> $f ){
        $ids = $f->ids;
        $ids = explode(',', $ids);
        foreach( $ids as $id ){
            if( isset($posts[ $id ]) ){
               $secondBlockPosts[$n]['posts'][] = $posts[ $id ];
               $secondBlockPosts[$n]['title'] = $f->title;
            }
        }
    }
    $output->secondBlock = $secondBlockPosts;

    foreach( ['thirdSection','fourthSection','fifthSection'] as $k=>$name ){
        $Block = $value->{ $name };

        $ids = explode(',', $Block->ids );
        $FD = [];
        
        foreach( $ids as $id ){
            if( isset($posts[ $id ]) ){
               $FD['posts'][] = $posts[ $id ];
               $FD['title'] = $Block->title;
            }
        }
        
        $output->{ $name } = $FD;
    }
    $lastSix = $value->sixthSection;
    $lastSix = explode(',', $lastSix);
    $lastSixP = [];
    
    foreach( $lastSix as $k=>$f ){
        if( isset($posts[ $f ]) ){
            $lastSixP[] = $posts[ $f ];
        }
    }
    $output->lastSix = $lastSixP;
    $videos = []; 

    foreach( $posts as $post ){
        // dd( $post );
        if( $post->type == 'video' ) $videos[] = $post;
    }
    $output->videos = $videos;

    if( isset($_GET['ash']) ){
        dd( $videos );
    }

    $breastCancer = true;

        return view('layouts.CustomTemplates.breastCancer',compact('category','posts', 'output' ,'cats','parents','$breastCancer'));
}

    public function Autism($category,$posts,$cats,$parents){
        $posts = $posts->get()->keyBy('id');

        $d = \DB::table('settings')->where('key', 'Autism')->first();
        $value = $d->value;
        $value = json_decode( $value );

        $firstFive = $value->firstFive;
        $firstFive = explode(',', $firstFive);
        $firstFivePosts = [];
        
        foreach( $firstFive as $k=>$f ){
            $f = trim($f);
            if( isset($posts[ $f ]) ){
                $firstFivePosts[] = $posts[ $f ];
            }
        }
        
        $output = Collect();
        $output->firstFive = $firstFivePosts;


        $secondBlock = $value->secondBlock;
        $secondBlockPosts = [];

    foreach ( $secondBlock as $n=> $f ){
        $ids = $f->ids;
        $ids = explode(',', $ids);
        foreach( $ids as $id ){
            $id = trim($id);
            if( isset($posts[ $id ]) ){
            $secondBlockPosts[$n]['posts'][] = $posts[ $id ];
            $secondBlockPosts[$n]['title'] = $f->title;
            }
        }
    }
    $output->secondBlock = $secondBlockPosts;

    
    $lastSix = $value->sixthSection;
    $lastSix = explode(',', $lastSix);
    $lastSixP = [];

    foreach( $lastSix as $k=>$f ){
        $f = trim($f);
        if( isset($posts[ $f ]) ){
            $lastSixP[] = $posts[ $f ];
        }
    }
    $output->lastSix = $lastSixP;
    $videos = []; 

    foreach( $posts as $post ){
        if( $post->type == 'video' ) $videos[] = $post;
    }
    $output->videos = $videos;

    $breastCancer = true;

        return view('layouts.CustomTemplates.Autism',compact('category','posts', 'output' ,'cats','parents','breastCancer'));
    }

}
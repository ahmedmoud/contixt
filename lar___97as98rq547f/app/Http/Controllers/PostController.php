<?php

namespace App\Http\Controllers;

use App\Category;
use Http;
use App\Post;
use Illuminate\Http\Request;
use App\Comment;
use Auth;
use App\Favourite;
use App\Posts_Image;
use Media;
use DB;
use View;
use App\Tag;
use App\Competition;
use SEOAgent;

class PostController extends Controller
{

    public function fixSEO(){
        $post = Post::where('lang', 'ar')->whereNotNull('focuskw')->whereIn('type', ['video','post'])->whereNull('seoStatus')->first();
        if( !$post ) return abort(404);
        $rate = SEOAgent::fetchReport($post, true);
        $post->update(['seoStatus'=>$rate]);
        return '1';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function postByID($id){
      
        $post = Post::where('type','post')->where('status',1)->where('id', $id)->first();
       
        if( $post )
            return $this->index(urldecode($post->slug));
        else    
            return abort(404);
    }

    public function checkURL($slug){
        $post = Post::where('type','post')->where('slug', urlencode($slug) )->first();
        if( $post ) return redirect($slug);
        $sluggy = $slug;
        $slug = str_replace('-',' ', $slug);
        $tag = Tag::where('name', $slug)->first();
        if( !$tag ){
           $tag = Tag::where('name','like',"%$slug%")->first();
           if( $tag ){
               
               $sluggy = str_replace(' ','-', $tag->name);
           }
        }
        if( $tag ) return redirect('/tag/'.$sluggy, 301);
/*
// redirect to similar post....

           $s = urldecode($slug);
                $s = str_replace('-',' ', $s);
                $s = trim($s);
                $length = strlen($slug) / 3;
                $length = floor($length);
                
                $s = mb_substr($s,0, $length , "utf-8");
                $s = trim($s);
                
            $post = Post::where('type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('title','like',"%".$s."%")->where('status', 1)->first();

                if( $post ){
                    return redirect($post->slug, 301);
                }

                */
        return abort(404);
    }

    public function index($slug, $ampoo = '' )
    { 

 
        $amp = ( isset($_GET['amp']) || $ampoo == 'amp' );

        $is_category = Category::where('slug',urlencode($slug))->count();
        if( $is_category ) return app('App\Http\Controllers\CategoryController')->index($slug);

        $is_competition = Competition::where('slug',urlencode($slug))->count();
        if( $is_competition ) return app('App\Http\Controllers\CompetitionController')->index($slug);


        $post = Post::whereIn('type',['post','video'] )->where('slug',urlencode($slug))->where('lang', \App::getLocale() );
       
        if( !Auth::user()  ||  Auth::user()->role_id == null ){
            $post = $post->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('status',1);
        }
        $post = $post->first();
        if( !$post && strpos($slug, ' ') !== false ){
            $slug = str_replace(' ','-', $slug);
            $slug = urlencode($slug);
            $post = Post::where('type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('slug', $slug )->where('status', 1)->first();
            
            if( $post ) return redirect($slug, 301);
        }

        /*
        if( !$post ){
        if( strpos($slug,'+') !== false ){
            $post = Post::where('type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('slug',str_replace('+','-',trim($slug)) )->where('status', 1)->first();
        }
        
        if( !$post ){
        $post = Post::where('type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('title','like',"%".urldecode(str_replace('-',' ',$slug)."%" ))->where('status', 1)->first();
            if( $post ){
                return redirect($post->slug, 301);
            }else{
                $s = urldecode($slug);
                $s = str_replace('-',' ', $s);
                $s = trim($s);
                $length = strlen($slug) / 3;
                $length = floor($length);
                
                $s = mb_substr($s,0, $length , "utf-8");
                $s = trim($s);
                
           
                $post = Post::where('type','post')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('title','like',"%".$s."%")->where('status', 1)->first();

                if( $post ){
                    return redirect($post->slug, 301);
                }
                
                    return abort(404);
                
            }
        }

        }
        */


      if( !$post ){
          $redirection = new \App\Redirection();
          return $redirection->RedirectURL( url($slug) );
      }
      
        if( !Auth::user()  ||  Auth::user()->role_id == null ){
            
        }
        $postCats = $post->categories()->get();
        $Mcats = $postCats;
        if( !isset($Mcats[0]) ){
            $Mcats = [ Category::find(1) ];
        }
        $Mcat = $Mcats[0];

         
        $BreadCats = $Mcat->getParents();
        $BreadCats = $BreadCats->reverse();        
        $BreadCats[] = $Mcat;
       
        if( $post->image ){
    
        $post_image = Posts_Image::where('created_at','<=',  \Carbon\Carbon::now() )->where('id', $post->id)->first();
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



        $GLOBALS['posts'][] = $post->id;
        $tags = $post->tags;
        
        $POST = Post::whereIn('type',['post','video'])->where('id', $post->id)->first();
        $POST->timestamps = false;
        $POST->views += 1;
        $POST->save();

       $post->excerpt = trim($post->excerpt);


        // future updates checker
        $postFutureUpdate = $this->checkPostsFUPdates($post, true);
        if( $postFutureUpdate ){
            $post->content = $postFutureUpdate->content;
            $post->updated_at = $postFutureUpdate->date;
        }

        
        // shortcodes applier
           $post->content = app('App\Http\Controllers\ShortcodeController')->filter($post->content);
            


       if( empty($post->excerpt) || strlen($post->excerpt) <= 0 ){
           $post->excerpt = mb_substr(html_entity_decode (str_replace("\n",' ', strip_tags($post->content))), 0, 250, "utf-8");
       }

       $theRecipe = Collect();

       $keywords = [];
      foreach( $tags as $t ){ 
          $keywords[] = $t->name.',';
      }
      $keywords = implode(',', $keywords);

      
      $Rates = $this->postRates($post);

 $schema = array(
			'@context'       => 'http://schema.org',
			'@type'          => 'NewsArticle', 
			'dateCreated'    => date($post_image->created_at),
			'datePublished'  => date($post_image->created_at),
			'dateModified'   => date($post_image->updated_at),
			'headline'       => $post->title,
			'name'           => $post->title,
			'keywords'       => $keywords,
			'url'            => url($post->slug),
			'description'    => strip_tags($post->excerpt),
            'articleBody'    => strip_tags($post->content),
		'copyrightYear'  => date("Y"),
			'publisher'      => array(
					'@id'   => url('/'),
					'@type' => 'Organization',
					'name'  => "ستات دوت كوم",
					'logo'  => array(
							'@type'  => 'ImageObject',
							'url'    => asset('assets/frontend/base/img/logo.png'),
					)
			),
			'sourceOrganization' => array(
					'@id' => url('/')
			),
			'copyrightHolder'    => array(
					'@id' => url('/')
			),
			'mainEntityOfPage' => array(
					'@type'      => 'WebPage',
					'@id'        => url($post->slug),
            ),
            "interactionStatistic"=> array(
                  "@type"=> "InteractionCounter",
                  "interactionType"=> "http://schema.org/CommentAction",
                  "userInteractionCount"=> $post->comments()->count()
            ),
			'author' => array(
					'@type' => 'Organization',
					'name'  => "ستات دوت كوم",
					'url'   => url('/'),
            ),
            "aggregateRating" => array(
                "@type" => "AggregateRating",
                "ratingValue" => round($Rates->rate, 1),
                "reviewCount" => $Rates->total
            ),
        );
 


    if( $post->recipe ){

        if( $post->RelatedPosts ){  
            $temp = array();
            $post->RelatedPosts = json_decode($post->RelatedPosts );
            foreach( $post->RelatedPosts as $k=>$srpost ){
                $_srpost = Post::select('title','slug')->where('id',$srpost->id)->first();
                if( !$_srpost ){ continue; }

                $Tempo = Collect();
                $Tempo->id = $srpost->id;
                $Tempo->text = $srpost->text;
                $Tempo->title = $_srpost->title;
                $Tempo->slug = $_srpost->slug;


                $temp[$k] = $Tempo;
            }
            $post->RelatedPosts = $temp;
        }else{
            $post->RelatedPosts = false;
        }
 
        if( isset($_GET['ash']) ){
            dd( $post->RelatedPosts ); 
        }

        $cookTime = $post->recipe->cookTime;
        $cookTime = explode(':', $cookTime);
        $cookTimeH = @trim($cookTime[0]);
        $cookTimeH = (int) $cookTimeH;
        $cookTimeM = @trim($cookTime[1]);
        $cookTimeM = (int) $cookTimeM;
        $cookTime = $cookTimeH > 0 ? $cookTimeH."H" : '';
        $cookTime .= $cookTimeM > 0 ? $cookTimeM."M" : '';


        $theCuisine = $post->recipe->types()->where('type','cuisine')->select('name')->pluck('name')->toArray();
        $theCuisine = implode(',', $theCuisine);

        $theCategory = $post->recipe->types()->where('type','normalTypes')->select('name')->pluck('name')->toArray();
        $theCategory = implode(',', $theCategory);

        $theCookMethod = $post->recipe->types()->where('type','cookMethod')->select('name')->pluck('name')->toArray();
        $theCookMethod = implode(',', $theCookMethod);

        $theCost = $post->recipe->types()->where('type','cost')->select('name')->pluck('name')->toArray();
        $theCost = implode(',', $theCost);
            
        $post->recipe->theCuisine = $theCuisine;
        $post->recipe->theCookMethod = $theCookMethod;
        $post->recipe->theCategory = $theCategory;
        $post->recipe->theCost = $theCost;

        switch($post->recipe->difficulty ){
            case 'e': $post->recipe->difficulty  = 'سهله'; break;
            case 'm': $post->recipe->difficulty  = 'متوسطه'; break;
            case 'd': $post->recipe->difficulty  = 'صعبه'; break;
        }
     

        $prepTime = $post->recipe->prepTime;
        $prepTime = explode(':', $prepTime);
        $prepTimeH = @trim($prepTime[0]);
        $prepTimeH = (int) $prepTimeH;
        $prepTimeM = @trim($prepTime[1]);
        $prepTimeM = (int) $prepTimeM;
        $prepTime = $prepTimeH > 0 ? $prepTimeH."H" : '';
        $prepTime .= $prepTimeM > 0 ? $prepTimeM."M" : '';

        $totalTimeH = $cookTimeH + $prepTimeH;
        $totalTimeM = $cookTimeM + $prepTimeM;

        $post->recipe->totalTime = $totalTimeH * 60 + $totalTimeM;
        $post->recipe->prepTimeM = $prepTimeH * 60 + $prepTimeM;
        $post->recipe->cookTimeM = $cookTimeH * 60 + $cookTimeM;


        $totalTime = $totalTimeH > 0 ? $totalTimeH."H" : '';
        $totalTime .= $totalTimeM > 0 ? $totalTimeM."M" : '';

        

        $ingredients = explode("\n", $post->recipe->ingredient);
        $ingredients = str_replace("\r", "", $ingredients); 
       
        $recipeInstructions = explode("\n", $post->recipe->instructions);
        $recipeInstructions = str_replace("\r", "", $recipeInstructions);
        

    

        $theRecipeTypes = $post->recipe->types()->select('name')->where('type','cuisine')->pluck('name')->toArray();
        $theRecipeTypes = $theRecipeTypes && is_array($theRecipeTypes) ? implode(' و', $theRecipeTypes) : '';


        if( !$post->excerpt || empty($post->excerpt) ){
            $post->excerpt = "بنقدملك طريقة عمل <strong>".$post->recipe->recipeName."</strong> الشهية من المطبخ ".$theRecipeTypes." بوصفة سهلة وتقدري تعمليها فى اقل من ".$cookTimeM." دقيقة. اعرفي مكونات ومقادير ".$post->recipe->recipeName.".جربيها وبالهنا والشفا";
        }
        
        
        $theRecipe->ingredients = $ingredients;
        $theRecipe->instructions = $recipeInstructions;
  



        foreach( $recipeInstructions as $key=>$ins ){
            $recipeInstructions[$key] = array(
                '@type' => "HowToStep",
                "text"  =>  $ins
            );

        }
        
        $schema = array(
            '@context'       => 'http://schema.org',
            '@type'          => 'Recipe', 
            'dateCreated'    => date($post_image->created_at),
            'datePublished'  => date($post_image->created_at),
            'dateModified'   => date($post_image->updated_at),
            'headline'       => $post->title,
            'name'           => $post->title,
            'keywords'       => $post->focuskw,
            'url'            => url($post->slug),
            'description'    => strip_tags($post->excerpt),
            "prepTime" => "PT$prepTime",
            "cookTime" => "PT$cookTime",
            "totalTime" => "PT$totalTime",
            "recipeYield" => $post->recipe->yield,
            "recipeCategory" => $theCategory,
            "recipeCuisine" => $theCuisine,
            "cookingMethod" => $theCookMethod,
            "recipeInstructions" => $recipeInstructions,
            "nutrition" => array(
                "@type" => "NutritionInformation",
                
            ),
            "recipeIngredient"=> $ingredients,

            'copyrightYear'  => date("Y"),
            'publisher'      => array(
                    '@id'   => url('/'),
                    '@type' => 'Organization',
                    'name'  => website_name,
                    'logo'  => array(
                            '@type'  => 'ImageObject',
                            'url'    => asset('assets/frontend/base/img/logo.png'),
                    )
            ),
            'sourceOrganization' => array(
                    '@id' => url('/')
            ),
            'copyrightHolder'    => array(
                    '@id' => url('/')
            ),
            'mainEntityOfPage' => array(
                    '@type'      => 'WebPage',
                    '@id'        => url($post->slug),
            ),
            "interactionStatistic"=> array(
                "@type"=> "InteractionCounter",
                "interactionType"=> "http://schema.org/CommentAction",
                "userInteractionCount"=> $post->comments()->count()
            ),
            'author' => array(
                    '@type' => 'Person',
                    'name'  => 'مطبخ ستات' 
            ),
            "aggregateRating" => array(
                "@type" => "AggregateRating",
                "ratingValue" => $Rates->rate >= 1 ? round($Rates->rate, 1) : 4.2,
                "reviewCount" => $Rates->total <= 0 ? 15 : $Rates->total
            ),
        );


        if( $post->recipe->diet ){
            $schema["nutrition"]["suitableForDiet"] = "http://schema.org/".$post->recipe->diet;
        }
        if( $post->recipe->calories ){
            $schema["nutrition"]["calories"] = $post->recipe->calories." calories";
        }
        if( $post->recipe->fatContent ){
            $schema["nutrition"]["fatContent"] = $post->recipe->fatContent." grams fat";
        }

        if( $post->recipe->videoURL ){
        
            $theThumbnail = $post->recipe->videoThumbnail ? $post->recipe->videoThumbnail : url(Media::ClearifyAttach($post->Murl, 'thumbnail'));
            $schema["video"] = [
                "@type" => "VideoObject",
                        "name" => $post->title,
                        "description" => $post->excerpt,
                        "thumbnailUrl" => [
                            $theThumbnail
                        ],
                        "contentUrl" => $post->recipe->videoURL,
                        "embedUrl" => $post->recipe->videoURL,
                        "uploadDate" => $post->created_at
 
                    ];
        }
    }
    
    if( $post->image ){
        $schema['image'] = array(
            '@type' => 'ImageObject',
            'url'  => url(Media::ClearifyAttach($post->Murl, 'thumbnail'))
        );
    }

        $schema = '<script type="application/ld+json">'. json_encode( $schema ) .'</script>';

       
        $AD = '<!-- Setaat.com post inner content --> <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2036644403902115" data-ad-slot="5310828123" data-ad-format="auto" data-full-width-responsive="true"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>';
       /*
                $match_img = '/<img[^>]+>/i';  
                preg_match_all($match_img, $post->content, $results);

                if( isset($results[0]) && $results[0] ){
                    foreach( $results[0] as $result ){
                        //$post->content = str_replace( $result, $result.$AD, $post->content );
                        $post->content = str_replace( $result, $result.$AD, $post->content );
                    }
                }     
        */
        
        $comments = Comment::where('post_id',$post->id)->where('status',1)->get();
        $Centeredrelated = $this->getRelated($post);

        // Auto Link By Focus Keyword
        $post->content = $this->autoLink($post->content, $post->focuskw);
        

        $content = $post->content;
        $content = trim($content);
        $content = str_replace('<p></p>','', $content);
       
        $toRender = false;
        $iden = ['</p>', '</ul>','</ol>','</table>','</h2>'];
        
        foreach( $iden as $ide ){
            $content_arr = explode($ide, $content);
            if( count($content_arr) > 1 ){
                $iden = $ide;
                $toRender = true; break;
            }else{
            $content_arr = implode($ide, $content_arr);
            }
        }
         
       
        if( $toRender && !$amp ){
            if( !$post->recipe ){
                $h = View::make('components.other.relatedInMiddlePost')->withPosts($Centeredrelated);
                $h = $h->render();
            }else{
                $h = '';
            }
            $content_arrC = $lengC = count($content_arr);
            $content_arrC /= 2;
            $content_arrC = ceil($content_arrC);
            
            $content_arrC = ( isset($content_arr[$content_arrC]) )? $content_arrC : $content_arrC = 1;;
            $content_arr[$content_arrC] = $content_arr[$content_arrC].$h;

            
            $content_arr = implode($iden, $content_arr);
            
            
        }else{
            $content_arr = $post->content;
        }
       
        $content = str_replace('<p></p>','', $content_arr);
        $content_arr = explode('</p>', $content);
             
            
            $content_arr[0] .= '';
            
            
            if( isset($content_arr[1]) ){
                $content_arr[1] .= '<ins class="adsbygoogle"  style="display:block; text-align:center;" data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-2036644403902115" data-ad-slot="9252528823"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>';
            }
         

            if( isset($content_arr[2]) && $post->id == 57533 ){
                $content_arr[2] .= View::make('layouts.parts.forms.Reservation');
            }
            
            $content_arr = implode('</p>', $content_arr);


        $post->content = $content_arr;
        $related = $this->getRelated($post);

        $post->content = trim(str_replace("http://www.setaat.com/wp-content/",env('MAX_CDN_DOMAINabs')."/wp-content/", $post->content));

        $latests = Posts_Image::where('created_at','<=',  \Carbon\Carbon::now() )->select('slug','title','id','Murl')->where('status',1)->whereNotIn('id', $GLOBALS['posts'])->orderBy('views','DESC')->limit(3)->get();

$re = '/\[caption([^\]]+)\](\s*\<a[^>]+>)(\s*\<img[^>]+>)\s*(.*?)\s*\[\/caption\]/';
$subst = '<div\\1 class="wp-caption">\\2     <p class="caption">\\3  \\4</p></div>';
$result = preg_replace($re, $subst, $post->content);
$post->content = $result; 

    $GLOBALS['posts'] = array_merge($GLOBALS['posts'], $latests->pluck('id')->toArray());
    if(  Auth::check() && Auth::user()->role_id != null ){
        $the_author = $post->author()->select('username')->first();
    }
    $blockAdsense = false;
    foreach( $postCats as $pcat ){
        if( in_array($pcat->id, [3796, 25] ) ){
            $blockAdsense = true;
        }
    }


    $text = preg_replace('!\s+!', ' ', $post->content );
    $text = explode(' ', $text);
    $count = count($text);
    $new = [];
    $sAd = app('App\Http\Controllers\Admin\AdsController')->getCode(39,40);

    if( $count > 1000 ){
        $tLength = 0;
        $h = str_get_html($post->content);
        $htags = "h1,h2,h3,h4,h5,h6,p,li,blockquote,";
        foreach( $h->find($htags) as $tag ){
            $text = preg_replace('!\s+!', ' ', $tag->plaintext );
            $length = explode(' ', $text);
            $length = count($length);
            
            if( $length >= 500 || $tLength >= 500 ){
                $tag->outertext .= $sAd;
                $tLength = 0;
            }else{
                $tLength += $length;
            }
        }
        $post->content = (string)$h;
    }

    $post->content = str_replace('target="_blank"','', $post->content);
    $post->content = str_replace("target='_blank'",'', $post->content);

    if( $post->recipe ){
        $recipeContent = view('layouts.templates.recipe', ['recipe' => $post->recipe, 'theRecipe'=>$theRecipe,'post' => $post] );
        $recipeContent =  $recipeContent->render();
        $post->content = $recipeContent.$post->content;
    }


    if( !empty($post->content) ){ 
        $post->content = $this->TableOfContents( $post->content ); 
    }
    $post->txt_lastUpdate = $this->ArabicDate($post->updated_at);

if( $amp ){

if( $post->content && !empty($post->content) ){
    $post->content = preg_replace('#<div(.*?)id="attachment_(.*?)width="(.*?)"(.*?)>#','<div $1 $4', $post->content);
    $post->content = preg_replace('#<div(.*?)height="(.*?)"(.*?)>#','<div  $1 $3', $post->content);
    $html = str_get_html($post->content);
    if( $html->find('img') && count($html->find('img') ) > 0 ){

        foreach( $html->find('img') as $img ){
            $src = $img->getAttribute('src');
            
              $baud = explode(".com/", $src);
              $baud = "./".end($baud);
              $rp = realpath($baud);
              if( file_exists($rp) ){
                list($width, $height, $type, $attr) = getimagesize( $baud );
                
            $img->outertext = "<amp-img src='".$src."' layout='responsive' width='$width' height='$height'></amp-img>";
              }else{
                  $img->outertext = '';
              }
        }
        $post->content = (string) $html; 
    }
    if( $html->find('iframe') && count($html->find('iframe') ) > 0 ){

        foreach( $html->find('iframe') as $aScri ){ 
            $src = $aScri->getAttribute('src');
            $width = @$aScri->getAttribute('width') ? $aScri->getAttribute('width') : '';
            $height = @$aScri->getAttribute('height') ?  $aScri->getAttribute('height') : '';
            $height = $height && !empty($height) ? $height : $width;
            if( strpos($src, 'youtube') !== false ){
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match);
                if( isset($match[1]) ){
                    $attr = " data-videoid='".$match[1]."' ";
                    $tag = 'amp-youtube';
                }else{
                    $attr = "frameborder='0' src='".$src."'";
                    $tag = 'amp-iframe';
                }
            }else{
                $attr = "frameborder='0' src='".$src."'";
                $tag = 'amp-iframe';
            }

            $aScri->outertext = "<$tag  layout='responsive' $attr width='$width' height='$height'></$tag>";
        }
        $post->content = (string) $html;
    }
    if( $html->find('script') && count($html->find('script') ) > 0 ){

        foreach( $html->find('script, ins') as $aScri ){ 
            $aScri->outertext = "";
        }
        $post->content = (string) $html;
    }
}
    
    return view('AMP.post',compact('post','tags','comments','latests', 'related','schema','BreadCats','Rates','the_author','postCats','blockAdsense'));

}

    return view('layouts.post',compact('post','tags','comments','latests', 'related','schema','BreadCats','Rates','the_author','postCats','blockAdsense'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|unique:posts|min:10',
            'content' => 'nullable',
            'categories' => 'nullable',
            'image' => 'nullable'
        ]);

        $body = $request->except('_token');
        if(!$request->slug){
            $body['slug'] = Http::GenerateSlug('App\Post', $request->title);
        }
        $body['user_id'] = Auth::id();

        $post = Post::create($body);
        return redirect('/admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
            $body = array_filter(
                $request->except('_token','_method'),
                'strlen'
            );
            $post->update($body);
            return redirect($post->url->index);
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
        $post->delete();

        return redirect($post->url->index);
    }

    public function postRates(Post $post){
        $out = $post->rates()->select(DB::raw("AVG(rate) as rate, count(id) as total"))->first();
        return $out;
    }

    public function favourite()
    {
        abort_if(!Auth::check(),404);
        $favourites = Favourite::where('user_id',Auth::user()->id)->select('post_id')->pluck('post_id')->toArray();
        //$posts = Post::whereIn('id',$favourites)->paginate(8);

        $posts  = DB::table('posts_images as posts')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('posts.status',1)->whereIn('posts.id', $favourites)->
        join('category_post','category_post.post_id','=','posts.id')
        ->join('categories','categories.id','=','category_post.category_id')->select('posts.id','posts.created_at','posts.views','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt','categories.name as cname', 'categories.slug as cslug','categories.color as ccolor' )
        ->orderBy('posts.id','desc')->groupBy('posts.id')->paginate(8);
        $is_favourite = true;
        return view('layouts.favourites',compact('posts','is_favourite'));
    }

    private function getRelated(Post $post){
        $oldPosts = $GLOBALS['posts'];
        
        
    	$categories = $post->categories()->pluck('id')->toArray();        
        $posts  = DB::table('posts_images as posts')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('posts.status', 1)->
        join('category_post','category_post.post_id','=','posts.id')
        ->join('categories','categories.id','=','category_post.category_id')
        ->whereNotIn('posts.id', $oldPosts )
        ->whereIn('categories.id', $categories)->select('posts.id','posts.created_at','posts.views','posts.slug','posts.title','posts.Murl','posts.Malt','posts.excerpt','categories.name as cname', 'categories.slug as cslug','categories.color as ccolor' )
        ->limit(3)->orderBy('id','desc')->groupBy('posts.id')->get();
        
    	$GLOBALS['posts'] = array_merge($GLOBALS['posts'], $posts->pluck('id')->toArray());

return $posts;        
        
    	$posts = Posts_image::where('created_at','<=',  \Carbon\Carbon::now() )->whereHas('categories', function($query) use ($categories){
    		$query->whereIn('id', $categories);
    	})->where('id', '!=', $post->id)->whereNotIn('id', $GLOBALS['posts'])->latest()->limit(6)->get();
    	$GLOBALS['posts'] = array_merge($GLOBALS['posts'], $posts->pluck('id')->toArray());
    	return $posts;
    	
    }

    public function TableOfContents($html)
	{
 
        $html = str_get_html($html);
        $headings = $html->find('h2');
        $toc = '';
        $style = '';
        foreach( $headings as $key=>$h ){
            $txt = $h->plaintext;
            $txt = trim($txt);
            if( empty($txt) ) continue;

            $toc .= "<li class='tokky$key'><a href='#toc$key'>$txt</a></li>";
            $h->setAttribute('id', "toc$key");
            $tag = $h->nodeName();
            $tag = str_replace('h', '', $tag);
            $tag = (int) $tag;
            $tag = $tag * $tag * $tag;
            $style .= ".tokky$key { margin-right:  ".$tag."px }";
        }
        
        $amp = ( isset($_GET['amp']) || ( isset($ampoo) && $ampoo == 'amp' ) );

        if( count($headings) > 5 && !$amp ){
            $toccc ="<a class='toggyBtn' onclick='toggleToc();'>المزيد</a>";
        }else{
            $toccc = '';
        }

        $toc ="<div class='toc '><p> المحتويات  </p><ul class='hiddy'> $toc </ul> $toccc </div>";
        
        $html = (string) $html;
        // $style = "<style>$style</style>";
        $html = $toc.$html;
         
        return $html;
        }

        public function autoLink($html,$postKw){
        
            $class = Auth::check() ? "class='highlight'" : '';
            $keywords = \Cache::remember('Keywords_'.\APP::getLocale(), 24*60, function(){

            $keywords = Post::select('slug','focuskw as kw')->whereIn('posts.type',['post','video'])->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('updated_at','>','2018-11-01 00:00:00')->where('posts.lang', \App::getLocale() )->where('status',1)->whereNotNull('focuskw')->get();

            

            return $keywords;
            });

            
            $out = [];
            $tmp = [];
            $nk = [];
            foreach( $keywords as $kw ){    
                if( $kw->kw == $postKw || isset($tmp[$kw->kw]) || str_replace('-',' ', urldecode($kw->slug)) != $kw->kw ) continue;

                
                $tmp[$kw->kw] = 1;
                
                $len = strlen($kw->kw);
                $nk[ $len ][] = [ 'len'=>$len, 'kw'=>urldecode($kw->kw), 'slug'=>urldecode($kw->slug)];
            }
            $html = preg_replace("/\s|&nbsp;/",' ',$html);
            $html = html_entity_decode($html);
            krsort($nk);            
            $replacements = [];
            foreach( $nk as $key=>$n ){

                foreach( $n as $keyy=>$single ){
                    
                    $kw = $single['kw'];
                    $slug = $single['slug'];
                    
                    if( strpos($html, $kw) === false &&  strpos($html, ">$kw<") === false ) continue; 

                    $kw = trim($kw);
                    $rand = $this->generateRandomString(5);
                    $id = '_'.$key.$keyy.'_'.$rand;

                    if( strpos($html, ">$kw<") !== false && strpos($html, ">$kw</a>" != strpos($html, ">$kw<") ) ){
                        $rand = $this->generateRandomString(5);
                        $id = '<span id="_'.$key.$keyy.'_'.$rand.'"></span>';
                        $html = preg_replace("/>$kw</",$id, $html,1);
                        $replacements[$id] = "><a $class href='".url($slug)."'>".$kw."</a><";
                    }

                    if( strpos($html, " $kw ") !== false ){
                        $rand = $this->generateRandomString(5);
                        $id = '<span id="_'.$key.$keyy.'_'.$rand.'"></span>';
                        $html = preg_replace("/(\s)$kw(\s)/",$id, $html,1);
                        $replacements[$id] = " <a $class href='".url($slug)."'>".$kw."</a> ";
                    }

                    
                }

            }

            foreach( $replacements as $id=>$rep ){

                $badParrent = $this->getNodeParents($html, $id);
                if( $badParrent ){
                    $rep = strip_tags($rep);
                    $html = str_replace($id,$rep, $html);
                }else{

                    $html = str_replace($id,"$rep", $html);
                }
            }

            return $html;
        }

        private function getNodeParents($html, $id){
            $badParents = ['a','h1','h2','h3','h4','h5','h6'];
            preg_match('/<span id="(.*)"><\/span>/', $id, $id);
            if( !isset($id[1]) || !$id[1] ){
                return false;
            }
            $id = $id[1];
            $html = str_get_html($html);
            $parent = $html->find('span[id="'.$id.'"]');
            if( !$parent ) return false;
            $parent = $parent[0];
     
            $found = false;
            while( $parent->parent() ){
                $parent = $parent->parent();
                if( in_array($parent->tag, $badParents) ){
                    $found = true;
                    break;
                }
            }
            return $found;
        }

        public function increasePostsRateWeekly(){

            if( !isset($_GET['yeaaaaado']) && $_GET['yeaaaaado'] == 'yeaaaaa147' ){
                return 0;
            }
            set_time_limit(3600);
            ini_set('max_execution_time', 3600);

            $posts = Post::select('posts.id as id', DB::raw('count(rates.id) as count') )->whereIn('posts.type',['post','video'])->where('posts.status', 1)->leftJoin('rates','rates.post_id','=','posts.id')->where('rates.id', null)->groupBy('posts.id')->get(); 
            if( count($posts) <= 0  ){
                return abort(404);
            }
            $query = '';
            foreach( $posts as $post ){
                
                $count = $post->count;
                if( $count > 10 ){
                    continue;
                }
                $id = $post->id;
                switch( true ){
                    case $count == 0 || $count < 15:
                        foreach( range(0, rand(15, 30) ) as $n ){
                            $rate = rand(3,5);
                            $rate = $rate >= 5 ? $rate : $rate.'.'.rand(5,9);
                            $query .= "(630,$id,$rate),,,";
                        }
                    break;
                    case $count <= 100 :
                        foreach( range(0, rand(1, 3) ) as $n ){
                            $rate = rand(3,5);
                            $rate = $rate >= 5 ? $rate : $rate.'.'.rand(5,9);
                            $query .= "(630,$id,$rate),,,";
                        }
                    break;
                    default:
                        $rate = rand(3,5);
                        $rate = $rate >= 5 ? $rate : $rate.'.'.rand(5,9);
                        $query .= "(630,$id,$rate),,,";
                    break;
                }
            }
            $query = rtrim($query, ',,,' );
            $query = explode(',,,', $query);

            $chunks = array_chunk($query, 100);
            
            foreach( $chunks as $chunk ){
                $q = implode(',', $chunk);
                $q = "insert into `rates` (user_id,post_id,rate) values ".$q;
                DB::statement($q);
                $q = '';
                sleep(2);
            }

        }

        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }



        
        public function checkPostsFUPdates($post, $all = false){
           
            $update = \App\PostUpdate::where('post_id', $post->id)->where('date','<=', \Carbon\Carbon::now() )->orderBy('date','desc')->first();
            if( $all ){
                return $update;
            }
            return $update ? $update->content : $post->content;
        }






    private function ArabicDate($your_date) {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");

        $en_month = date("M", strtotime($your_date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) { $ar_month = $ar; }
        }

        $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
        $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date("D", strtotime($your_date));
        $ar_day = str_replace($find, $replace, $ar_day_format);
    
        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0","1","2","3","4","5","6","7","8","9");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
        $current_date = $ar_day.' '.date('d').'  '.$ar_month.'  '.date('Y');
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);
    
        if( \App::isLocale('en') ){
            return date('D d M Y');
        }

        return $arabic_date;
    }
}

    //  ->havingRaw('count(rates.id) < 18')
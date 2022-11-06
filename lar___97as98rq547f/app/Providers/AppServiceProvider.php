<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App;
use Setting;
use App\post;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // $exitCode = \Artisan::call('cache:clear');


        $slocale = \App::isLocale('en') ? 'en_' : '';
        View::share('slocale', $slocale );
        
        $session_id = \Session::getId();
  
       
        Schema::defaultStringLength(191);
        Blade::directive('can', function($args){
            $args = explode(',', $args);
            return '<?php if(Auth::check() && Auth::user()->hasPermission(' . $args[0] . ',' . $args[1] . ')): ?>';
        });
        Blade::directive('endcan', function(){
            return '<?php endif; ?>';
        });
        
       View::composer('AMP.parts.header', function($view){
        $menuID = App::isLocale('ar') ? 7 : 9;
        $menu = app('App\Http\Controllers\Admin\AMP_MenuController')->preview($menuID,'class="sidebar menu"',true);
        $view->with(['menupreview'=>$menu, 'MainSchema'=> $this->MainSchema() ]);
   });

        View::composer('layouts.parts.head', function($view){
         
            $BlockAdsenseAdsPosts = setting('BlockAdsenseAdsPosts');
            $BlockAdsenseAdsPosts = explode(',', $BlockAdsenseAdsPosts);
            $BlockAdsenseAdsPosts = array_map('trim', $BlockAdsenseAdsPosts);
            
            $BlockAdsenseAdsPostsKewords = setting('BlockAdsenseAdsPostsKewords');
            $BlockAdsenseAdsPostsKewords = explode(',', $BlockAdsenseAdsPostsKewords);
            $BlockAdsenseAdsPostsKewords = array_map('trim', $BlockAdsenseAdsPostsKewords);
            

            $view->with(['BlockAdsenseAdsPosts'=>$BlockAdsenseAdsPosts, 'BlockAdsenseAdsPostsKewords'=> $BlockAdsenseAdsPostsKewords]);
       });
       
       
       
       $GLOBALS['posts'] = [];
       View::composer(['layouts.parts.footer','AMP.parts.footer'], function($view){
        
            $recentPosts = app('App\Base')->GetRecent();
            if( \App::isLocale('ar') ){
                $pages = [
                        'من-نحن' => 'من نحن',
                        'اتصل-بنا' => 'اتصل بنا',
                        'اشتركي-معنا' => 'شاركي معنا',
                        'أعلن-معنا' => 'اعلن معنا',
                        'سياسة-الخصوصية' => 'سياسة الخصوصية',
                    ];
            }else{
                $pages = [];
            }
            
            $topCats = \App\Category::select('name','slug')->where('lang', \App::getLocale() )->whereNull('parent_id')->where('id','!=',1)->inRandomOrder()->limit(5)->get();
            
            
            $view->with(['recentPosts'=>$recentPosts, 'pages' => $pages, 'topCats' => $topCats ]);

       });

       View::composer('layouts.parts.navtop', function($view){

        $menuID = App::isLocale('ar') ? 7 : 9;
        $menu = app('App\Http\Controllers\Admin\MenuController')->preview($menuID,'class="site-menu" id="site-menu" ',true);
        $view->with(['menupreview'=>$menu, 'MainSchema'=> $this->MainSchema() ]);
        
        $seen = $pop = \session('pop');
        if( $seen ){
            $seen = $seen == 2 ? 'end' : 'second';
            \session( ['pop' => 2 ] );
        }else{
            $seen = 'first';
            \session( ['pop' => 1 ] );
        }

         $seen = $seen == 2 ? 'end' : $seen;


        $socials = Setting('social_links');
       
        $socials = json_decode($socials);
        $TodayDate = $this->ArabicDate();
        

        $view->with(['socials'=>$socials,'TodayDate'=>$TodayDate, 'pop'=>$seen, 'menupreview'=>$menu, 'MainSchema'=> $this->MainSchema() ]);

   });


   View::composer(['layouts.parts.footer','AMP.parts.footer'], function($view){

    $socials = Setting('social_links');
    $socials = json_decode($socials);

    $view->with(['socials'=>$socials]);

});


       @define('website_name','Foodo');
       
    }

    function ArabicDate() {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        $your_date = date('y-m-d'); // The Current Date
        $en_month = date("M", strtotime($your_date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) { $ar_month = $ar; }
        }

        $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
        $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date('D'); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);
    
        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0","1","2","3","4","5","6","7","8","9");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
        $current_date = $ar_day.' '.date('d').'  '.$ar_month.'  '.date('Y');
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);
    
        if( App::isLocale('en') ){
            return date('D d M Y');
        }

        return $arabic_date;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('uperm', function(){
            return new App\Modules\UPerm\UPerm;
        });
        $this->app->bind('SEOAgent', function(){
            return new App\Modules\SEOAgent\SEOAgent;
        });
        $this->app->bind('mobile', function(){
            return new App\Modules\Mobile\Mobile;
        });
        $this->app->bind('ads', function(){
            return new App\Modules\Ads\Ads;
        });
    }

    public function MainSchema(){


        $website =  array(
            '@context'       => 'http://schema.org',
            '@type'          => 'WebSite', 
            "@id"            => '#website',
            "url"            => url('/'),
            "name"           => \App::isLocale('ar') ? 'www.setaat.com' : 'en.setaat.com',
            "alternateName"  => setting('title'),
            "potentialAction"=> array(
                                    "@type"=>"SearchAction", "target"=>url('/search?q={search_term_string}'), "query-input"=>"required name=search_term_string"
                                )
           );
           $website = "<script type='application/ld+json'>".json_encode($website)."</script>";

           /*
// <script type='application/ld+json'>{"@context":"http:\/\/schema.org","@type":"Organization","url":"https:\/\/www.setaat.com\/","sameAs":["https:\/\/www.facebook.com\/Setaatcom","https:\/\/www.instagram.com\/Setaatcom\/"],"@id":"#organization","name":"\u064dSetat.com","logo":"http:\/\/www.setaat.com\/wp-content\/uploads\/2017\/12\/setaat2-01-23333.png"}</script>
*/
        $organization =  array(
            '@context'       => 'http://schema.org',
            '@type'          => 'Organization', 
            "@id"            => '#organization',
            "url"            => url('/'),
            "name"           => \App::isLocale('ar') ? 'www.setaat.com' : 'en.setaat.com',
            "logo"           => asset('images/logo.jpg')
            
           );
           
           $socials = Setting('social_links');
           $socials = json_decode($socials);
           foreach( $socials as $sc ){
               if( !$sc || $sc == null ) continue;
               
               $organization['sameAs'][] = $sc;
            }
            
            $organization = "<script type='application/ld+json'>".json_encode($organization)."</script>";
       return  $website.$organization;
    }
}

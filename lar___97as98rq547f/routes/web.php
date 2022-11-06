<?php



//sitemap
Route::get('/sitemap/posts_page' , 'SitemapController@posts');
Route::get('/sitemap/posts' , 'SitemapController@posts_page');

Route::get('/sitemap/categories_page' , 'SitemapController@categories');
Route::get('/sitemap/categories' , 'SitemapController@categories_page');

Route::get('/sitemap/pages' , 'SitemapController@pages');


Route::get('/register', function(){
    if( \Auth::check() ){
        return redirect( url('/') );
    }
    return View('layouts.register');
});




// Route::get('FixpostSEO', 'PostController@fixSEO');

Route::Get('CustomT4Vhv]JUtz)RateInc457441244', 'PostController@increasePostsRateWeekly');

Route::get('/post-edit/{id}', 'PostController@postEdit');

Route::get('/bmi-calculator', function(){
    return  \View::make('layouts.forms.BMI');
});

Route::get('/loadFromCategory/{id}', 'CategoryController@loadFromCategory');
Route::post('/Send_reservation', function(){
   

   if( !isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['date']) ){
       return json_encode( ['status'=>false, 'msg'=>'يرجى إكمال الحقول الفارغة']);
   }

   $name = trim($_POST['name']);
   $phone = trim($_POST['phone']);
   $date = trim($_POST['date']);
   $note = trim(@$_POST['note']);
   
   $send = "Name: $name \n Phone: $phone \n Date: $date \n Notes: $note \n ------------------------------------ \n ";
   file_put_contents('Secret-link-TPSCR78944-Skin-Avenue.txt', $send, FILE_APPEND );
   
   $headers = "Content-Type: text/html; charset=UTF-8";


   if( mail("info@godigitaleg.com","New Patient: $name ",$send, $headers) ){
       return json_encode( ['status'=>true, 'msg'=>'تم الإرسال بنجاح ، هذا التسجيل سيتم تأكيده من خلال الإتصال بكم في أقرب وقت ممكن.']);
       }else{
    return json_decode(['status'=>false, 'msg'=>'عذراً ، حدث خطأ ما ، يرجى المحاولة في وقت لاحق.']);   }

    
});

Route::get('/اشتركي-معنا', 'JoinUsController@join');
Route::post('/joinUs', 'JoinUsController@post');;

Route::get('/اتصل-بنا', 'FormController@contactGet');
Route::get('/أعلن-معنا', 'FormController@advertiseGet');
Route::post('/contactForm', 'FormController@sendForm');


Route::get('user-moreInfo', 'UserController@lessInfo');
Route::post('user-moreInfo', 'UserController@moreInfo');

Route::get('رسالتك-من-ستات', 'ResalaController@index');
Route::get('رسالتك-من-ستات/{id}', 'ResalaController@index');
Route::post('resalaComments', 'ResalaController@getComments');


Route::get('getCaptchaIMg/', 'CaptchaController@getMyImage'); 

Route::get('/competition/{slug}', 'CompetitionController@index');

Route::get('/competition/{slug}/subscribe', 'CompetitionController@subscribe');
Route::post('/competition/{slug}/subscribe', 'CompetitionController@upload');
Route::post('/competition/rate', 'CompetitionController@RateIt');
Route::post('/competitionCommnet', 'CompetitionController@competitionCommnet');
Route::post('/removeCompetitionComment', 'CompetitionController@removeCompetitionComment');
Route::get('/competition/{slug}/{user}', 'CompetitionController@competitionUser');


Route::get('/competition/{slug}/upload', 'CompetitionController@upload');

Route::get('getCountries', 'CompetitionController@getCountries');
Route::get('getRegions/{country}', 'CompetitionController@getRegions');
Route::get('getCity/{region}', 'CompetitionController@getCity');


Route::get('/{slug}/feed', function($slug){ return Redirect::to( $slug , 301);  });
Route::get('/{slug}/feed/atom', function($slug){ return Redirect::to( $slug , 301);  });
 Route::get('/tag/{slug}/feed', 'PostController@checkURL');

Route::get('/tag/{slug}/page/{page}', function($slug, $page){
    return redirect('/tag/'.$slug);
});

Route::get('/{slug}/page/{number}', function($slug, $number){
    return Redirect::to( $slug.'?page='.$number , 301); 
});

Route::get('/search/{slug}/page/{page}', function($slug, $page){
    return Redirect::to('search?q='.$slug, 301); 
});


Route::get(config('media.routes.base'), 'MediaController@ajax');
Route::get(config('media.routes.get'), 'MediaController@get');



// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::post('ResetPass', 'Auth\ResetPassController@reset');

// Registration Routes...
Route::get('admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('admin/register', 'Auth\RegisterController@register');

Route::post('removeComment', 'CommentController@removeComment');

Route::get('/ستات-كوم-اول-شبكة-نسائية-عربية-متكاملة', 'CategoryController@fetchAll');
Route::get('/ستات-كوم-اول-شبكة-نسائية-عربية-متكاملة/page/{page?}', function($page){
    return Redirect::to('/ستات-كوم-اول-شبكة-نسائية-عربية-متكاملة/?page='.$page, 301); 
});


Route::get('{id}', 'PostController@postByID')->where('id', '[0-9]+');




// Route::get('/generateThumbs', 'GenerateController@index');


Route::get('/category/{slug}' , 'PostController@checkURL');

		
Route::group(['namespace' => 'App\Modules\Sidebar\Http\Controllers', 'middleware' => 'cors'], function(){
    Route::get(config('sidebar.editor.routes.sidebar.get'), 'SidebarController@get');
    Route::post(config('sidebar.editor.routes.sidebar.store'), 'SidebarController@store');
    Route::put(config('sidebar.editor.routes.sidebar.put'), 'SidebarController@put');
    Route::post(config('sidebar.editor.routes.widget.store'),  'WidgetController@store');
    Route::put(config('sidebar.editor.routes.widget.update'), 'WidgetController@update');
    Route::delete(config('sidebar.editor.routes.widget.delete'), 'WidgetController@destroy');
    Route::post(config('sidebar.editor.routes.location'), 'SidebarController@AddLocation');
});

// Route::get('/', ['middleware' => 'Cacher', 'uses' => 'HomeController@index'])->name('home');

// Route::get('/', 'HomeController@index' )->name('home')->middleware('Cacher'); 
Route::get('/', 'HomeController@index' )->name('home');



Route::middleware('auth')->group(function(){
	Route::get('categories', 'CategoryController@get');
});
Route::post('user/login/','Auth\LoginController@post_login');
Route::post('user/register/new','Auth\RegisterController@post_register');
Route::post('user/passwordReset','Auth\ResetPasswordController@passwordToReset');



Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');


Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/favourite/','PostController@favourite');

Route::get('/sitemap' , 'SitemapController@index');

Route::post('/post_commnet' ,'CommentController@store');
Route::post('/rate/post' ,'RateController@store');
Route::post('/like/unlike/post' ,'LikeController@store');
Route::post('/fav/unfav/post' ,'FavouriteController@store');
Route::get('/tag/{slug}' , 'TagController@index');
Route::get('/search' , 'SearchController@search');


// Route::get('/{slug}', ['middleware' => 'Cacher', 'uses' => 'PostController@index']);

 Route::get('/{slug}', 'PostController@index'); 
 Route::get('{slug}/{ampoo}', 'PostController@index'); 



// Route::get('/sitemap/tags_page' , 'SitemapController@tags');
// Route::get('/sitemap/tags' , 'SitemapController@tags_page');



Route::get('/page/{slugNum}', 'CategoryController@allPosts')->where('slugNum', '[0-9]+');

Route::get('/page/{slug}', 'PostController@checkURL');


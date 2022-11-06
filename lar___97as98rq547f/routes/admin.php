<?php

use Illuminate\Http\Request;


Route::group(['middleware' => 'IsAdmin','namespace' => 'Admin'], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });


    Route::get('asdfqwer', function(){
        dd('asd');
    });



    Route::get('/recipes_types/{type}', 'Recipes_typesController@index' );
    Route::get('/recipes_types/{type}/create', 'Recipes_typesController@create' );
    Route::post('/recipes_types/{type}', 'Recipes_typesController@store' );
    Route::get('/recipes_types/{type}/{id}/edit', 'Recipes_typesController@edit' ); 
    Route::put('/recipes_types/{type}/{id}/', 'Recipes_typesController@update' );
    Route::delete('/recipes_types/{type}/{id}/', 'Recipes_typesController@destroy' ); 
 
 
    Route::post('/ajaxPosts', function(Request $request){ 
        if( !$request->ajax() || !$request->query ) return abort(404);

        $text = trim($request->text); 

        $posts = \App\Post::leftJoin('recipes','recipes.post_id','=','posts.id')->select("title","slug","posts.id")->where('status',1)->whereIn('type',['post','video'])
        ->where( function($q) use ($text){
            $q->where("title","like","%$text%")->orWhere("focuskw","like","%$text%")->orWhere("excerpt","like","%$text%");
        })->limit(35)->get();
        

        return $posts;
    });


    Route::get('/redirection', 'RedirectionController@index');
    Route::post('/redirection', 'RedirectionController@addRedirection');
    Route::post('/redirection/{id}/delete', 'RedirectionController@removeRedirection');

    Route::get('/users-words-length', 'PostController@UsersWordsLength');

    Route::post('/clear-cache', function() {
        if( \UPerm::ClearCache() ){
            $shortcodes = \Config::get('app.SetaatshortCodes');
            
            $shortsCodes = [];
            foreach( $shortcodes as $ashortCode ){
                $shortsCodes[$ashortCode]['value'] = \Cache::get('shortCodeCache__'.$ashortCode.'__'.\App::getLocale());
            }


            $exitCode = Artisan::call('cache:clear');
            foreach( $shortsCodes as $type=>$ashortsCodee ){
                \Cache::remember('shortCodeCache__'.$type.'__'.\App::getLocale(), 60, function() use ($ashortsCodee) {
                    return $ashortsCodee['value'];
                });
            }

            $status = true;
        }else{
            $status = false;
        }
        $color = $status ? 'green' : 'red';
        $status = $status ? 'Cleared Successfully' : 'Failed';
        return "<span style='color:$color'>$status</span>";
    });

    
    Route::post('/clear-gold-cache', function() {
        if( \UPerm::ClearCache() ){
            $shortcodes = \Config::get('app.SetaatshortCodes');
            
            $shortsCodes = [];
            foreach( $shortcodes as $ashortCode ){
                \Cache::forget('shortCodeCache__'.$ashortCode.'__'.\App::getLocale());
            }
            $status = true;
        }else{
            $status = false;
        }
        $color = $status ? 'green' : 'red';
        $status = $status ? 'Cleared Successfully' : 'Failed';
        return "<span style='color:$color'>$status</span>";

    });


    Route::post('/keywords/BulkAction', 'KeywordsController@BulkAction')->name('keywordsBulkAction');
    Route::get('/keywords/search', 'KeywordsController@index')->name('KeywordSearch');
    Route::post('/keywords/GetPost', 'KeywordsController@GetPost');
    Route::resource('/keywords', 'KeywordsController');

    Route::post('/search-posts-tinymce', 'PostController@search4tinymce');
    Route::get('/manage-ads', 'AdsController@ManageAds');
    
    Route::get('/future-updates', 'PostFUpdatesController@getAllFupdates');

    
    Route::get('/future-updates/{id}/new', 'PostFUpdatesController@addUpdate');
    Route::get('/future-updates/{id}/edit', 'PostFUpdatesController@editUpdate');
    Route::post('/future-updates/{id}/edit', 'PostFUpdatesController@SaveEditUpdate');
    Route::post('/future-updates/{id}/new', 'PostFUpdatesController@saveUpdates');
    Route::get('/future-updates/{id}', 'PostFUpdatesController@getUpdates');
    Route::post('/future-updates/{id}/delete', 'PostFUpdatesController@delete');
    

    Route::get('/post-all-edits/{id}', 'PostController@postIDEdits');
    Route::get('/post-edits/{id}', 'PostController@postEdits');
    Route::get('/posts-edits', 'PostController@postsEdits');

    Route::resource('joinUs', 'JoinUsController');
    Route::get('joinUs/{id}/view', 'JoinUsController@view');
    Route::post('joinUs/reject', 'JoinUsController@reject');
    Route::post('joinUs/accept', 'JoinUsController@accept');

    Route::get('/customTemplates/breastCancer', 'CustomTemplatesController@BreastCancer');
    Route::post('/customTemplates/breastCancer', 'CustomTemplatesController@SaveBreastCancer');


    Route::get('/customTemplates/Autism', 'CustomTemplatesController@Autism');
    Route::post('/customTemplates/Autism', 'CustomTemplatesController@SaveAutism');



    Route::resource('nativeAds', 'NativeAdsController');

    Route::get('ads', 'AdsController@index');
    Route::post('ads', 'AdsController@update');

    // Ads 
    Route::get('siteAds/{page}/{device}', 'AdsController@getAds');
    Route::post('siteAds/{page}/{device}', 'AdsController@putAds');

    
    
    Route::post('competition-toggleSub', 'CompetitionController@toggleSub');
    Route::get('competitions-sub', 'CompetitionController@hello');
    Route::resource('competitions', 'CompetitionController');
    Route::resource('resala', 'ResalaController');


    Route::get('comments', 'CommentsController@index');
    Route::post('comments', 'CommentsController@update');
    Route::delete('comments', 'CommentsController@destroy');


    Route::get('social', 'SocialController@index');
    Route::post('social', 'SocialController@update');

		//Route::get(config('media.routes.base'), 'MediaController@ajax');
//		Route::put(config('media.routes.edit'), 'MediaController@update');
//		Route::post(config('media.routes.upload'),'MediaController@store');
		Route::post(config('media.routes.upload'),'MediaController@upload');
//		Route::post(config('media.routes.get'),'MediaController@ajax');
		Route::post('admin/media/ajaxSaveAlt','MediaController@ajaxSaveAlt');
		
   Route::get('categories/get', 'CategoryController@get');
   Route::get('categories/tree', 'CategoryController@tree');
   Route::resource('categories', 'CategoryController');




    
    Route::resource('/tags', 'TagController');
    Route::resource('/roles', 'RoleController');
//    Route::resource('/permissions', 'PermissionController');
    Route::get('/permissions/create', 'PermissionController@create');
    Route::get('/permissions/{role}/create', 'PermissionController@create');
    Route::post('/permissions/{role?}', 'PermissionController@store');
    Route::delete('/permissions/{role}/{permission}', 'PermissionController@destroy');
    Route::get('/permissions/{role?}', 'PermissionController@index');

    Route::get('/search-posts', 'PostController@searchQuery');

    Route::post('/posts/bulkActioin', 'PostController@bulkAction');

    Route::get('/all-posts', 'PostController@AllPosts');
    Route::resource('/posts', 'PostController');



    Route::resource('/users', 'UserController');
    Route::get('/users-outer', 'UserController@outerUsers');
    Route::get('/users/{id}/remove', 'UserController@RemoveUser');
    Route::post('/users/{id}/remove', 'UserController@RemoveUserF');

    
    Route::get('users/{id}/edit-profile', 'UserController@editProfile');
    Route::post('users/{id}/edit-profile', 'UserController@PosteditProfile');


    Route::get('/settings', 'SettingController@index');
    Route::post('/settings', 'SettingController@update');
    Route::get('/sidebar', 'SidebarController');
//        Route::post('/slider/store', 'SliderController@store');
//        Route::put('/slider/{id}/change', 'SliderController@change_status');
//        Route::delete('/slider/{id}', 'SliderController@destroy');

    // Route::resource('settings','SettingsController');
    Route::get('/menu/editRow/{id}', 'MenuController@editRow' );
    Route::post('/menu/editRow/{id}','MenuController@editsRow');
    Route::get('/menu/{id?}','MenuController@index');
    Route::post('/menu/deleteArow/{id}','MenuController@deleteArow');
    Route::get('/menu_group_add','MenuController@menu_group');
    Route::post('/menu_group_add','MenuController@menu_group');
    Route::post('/menu/add_to_menu','MenuController@add_to_menu');
    Route::post('/menu/update','MenuController@update');
    Route::get('/menu/preview/{id}','MenuController@preview');
    Route::post('/menu/preview_css/{id}','MenuController@preview_css');




});

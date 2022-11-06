@extends('layouts.master')
@section('title', $category->name)
@isset( $category->description )
@section('description', $category->description)
@endisset
@section('styles')
    <link rel="canonical" href="{{ url( $category->name ) }}"/>
@endsection
@section('meta')
<link rel="amphtml" href="{{ url( $category->slug ) }}?amp" />
<link rel="canonical" href="{{ url($category->slug) }}"/>
<meta name="og:title" content="{{ $category->name }}"/>
<meta name="og:url" content="{{ url($category->slug) }}"/>
<meta name="twitter:title" content="{{ $category->name }}"/>
@endsection
@section('content')
<!--content-->
    <section class="index-content">
     
                <section class="inner-page-banner bg-common" >
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="breadcrumbs-area">
                                        <h1>{{$category->name}}</h1>
                                        <ul itemscope itemtype="http://schema.org/BreadcrumbList">
                                            <li class="breadcrumb-item" itemprop="itemListElement" itemscope
                          itemtype="http://schema.org/ListItem"><a href="{{ url('/') }}" itemprop="item">
                           <span itemprop="name">{{ __('trans.home') }}</span>
                    </a><meta itemprop="position" content="1" /></li>
                    
                    @if($parents && $parents->count()>0)
                    @foreach($parents as $parent)
                           <li class="breadcrumb-item active"><a href="{{ url($parent->slug) }}">{{$parent->name}}</a></li>
                    @endforeach
                @endif
                    
                                            <li class="breadcrumb-item active"><a href="{{ url($category->slug) }}">{{$category->name}}</a></li>

                                            </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <br/>
                    <div class="container"> 
          
            <div class="row widget-featured-feed">
                <!-- right-side-->
                <div class="col-md-8 col-xs-12">
                {!! app('App\Http\Controllers\Admin\AdsController')->getCode(17,32)  !!}
                    <div class="beauty-box big catTPage row">
                    @if( $posts->count() > 3 )
                      
                    <div class="CategoryAdPlace">
{!! app('App\Http\Controllers\Admin\AdsController')->getCode(28,29)  !!}
</div>
                    @php $k = 0; @endphp
                    @foreach($posts as $post)
                   

                        @if( ( $k > 0 && $k%4 == 0 ) )
<div class="CategoryAdPlace">
{!! app('App\Http\Controllers\Admin\AdsController')->getCode(28,29)  !!}
</div>
                        @endif
                        @php $k++; @endphp                  
                        
                        <div class="col-md-6">
                    	@include('layouts.templates.components.post2',['post'=>$post])
                    	</div>
                    @endforeach
                    @else
                    	<div style="margin:100px;">
                    	    <p>{{ __('trans.no_posts_yet') }}</p>
                    	</div>
                    @endif
                    </div>
                    @if( !( isset($FetchAll) ) )
                        {!! $posts->render() !!}
                    @endif
                </div>
                @if( !Mobile::isMobile() )
                <!--left side -->
                 <div class="col-md-4 col-sm-12 theSidebar">
                    <div class="left-side">
                    @php $slocale = \App::isLocale('en') ? 'en_' : '' ; @endphp
                    
                  	@if(Sidebar::hasWidgets(Setting::get($slocale.'category-sidebar')))

				@foreach(Sidebar::widgets(Setting::get($slocale.'category-sidebar')) as $widget)
	                            {!!  Sidebar::render($widget) !!}
	                        @endforeach
                  	@endif
                    </div>
                </div>  
            @endif
            </div>
        </div>
    </section>
@endsection
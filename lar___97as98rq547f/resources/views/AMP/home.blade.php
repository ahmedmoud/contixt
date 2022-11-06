@extends('AMP.master')
@section('title', setting($slocale.'title')) @section('description',  setting($slocale.'description')  ) 
@section('meta')
<link rel="canonical" href="{{ url('/') }}"/>
<meta name="og:title" content="{{ setting($slocale.'title') }}"/><meta name="og:description" content=" {{ setting($slocale.'description') }}"/><meta name="og:image" content="{{ url('/images/setaat.jpg') }}"/><meta name="og:url" content="{{ url('/') }}"/><meta name="twitter:title" content="{{ setting($slocale.'title') }}"/><meta name="twitter:description" content=" {{ setting($slocale.'description') }}"/><meta name="twitter:image" content="{{ url('/images/setaat.jpg') }}"/><meta name="twitter:card" content="{{ url('/images/setaat.jpg') }}"/> 
@endsection
@section('content')

<section class="first-view clearfix"> <div class="container"> <div class="row"> @if($firstPost) <div class="col-md-6 col-lg-push-3 col-xs-12 nopadding"> <a href="{{ url('/'.$firstPost->slug) }}"> <div class="big-box"> <div class="label-cont"> <span class="fashion" style="background-color:{{ @$firstPost->ccolor }}">{{ @$firstPost->cname }}</span> </div>
@php
    list($width,$height) = getimagesize( Media::ClearifyAttach($firstPost->Murl,'medium') );
@endphp
    <amp-img width="{{ $width }}" height="{{ $height }}" alt="{{ $firstPost->title }}" src="{{ Media::ClearifyAttach($firstPost->Murl,'medium') }}" layout="responsive" ></amp-img> <div class="info"> <p class="h2">{{$firstPost->title}}</p> </div> </div> </a> </div> @endif <div class="col-md-3 col-lg-pull-6 col-sm-6 col-xs-12"> 

    @include('AMP.templates.post1',['post' =>$final[1]])
    <div style="margin:5px 0">
    {!! app('App\Http\Controllers\Admin\AdsController')->getCode(0,41)  !!}
    </div>
    @include('AMP.templates.post1',['post' =>$final[2]])
    </div> 
    @if( !\Mobile::isMobile() )
    <div class="col-md-3 col-sm-6 col-xs-12"> 
    @include('AMP.templates.post1',['post' =>$final[3]])
    @include('AMP.templates.post1',['post' =>$final[4]])
    </div>
    @endif
    </div> </div> </section> 
    
@php  
    $homeBottomBar = App::isLocale('ar') ? 'home-bottombar' : 'en_home-bottombar';
    $homeBottomBar = App::isLocale('ar') && \Mobile::isMobile() ? 'ar_home_mobile' : $homeBottomBar;
@endphp


    <section class="index-content "> <div class="container">
        <div class="row"> <!-- right-side--> <div class="no-pad-left"> <div class="right-side"> 
       
        @if( App::isLocale('ar') )
       @if(Sidebar::hasWidgets(Setting::get($homeBottomBar))) 
       
       @foreach(Sidebar::widgets(Setting::get($homeBottomBar)) as $widget) 
       @if( $widget->content->type == 'posts' ) 
       @php $theSWidgetOutput = preg_replace('#<script(.*?)>(.*?)</script>#is', '', Sidebar::render($widget) );     @endphp
       @php /* $styling .= ".__".$widget->id." { background-color: ".@$widget->content->color." !important} "; $styling .= ".___".$widget->id." { border-top-color: ".@$widget->content->color." } "; $styling .= ".___".$widget->id." a:hover{ color: ".@$widget->content->color." } "; */ @endphp 
       @endif 
       {!!  $theSWidgetOutput !!}
       @endforeach
       @endif 
       @endif
       
       </div> </div>  </div> </div> </div> </section>  

@endsection
@extends('layouts.master') 
@section('title', setting($slocale.'title')) @section('description',  setting($slocale.'description')  ) 
@section('meta')
<link rel="canonical" href="{{ url('/') }}"/>
<meta name="og:title" content="{{ setting($slocale.'title') }}"/>
<meta name="og:description" content=" {{ setting($slocale.'description') }}"/><meta name="og:image" content="{{ url('/images/setaat.jpg') }}"/>
<meta name="og:url" content="{{ url('/') }}"/><meta name="twitter:title" content="{{ setting($slocale.'title') }}"/>
<meta name="twitter:description" content=" {{ setting($slocale.'description') }}"/><meta name="twitter:image" content="{{ url('/images/setaat.jpg') }}"/>
<meta name="twitter:card" content="{{ url('/images/setaat.jpg') }}"/> @endsection @section('content')  


@php  
$homeBottomBar = App::isLocale('ar') ? 'home-bottombar' : 'en_home-bottombar';
/* $homeBottomBar = App::isLocale('ar') && \Mobile::isMobile() ? 'ar_home_mobile' : $homeBottomBar; */
@endphp
   <!--content--> <section class="index-content "> 
<div class="container">
  
<div class="row bgg">
    <div class="col-md-6">
      <div class="entry-photo">
        <div class="badge">وصفة اليوم</div>
      <img src="{{ Media::ClearifyAttach($random->Murl, 'max') }}" alt="{{ $random->title }}" />
      </div>
      
      </div>
      <div class="col-md-6">
          <h3><a href="{{ url($random->slug) }}">{{ $random->title }}</a></h3>
        <p>{!! $random->excerpt !!}</p>
        <a class="colored" href="{{ url($random->slug) }}">اقرأ المزيد</a>
        </div>
</div>
<div class="row"> <!-- right-side--> 

  @php $styling = ''; @endphp 
  @if( App::isLocale('ar') )
 @if(Sidebar::hasWidgets(Setting::get($homeBottomBar))) 
 
 @foreach(Sidebar::widgets(Setting::get($homeBottomBar)) as $widget) 
 @if( $widget->content->type == 'posts' ) 
 
 @php $styling .= ".__".$widget->id." { background-color: ".@$widget->content->color." !important} "; $styling .= ".___".$widget->id." { border-top-color: ".@$widget->content->color." } "; $styling .= ".___".$widget->id." a:hover{ color: ".@$widget->content->color." } ";  @endphp 
 @endif 
 {!!  Sidebar::render($widget) !!}
 @endforeach
 @endif
 @endif
 <style>{{ $styling }}</style> </div>
 </div>
 </div>
 </section>  @endsection
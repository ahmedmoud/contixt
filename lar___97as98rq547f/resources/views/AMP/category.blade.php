@extends('AMP.master')
@section('title', $category->name)
@isset( $category->description )
@section('description', $category->description)
@endisset
@section('meta')
    <link rel="canonical" href="{{ url($category->slug) }}"/>
    <meta name="og:title" content="{{ $category->name }}"/>
    <meta name="og:url" content="{{ url($category->slug) }}"/>
    <meta name="twitter:title" content="{{ $category->name }}"/>
@endsection
@section('content')
 
<!--content-->
<section class="index-content">
        <div class="container"> 
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">{{ __('trans.home') }}</a></li>
            @if($parents && $parents->count()>0)
            @foreach($parents as $parent)
                <li class="breadcrumb-item active"><a href="{{ url($parent->slug) }}">{{$parent->name}}</a></li>
            @endforeach
            @endif
            <li class="breadcrumb-item active"><a href="{{ url($category->slug) }}">{{$category->name}}</a></li>
        </ol>
            <div class="clearfix">
                	@foreach($posts as $key => $post)
                    <div class="content_item">   
                
                            <a href="{{url('/'.$post->slug)}}"> <div class="b-box"> @if( !isset($tag) || !$tag ) <div class="label-cont"> <span class="beauty"  style="background-color:{{ @$post->ccolor }}">{{@$post->cname}}</span> </div> @endif <div class="cat-img"> @php
                                    list($width,$height) = getimagesize( Media::ClearifyAttach($post->Murl,'medium') );
                                @endphp
                                <amp-img  layout="responsive" width="{{ $width }}" height="{{ $height }}" src="{{ asset(Media::ClearifyAttach($post->Murl, 'medium')) }}" class=" img-responsive d-block w-100" alt="{{ $post->title }}"> </div> <div class="slider-info"><h4 class="txt-center">{{ $post->title}}</h4> </div> </div> </a> 
                    </div>
                @break( $key > 1 ) 
                 @endforeach
            </div>
            <div class="row">
                <!-- right-side-->
                <div class="col-md-8 col-xs-12">
                {{-- {!! app('App\Http\Controllers\Admin\AdsController')->getCode(17,32)  !!} --}}
                    <div class="beauty-box big catTPage">
                    @if( $cats)
                        <div class="title-header catdtt">
                        <h1 class="h4">{{$category->name}}</h1>
                            @foreach($cats as $cat)
                            	<a href="{{ url($cat->slug) }}">{{ $cat->name }}</a>
                            @endforeach
                    </div>
                    @endif
                    @if( $posts->count() > 3 )
                      <div class="Catbiggy">
                        <div class="big-box">
                            <div class="label-cont">
                                <span class="fashion" style="background-color:{{ $posts[3]->ccolor }}">{{ $posts[3]->cname }}</span>
                            </div>
@php
    list($width,$height) = getimagesize( Media::ClearifyAttach($post->Murl,'medium') );
@endphp
<amp-img  layout="responsive" width="{{ $width }}" height="{{ !\Mobile::isMobile()  ? '210' : $height }}" src="{{ asset(Media::ClearifyAttach( $posts[3]->Murl, 'max')) }}" class="img-responsive">
                            <div class="info">
                                <a href="{{ url($posts[3]->slug) }}"><h4 class="txt-center">{{ $posts[3]->title}}</h4></a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="CategoryAdPlace">
{!! app('App\Http\Controllers\Admin\AdsController')->getCode(28,29)  !!}
</div> --}}
@php $k = 0; @endphp
@foreach($posts->forget([0,1,2,3]) as $post)
    @if( ( $k > 0 && $k%4 == 0 ) )
{{-- <div class="CategoryAdPlace">
{!! app('App\Http\Controllers\Admin\AdsController')->getCode(28,29)  !!}
</div> --}}
    @endif @php $k++; @endphp <div class="content_item"> <a href="{{url('/'.$post->slug)}}"> <div class="b-box"> @if( !isset($tag) || !$tag ) <div class="label-cont"> <span class="beauty" style="background-color:{{ @$post->ccolor }}">{{@$post->cname}}</span> </div> @endif <div class="cat-img"> @php list($width,$height) = getimagesize( Media::ClearifyAttach($post->Murl,'medium') ); @endphp <amp-img layout="responsive" width="{{ $width }}" height="{{ !\Mobile::isMobile() ? '210' : $height }}" src="{{ asset(Media::ClearifyAttach($post->Murl, 'medium')) }}" class=" img-responsive d-block w-100" alt="{{ $post->title }}"> </div> <div class="slider-info"><h4 class="txt-center">{{ $post->title}}</h4> </div> </div> </a> </div> @endforeach
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
            </div>
        </div>
    </section>
@endsection 

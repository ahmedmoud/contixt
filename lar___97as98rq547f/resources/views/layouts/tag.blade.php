@extends('layouts.master')
@section('title', $tag->name)
@section('description', $tag->theDesc )
@section('meta')
<link rel="canonical" href="{{ url('/tag/'.str_replace(' ','-', $tag->name)) }}"/>
@endsection
@section('content')
<!--content-->
    <section class="index-content">
        <div class="container">
            <div class="row">
                <!-- right-side-->
                <div class="col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li>
                          <li class="breadcrumb-item active"><a href="{{ url('/tag/'.str_replace(' ','-', $tag->name)) }}">{{$tag->name}}</a></li>
                        </ol>
                    <div class="beauty-box big">
                        <div class="title-header">
                        <h1 class="h4">{{$tag->name}}</h1>
                    </div>
                    @foreach($posts as $post)
                    <div class="col-md-6">
                    	@include('layouts.templates.components.post2',['post'=>$post])
                    </div>
                    @endforeach
                    </div>
{!! $posts->render() !!}
                </div>
                @if( !Mobile::isMobile() )
                <!--left side -->
                <div class="col-md-4 col-sm-12">
                    <div class="left-side">
                  	@if(Sidebar::hasWidgets(Setting::get('tag-sidebar')))
				@foreach(Sidebar::widgets(Setting::get('tag-sidebar')) as $widget)
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
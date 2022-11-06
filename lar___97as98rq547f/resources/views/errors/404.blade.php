@extends('layouts.master')
@section('content')

<div class="container">

    <img src="{{ url('uploads/assets/images/Thing.jpg') }}"  alt="404 غير موجود " class="img-responsive"/>
<br/>
    <div class=" life-box-2 clearfix  ___12"> 
@php
$randPosts = DB::table('posts_images as posts')->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.lang', \App::getLocale() )->where('status',1)->whereIn('type',['post','video'] )->limit(3)->inRandomOrder()->get();

@endphp
<div class="row">

@foreach( $randPosts as $posttt )
        <div class="col-md-4 col-xs-12 "> <a href="{{ url($posttt->slug) }}"> <div class="c-slide noeffect"> <div class="c-overlay"></div> <img src="{{ asset(Media::ClearifyAttach($posttt->Murl, 'medium')) }}" class=" img-responsive d-block w-100" alt="{{ $posttt->title }}"> <div class="c-caption VRideo"><h3>{{ $posttt->title }}</h3> </div> </div> </a> </div> 
@endforeach
</div></div>
</div>
@endsection
<div class="first-view-box"> <a href="{{ url('/'.$post->slug) }}"> <div class="box"> <div class="label-cont"> <span class="fashion"  style="background-color:{{ @$post->ccolor }}">{{ @$post->cname }}</span> </div> <div class="box-img-cont">@php
    
list($width,$height) = getimagesize( @Media::ClearifyAttach($post->Murl, 'medium' ) );

@endphp <amp-img width="{{ $width }}" height="{{ $height }}" alt="{{ $post->title }}" src="{{ @url(@Media::ClearifyAttach($post->Murl, 'medium' ) ?? '') }}" layout="responsive"  ></amp-img> </div> <p class="h4">{{ @$post->title }}</p> </div> </a> </div>
@extends('AMP.master')
@section('title', $post->title)
@section('description', $post->excerpt)
@section('meta')
<link rel="canonical" href="{{ url( $post->slug ) }}" />
<link rel="amphtml" href="{{ url( $post->slug ) }}?amp" />
<meta name="og:title" content="{{ $post->title }}"/>
<meta name="og:description" content="{{ strip_tags($post->excerpt) }}"/>
<meta name="og:image" content="{{ url(Media::ClearifyAttach($post->Murl, 'max')) }}"/>
<meta name="og:url" content="{{ url($post->slug) }}"/>
<meta name="twitter:title" content="{{ $post->title }}"/>
<meta name="twitter:description" content="{{ $post->excerpt }}"/>
<meta name="twitter:image" content="{{ url(Media::ClearifyAttach($post->Murl, 'max')) }}"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="keywords" content="{{ $post->focskw }},@foreach($tags as $tag){{ $tag->name }},@endforeach" />
@endsection
@section('content')
{!! $schema !!}
<div class="container">
<ol class="breadcrumb " itemscope itemtype="http://schema.org/BreadcrumbList">
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope
itemtype="http://schema.org/ListItem"><a href="{{ url('/') }}" itemprop="item">
<span itemprop="name">{{ __('trans.home') }}</span>
</a><meta itemprop="position" content="1" /></li>

    @foreach( $BreadCats as $key=>$bcat )
      <li class="breadcrumb-item" itemprop="itemListElement" itemscope
itemtype="http://schema.org/ListItem"><a href="{{ url($bcat->slug) }}" itemprop="item"> <span itemprop="name">{{ $bcat->name }}</span>
</a><meta itemprop="position" content="{{ ++$key }}" /></li>
    @endforeach

      <li class="breadcrumb-item active" itemprop="itemListElement" itemscope
itemtype="http://schema.org/ListItem"><a href="{{url('/'.$post->slug)}}" itemprop="item" > <span itemprop="name"> {{$post->title}}</span></a><meta itemprop="position" content="{{ ++$key }}" /></li>
    </ol>


<div class="clearfix"></div>

@if( Media::ClearifyAttach($post->Murl, 'max') )
    @php
        $fimg = Media::ClearifyAttach($post->Murl, 'max');
        list($width, $height, $type, $attr) = getimagesize($fimg);
    @endphp
<amp-img layout="responsive" width="{{ $width }}" height="{{ $height }}" src="{{ Media::ClearifyAttach($post->Murl, 'max') }}" alt="{{ $post->title }}" ></amp-img>
@endif

<h1>{{ $post->title }}</h1>
<div><b> آخر تحديث :</b> {{ $post->txt_lastUpdate }}</div> 
<p>{!! $post->content !!}</p>




<section class="comment">
        <div class="title-header">التعليقات</div>
        <form action-xhr="{{ url('/post_commnet') }}" method="POST" id="submit_form" >
            {{csrf_field()}}
            <input type="hidden" name="post_id" value="{{ $post->id }}" />
            <input required type="text" name="Cname" placeholder="الإسم" />
            <input type="text" name="Cemail" placeholder="البريد الإلكتروني" />
            <textarea required name="comment" rows="3" maxlength="300"></textarea>
            <input type="submit" value="تعليق" />
        </form>

        <div class="show_comments" itemscope itemtype="http://schema.org/UserComments" >
            @foreach($comments as $comment)
            <!-- Single Comment -->
           @include('AMP.templates.comment') 
            @endforeach
      </div>


</section>
        

@if( $related ) 
<div class="related-post">
    <div class="title-header">{{ __('trans.related_arts') }}</div>

<section>
    @foreach($related as $postt)
    <div class="content_item">
        <a href="{{ url($postt->slug) }}">
            <div class="b-img-cont">
                @php 
                    $fimg = Media::ClearifyAttach($postt->Murl, 'medium');
                    list($width, $height, $type, $attr) = getimagesize($fimg);
                @endphp
                    <amp-img width="{{ $width }}" height="{{ $height }}" src="{{ Media::ClearifyAttach($postt->Murl, 'medium') }}" layout="responsive"  alt="{{ $postt->title }}"></amp-img>
            </div>
        </a>
        <a href="{{ url($postt->slug) }}">
            <div class="slider-info">
            <p class="h4">{{ $postt->title }}</p>
        </div> 
        </a>  
    </div>
    @endforeach
</section>

</div>
@endif



</div>


<div class="social-share">
        <amp-social-share type="email"></amp-social-share>
        <amp-social-share type="facebook" data-param-app_id="621919821497099"></amp-social-share>
       
    <amp-social-share type="pinterest" data-param-media="https://amp.dev/static/samples/img/amp.jpg"></amp-social-share>
        <amp-social-share type="twitter"></amp-social-share>
        <amp-social-share type="whatsapp"></amp-social-share>
        <amp-social-share type="tumblr"></amp-social-share>
</div>




{{-- 
<amp-analytics type="googleanalytics">
    <script type="application/json">
    {
        "vars": {
        "account": "UA-29789881-18"
        },
        "triggers": {
        "default pageview": {
            "on": "visible",
            "request": "pageview",
            "vars": {
            "title": "{{ $post->title }}"
            }
        }
        }
    }
    </script>
</amp-analytics> --}}
@endsection 

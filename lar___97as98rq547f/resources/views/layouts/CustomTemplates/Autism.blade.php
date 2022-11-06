@extends('layouts.master')
@section('title', $category->name)
@section('description', $category->description)
@section('meta')
<meta name="og:title" content="{{ $category->name }}"/>
<meta name="og:description" content="{{ strip_tags($category->description) }}"/>
<meta name="og:url" content="{{ url($category->slug) }}"/>
<meta name="twitter:title" content="{{ $category->name }}"/>
<meta name="twitter:description" content="{{ $category->description }}"/>
@endsection
@section('content')
        <div class="container"> 

             <ol style="display:none" class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li>
                          @if($parents && $parents->count()>0)
                          	@foreach($parents as $parent)
                          	   	<li class="breadcrumb-item active"><a href="{{ url($parent->slug) }}">{{$parent->name}}</a></li>
                          	@endforeach
                          @endif
                          <li class="breadcrumb-item active"><a href="{{ url($category->slug) }}">{{$category->name}}</a></li>
                        </ol>
                        
@php
$posts = (array)$posts;
$posts = head($posts);
$keys = array_keys($posts);
$firstPost = $output->firstFive[0];
@endphp

<section class="first-view"> <div class=""> <div class="row"> @if($firstPost) <div class="col-md-6 col-lg-push-3 col-xs-12 nopadding"> <a href="{{ url('/'.$firstPost->slug) }}"> <div class="big-box"><img src="{{ Media::ClearifyAttach($firstPost->Murl,'max') }}" class="img-responsive"> <div class="info"> <p class="h2">{{$firstPost->title}}</p> </div> </div> </a> </div> @endif <div class="col-md-3 col-lg-pull-6 col-sm-6 col-xs-12"> 

    @include('layouts.templates.components.post3',['post' => $output->firstFive[1] ] )
    @include('layouts.templates.components.post3',['post' => $output->firstFive[2] ] )


                        </div> <div class="col-md-3 col-sm-6 col-xs-12"> 
                        
    @include('layouts.templates.components.post3',['post' => $output->firstFive[3] ] )
    @include('layouts.templates.components.post3',['post' => $output->firstFive[4] ] )
                        
                        
                        </div> </div> </div> </section> 
<style>
.owl-nav{
    display:block;
}
#ajaxContent{
    clear: both;
    float:none;
    display: block;
}
#ajaxContent img.img-responsive.d-block.w-100 {
       height: 178px;
    margin: auto;
}
section.breastCancerQuote {
    max-width: 900px;
    font-size: 20px;
    text-align: center;
    background: #ff569a;
    position: relative;
    overflow: visible;
    color: #fff;
    padding: 1px;
    border-radius: 8px;
    margin-bottom: 6px;
}
section.breastCancerQuote h1 {
display: inline-block;
font-size: 24px;
}
section.breastCancerQuote p {
    padding-top: 1px;
    font-size: 17px;
}
section.breastCancerQuote img {
    max-width: 29px;
    margin: auto;
}
.c-overlay{
    background: none;
    border: 0;
}
.owl-carousel .owl-item img {
    border-radius: 11px;
}
.owl-carousel .owl-stage-outer{
    margin-bottom: 8px;
}
</style>
{{-- 
<div class="">
    <div class="row">
    <div class="col-md-8">
<section class=" breastCancerQuote">
    <img src="https://www.setaat.com/uploads/assets/breast-cancer.png" alt="brease cancer ribbon" />
    <h1>سرطان الثدي</h1>
    <p>
            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
    </p>

</section>
    </div>

    <div class="col-md-4">
            <div class="ClearAdPlace">
                    <!-- Setaat.com recent posts 300_250 -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-2036644403902115"
                         data-ad-slot="5539850848"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    </div>
</div>

    </div>
</div> --}}


<div class="owl-carousel bCancer">
@foreach ( $output->videos as $post )
<div class=""">  <a href="{{ url( $post->slug ) }}"> <div class="c-slide noeffect"> <div class="c-overlay"></div> <img src="{{ Media::ClearifyAttach($post->Murl,'max') }}" class=" img-responsive d-block w-100"> <div class="c-caption VRideo"> <i class="fa fa-play"></i>  </div> </div> <h3 style=" font-size: 20px; text-align: center; ">{{ $post->title }}</h3></a> </div>
@endforeach
</div>

        <div>
            
<div class="col-md-4" style="padding-right:0;">  <div class="love-life life-box  ___8 FFa" >
        <div class="title-header">  
       <h4><a class="nostylea">{{ $output->secondBlock[0]['title'] }}</a></h4>
         </div> 
         <div><div class="c-slide"> <div class="c-overlay"></div> <div class="slide-img"> <img src="{{ Media::ClearifyAttach( $output->secondBlock[0]['posts'][0]->Murl ,'medium') }}" class=" img-responsive d-block w-100"> </div> <div class="c-caption"> <h3 class="text-center"><a>{{ $output->secondBlock[0]['posts'][0]->title }}</a></h3> </div> </div>   
        </div> 

       <ul class="list-ul">  
@foreach ( $output->secondBlock[0]['posts'] as $k=>$post )
@if( $k == 0 ) @continue @endif
           <li> <a href="{{ url( $post->slug ) }}"><div class="list-ul-img"> <img src="{{ Media::ClearifyAttach($post->Murl,'medium') }}"> </div> <h5>{{ $post->title }}</h5></a></li>     
       @endforeach
       </ul>
         
       </div>  </div>

       
       
<div class="col-md-4">  <div class="love-life life-box  ___8">
        <div class="title-header">  
       <h4><a class="nostylea">{{ $output->secondBlock[1]['title'] }}</a></h4>
         </div> 
       
       <ul class="list-ul">  
        @foreach ( $output->secondBlock[1]['posts'] as $k=>$post )
           <li> <a href="{{ url( $post->slug ) }}"><div class="list-ul-img"> <img src="{{ Media::ClearifyAttach($post->Murl,'medium') }}"> </div> <h5>{{ $post->title }}</h5></a></li>     
       @endforeach
       </ul>
         <div>
             <div class="c-slide">
              <div class="ClearAdPlace">
                <!-- Setaat.com recent posts 300_250 -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-2036644403902115"
                     data-ad-slot="5539850848"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                </div>
            </div>   
       </div> 
       </div>  </div>

       
       
<div class="col-md-4" style="padding-left:0;">  <div class="love-life life-box  ___8 FFa" >
        <div class="title-header">  
       <h4><a class="nostylea" href=""> {{ $output->secondBlock[2]['title'] }}</a></h4>
         </div> 
       
         <div><div class="c-slide"> <div class="c-overlay"></div> <div class="slide-img"> <img src="{{ Media::ClearifyAttach( $output->secondBlock[2]['posts'][0]->Murl ,'medium') }}" class=" img-responsive d-block w-100"> </div> <div class="c-caption"> <h3 class="text-center"><a>{{ $output->secondBlock[2]['posts'][0]->title }}</a></h3> </div> </div>   
        </div> 

       <ul class="list-ul">  
        @foreach ( $output->secondBlock[2]['posts'] as $k=>$post )
        @if( $k == 0 ) @continue @endif
                   <li> <a href="{{ url( $post->slug ) }}"><div class="list-ul-img"> <img src="{{ Media::ClearifyAttach($post->Murl,'medium') }}"> </div> <h5>{{ $post->title }}</h5></a></li>     
               @endforeach
               </ul>
   
         
       </div>  </div>
       


        </div>



        






<input type="hidden" id="ajaxInputPage" value="1" />
<div id="ajaxContent">

        @foreach ( $output->lastSix as $post )
        <div class=" col-md-4 b-box"> <a href="{{ url( $post->slug ) }}"> </a><a href="{{ url($post->slug) }}"> <div class="b-img-cont"> <img src="{{ Media::ClearifyAttach($post->Murl,'medium') }}" class=" img-responsive d-block w-100"> </div> </a> <a href="{{ url( $post->slug ) }}"><div class="slider-info"> <p class="h2">{{ $post->title }}</p> </div> </a> </div>
        @endforeach

</div>


<div class="ads _FooterAd"><!-- Setaat.com footer -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2036644403902115"
     data-ad-slot="9513812925"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>

<img id="loaderI" src="{{ url('uploads/assets/images/loader.gif') }}" />

<style>
    #loaderI {
        display: none;
        clear: both;float: none;display: block;margin: auto;text-align: center;max-width: 95px;
    }
    .c-slide.noeffect i.fa.fa-play {
        background: #ffffffe6;
        color: #45c4e9;
    }
    .c-slide.noeffect:hover i.fa.fa-play {
    color: #ffffff; background:none;
}
.FFa .c-caption {
    top: 30%;
}
.FFa .c-caption h3 {
    background: #30a45699;
    padding: 15px 9px;
    font-size: 20px;
}
</style>

        </div>
    </section>


@endsection
@section('cScripts')
    <script>
$(document).ready(function(){$(".bCancer").owlCarousel({loop:!0,margin:10,navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],nav:!0,responsiveClass:!0,autoplay:!0,autoplayTimeout:5e3,autoplayHoverPause:!0,responsive:{0:{items:1,nav:!0},600:{items:2,nav:!1},1e3:{items:3,nav:!0,loop:!1}}})});var processing=!1;function enableAjax(){$("#loaderI").hide(),setTimeout(function(){processing=!1},2e3)}window.onscroll=function(){if(!processing&&$(window).scrollTop()>=.7*($(document).height()-$(window).height())){processing=!0;var a=$("#ajaxInputPage").val();a=parseInt(a),$("#ajaxInputPage").val(1+a),$("#loaderI").show(),$.ajax({url:"{{ url('/loadFromCategory/'.$category->id) }}?page="+a,success:function(a){a&&a.data.forEach(function(a,e){$("#ajaxContent").append('<div class="col-md-4 b-box"><a href="'+a.slug+NaN+a.slug+'"><div class="b-img-cont"> <img src="'+a.Murl+'" class=" img-responsive d-block w-100"></div></a> <a href="'+a.slug+'"><div class="slider-info"><p class="h2">'+a.title+"</p> </div></a> </div>")}),enableAjax()},error:function(){console.log("error"),enableAjax()}})}};

    </script>
    <script></script>
<script>
    $(document).ready(function(){
        ga('send', 'event', 'Page', 'Views', 'Breast Cancer');
    });
    $('a').click(function(){
        ga('send', 'event', 'Page', 'Views', 'Breast Cancer');
    });
    
</script>
@endsection
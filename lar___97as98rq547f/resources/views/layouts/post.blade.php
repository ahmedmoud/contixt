@extends('layouts.master')
@section('title', $post->title)
@section('description', $post->excerpt)
@section('meta')
<link rel="canonical" href="{{ url( $post->slug ) }}"/>
<link rel="amphtml" href="{{ url( $post->slug ) }}?amp"/>
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
@if( Mobile::isMobile() )
<nav class="sMediafMobile">
<a title="{{ $post->title }}" class="fa fa-facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + '{{ url($post->slug) }}','sharer', 'width=655,height=430'); return false;"></a>
<a title="{{ $post->title }}" class="fa fa-twitter" onclick="window.open('https://twitter.com/share?url=' + '{{ url($post->slug) }}' + '&amp;text=' + document.title, 'sharer', 'width=600,height=450');"></a>
<a href="whatsapp://send?text={{ $post->title }}                     {{ url($post->slug) }}" data-action="share/whatsapp/share" title="{{ $post->title }}" target="_blank" class="fa fa-whatsapp"></a>
<a title="{{ $post->title }}" class="icon-msngr" onclick="window.open('http://www.facebook.com/dialog/send?app_id=5483364177&amp;link='+'{{ url($post->slug) }}'+'&amp;redirect_uri={{ url($post->slug) }}, 'sharer', 'width=655,height=430'); return false;"></a>
<a href="fb-messenger://share/?link={{ url($post->slug) }}" title="{{ $post->title }}" class="fa fa-facebook-messenger"></a>
<a onclick="window.print();" class="icon-print"></a>
</nav>
@endif
{!! $schema !!}
	<?PHP /* ?>
	@includeWhen( !Mobile::isMobile() && $latests->count(), 'layouts.templates.post-carousel',['latests'=>$latests])
	<?PHP */ ?>
<!--content--> 
    <section class="index-content">
<section class="inner-page-banner bg-common" >
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumbs-area">
                    <h1>{{ $post->title }}</h1>
                    <ul itemscope itemtype="http://schema.org/BreadcrumbList">
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
      itemtype="http://schema.org/ListItem"><a href="{{url('/'.$post->slug)}}" itemprop="item" > <span itemprop="name"> {{$post->title}}</span></a><meta itemprop="position" content="{{ ++$key }}" /</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="single-recipe-wrap-layout1 padding-top-74 padding-bottom-50">
        <div class="container">
            <div class="row gutters-60">
                <div class="col-lg-8">
                    <div class="single-recipe-layout1">
                        <div class="ctg-name">{{ $postCats[0]->name }}</div>
                        <h2 class="item-title">{{ $post->title }}</h2>
                        <div class="row mb-4">
                            <div class="col-xl-9 col-12">
                                <ul class="entry-meta">
                                    <li class="single-meta">
                                        <ul class="item-rating">
                                            <li class="star-fill"><i class="fas fa-star"></i></li>
                                            <li class="star-fill"><i class="fas fa-star"></i></li>
                                            <li class="star-fill"><i class="fas fa-star"></i></li>
                                            <li class="star-fill"><i class="fas fa-star"></i></li>
                                            <li class="star-empty"><i class="fas fa-star"></i></li>
                                            <li><span>9<span> / 10</span></span> </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-3 col-12">
                                <ul class="action-item">
                                    <li><button><i class="fas fa-print"></i></button></li>
                                    <li><button><i class="fas fa-expand-arrows-alt"></i></button></li>
                                    <li class="action-share-hover"><button><i class="fas fa-share-alt"></i></button>
                                        <div class="action-share-wrap">
                                            <a href="#" title="facebook"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#" title="twitter"><i class="fab fa-twitter"></i></a>
                                            <a href="#" title="linkedin"><i class="fab fa-linkedin-in"></i></a>
                                            <a href="#" title="pinterest"><i class="fab fa-pinterest-p"></i></a>
                                            <a href="#" title="skype"><i class="fab fa-skype"></i></a>
                                            <a href="#" title="rss"><i class="fas fa-rss"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item-figure">
                                @if( $post->recipe && $post->recipe->videoURL && strpos($post->recipe->videoURL, "youtube") !== false )
                                <?PHP
                                    
                                    $videoURL = $post->recipe->videoURL;
                                    $videoURL = trim($videoURL);
                                    $videoURL = explode("watch?v=", $videoURL);
                                    $videoURL = trim(end($videoURL));
                                    $videoURL = explode("embed/", $videoURL);
                                    $videoURL = trim(end($videoURL));
        
                                ?>
                                <div class='embed-container'>
                                <iframe src="https://www.youtube.com/embed/{{ $videoURL }}" allowfullscreen frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                                @else
                                     <img src="{{ Media::ClearifyAttach($post->Murl, 'max') }}" class="img-responsive" alt="{{ $post->title }}">
                                @endif
                        </div>
                        <div>
                            {!! $post->content !!}
                        </div>
                      
                       
                        <div class="tag-share">
                            <ul>
                                <li>
                                    <ul class="inner-tag">
                                            @if( 0 && $tags->count() )
                                            <div class="tags">
                                            <i class="fa fa-tags"></i>
                                            @foreach($tags as $tag)
                                            @if( empty(trim($tag->name)) ) 
                                                @continue 
                                            @endif
                                            <li><a class="color-white" href="{{url('/tag/'.str_replace(' ','-', $tag->name) )}}">{{$tag->name}}</a></li>
                                            @endforeach
                                            </div>
                                            @endif                   
                                    </ul>
                                </li>
                                <li>
                                    <ul class="inner-share">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-pinterest"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        @if( $related ) 
                        <div class="also-like-wrap">
                            <div class="title-header">
                                <h4 class="also-like-title">{{ __('trans.related_arts') }}</h4>
                            </div>
                           
                            <div class="">
                                <div class="row">
                                   
                                    @foreach($related as $postt)
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                            
                                            <div class="product-box-layout2">
                                                    <a href="{{ url('/'. $postt->cslug) }}">
                                                <figure class="item-figure"><img src="{{ Media::ClearifyAttach($postt->Murl, 'medium') }}"
                                                    alt="{{ $postt->title }}" ></figure>
                                                </a>
                                                <div class="item-content">
                                                    <h3 class="item-title"><a href="{{ url($postt->slug) }}">{{ $postt->title }}</a></h3>
                                                   
                                                </div>
                                            </div>
                                     
                                        </div>
                                   
                                    @endforeach
                                </div>
                            </div>
                            </div>
                           
                     @endif

                      
                        
                        
                    </div>
                </div>
                @if( !Mobile::isMobile() )
                    <div class="col-lg-4 sidebar-widget-area sidebar-break-md theSidebar">
                        <!--left side -->
                                    <div class="left-side theiaStickySidebar">
                                    @php $slocale = \App::isLocale('en') ? 'en_' : '' ; @endphp
                                    @if(Sidebar::hasWidgets(Setting::get($slocale.'post-sidebar')))
                                    @foreach(Sidebar::widgets(Setting::get($slocale.'post-sidebar')) as $widget)
                                                {!!  Sidebar::render($widget) !!}
                                            @endforeach
                                    @endif
                                    </div>
                                </div>  
                        @endif
            </div>
        </div>
    </section>

</section>
@endsection

@section('cScripts')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function updateURLParameter(url, param, paramVal){
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (var i=0; i<tempArray.length; i++){
            if(tempArray[i].split('=')[0] != param){
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

$(document).ready(function(){ 
/*
    $('.post').find('iframe[src*="youtube.com"]').each(function(){

    var src = $(this).attr('src');
    src = updateURLParameter(src, 'autoplay', '1');
    $(this).attr('src', src);

    });
*/
});
$('.removeComment').click(function(){
    $confirm = confirm('هل متأكدة من حذف هذا التعليق؟!');
    if( !$confirm ) return false;
var parent = $(this).parent();
    var CommentID = $(this).attr('CommentID');
    var output = '';
    $.ajax({
        url: '{{  url("/removeComment") }}',
        type: 'POST',
        data: { 'CommentID': CommentID },
        success:function(data){
            if( data.status == true ){
                output = "تم الحذف بنجاح";
                parent.html('<p>'+output+'<p>');
            }else{
            output = "حدث خطأ ما ، يرجى المحاولة لاحقاً";
             parent.append('<p>'+output+'<p>');
            }
        },
        error:function(){
            output = "حدث خطأ ما ، يرجى المحاولة لاحقاً";
            parent.append('<p>'+output+'<p>');
        }
    });
});
</script>



@if( isset($post) && $post && $post->id == 57533 )

<link rerl="stylesheet" href="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" />

<style>
    .datepicker{
        max-width: 100% !important;
            width: 205px !important;
            left: 34px !important;
            right: 0px !important;
            margin: auto !important;
                padding-right: 8px !important;
    }
</style>
<script src="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script>
    
    $(document).ready(function(){

        $('form.resForm').submit(function(){
           var name = $('input#aName').val();
           var phone = $('input#aPhone').val();
           var date = $('input#aDate').val();
           var note =  $('textarea#aNote').val();
            var output = $('#DivOutput');
            var submitBTN = $('#submitBTN');
            submitBTN.hide();
            output.show();
            output.html('<img src=\"{{ url("assets/imgs/loader.gif") }}\" />');
            
            
            $.ajax({
                type: 'post',
                url: "{{ url('Send_reservation') }}",
                dataType: 'json',
                data:{
                    name: name,
                    phone:phone,
                    date: date,
                    note: note
                },success:function(out){
                    if( out.status == true ){
                        output.html('<b style="color:#4bd1c8" >'+out.msg+'</b>');
                    }else{
                        output.show();
                        output.html('<b color="red">'+out.msg+'</b>');
                        }
                },error:function(){
                    
                        output.html('<b color="red">عذراً ، حدث خطأ ما ، يرجى المحاولة لاحقاً.</b>');
                }
            });
            return false;
        });

    });
    
</script>
<script>
    $('[data-toggle="datepicker"]').datepicker({
        container: 'form.resForm'
    });
</script>
@endif
<script>
            function toggleToc(){
                $('div.toc ul').toggleClass('hiddy');
                var txt = $('div.toc a.toggyBtn').text();
                console.log(txt);
                $('div.toc a.toggyBtn').text( txt == 'المزيد' ? 'إخفاء' : 'المزيد' );

                return false;
            }
</script>
@endsection
@section('scripts')
<script src="{{ asset('/js/jquery.star-rating-svg.js') }}"></script>
<script src="{{ asset('/js/custom-js.js') }}"></script>
@endsection
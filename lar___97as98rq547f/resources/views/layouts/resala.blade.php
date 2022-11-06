@extends('layouts.master')
<?PHP
if( isset($_GET['page']) && $_GET['page'] > 1 ){
    $art->title .= ' - صفحة '.$_GET['page'];
}

?>
@section('title', $art->title  )
@section('description', $art->excerpt)
@section('meta')
<meta name="og:title" content="{{ $art->title }}"/>
<meta name="og:image" content="https://www.setaat.com/uploads/max_uploads/2018/08/1533631568.png"/>
<meta name="og:description" content="{{ $art->excerpt }}"/>
<meta name="og:url" content="{{ url()->full() }}"/>
<meta name="twitter:title" content="{{ $art->title }}"/>
<meta name="twitter:description" content="{{ $art->excerpt }}"/>
<meta name="twitter:image" content="https://www.setaat.com/uploads/max_uploads/2018/08/1533631568.png"/>
<meta name="twitter:card" content="https://www.setaat.com/uploads/max_uploads/2018/08/1533631568.png"/>
@if( isset($_GET['page']) && $_GET['page'] > 1 )
<link rel="canonical" href="{{ url('رسالتك-من-ستات').'?page='.$_GET['page'] }}" />
@else
<link rel="canonical" href="{{ url('رسالتك-من-ستات') }}" />
@endif
@endsection
@section('content')
<style>.comments{ padding: 22px; }.media-body.comment-body { width: 100%; margin: 0 8px; }
.removeComment { float: left; cursor: pointer; position: absolute; top: 0px; right: 9px; font-size: 19px; }
.loaderIMG{ max-width: 65px; }
.showMoreBtn{ cursor:pointer; background: #3ec2ce; padding: 8px 31px; color: #fff; font-size: 16px; border-radius: 4px;}
.commentBtn { cursor:pointer; }
img.d-flex.mr-3.rounded-circle {width:68px; height:68px;}
b.imgCont {width: 68px; height: 68px; display: inline-block;}
</style>
<!--content-->
    <section class="index-content">
        <div class="container"> 
             <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('رسالتك-من-ستات') }}">رسالتك من ستات</a></li>
                 @if( Auth::check() && Auth::user()->role_id != null ) - {{ $sViews }} @endif
            </ol>
            <img style="display:none" src="https://www.setaat.com/uploads/max_uploads/2018/08/1533631568.png" />
            <div class="row">
                <!-- right-side-->
                <div class="col-md-8 col-xs-12">
                    @if( $posts->count() )
                    <ul class="respage">
                    @foreach( $posts as $post )
                     <li> <span>{{ $post->date }}</span>
                     <p><i class="fa fa-quote-right"></i>@if( $post->content ) <a href="{{ $post->content }}">{{ $post->title }}</a>@else {{ $post->title }}@endif <i class="fa fa-quote-left"></i><p>
                     <div class="">
                        <div class="share">
                            <a onclick="window.open('http://pinterest.com/pin/create/button/?url=' + '{{ url('/رسالتك-من-ستات/'.$post->id) }}&media=https://www.setaat.com/uploads/max_uploads/2018/08/1533631568.png&description={{ $post->title }}', 'sharer', 'width=600,height=600');" ><i class="fa fa-pinterest"></i></a>
                            <a onclick="window.open('https://plus.google.com/share?url=' + '{{ url('/رسالتك-من-ستات/'.$post->id) }}', 'sharer', 'width=600,height=600');"><i class="fa fa-google-plus"></i></a>
                            <a onclick="window.open('https://twitter.com/share?url={{ url('/رسالتك-من-ستات/'.$post->id) }}&text=' + '{{ $post->title }}', 'sharer', 'width=600,height=450');"><i class="fa fa-twitter"></i></a>
                            <a href="fb-messenger://share/?link={{ url('/رسالتك-من-ستات/'.$post->id) }}"><i class="fa fa-facebook-messenger"></i></a>
                            <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ url('/رسالتك-من-ستات/'.$post->id) }}','sharer', 'width=655,height=430'); return false;"><i class="fa fa-facebook"></i></a>
                        </div>
                        <a class="commentBtn setaatbtn"><i class="fa fa-comments"></i> التعليقات </a>
                     </div>
                     <div class="comments" data-id="{{ $post->id }}">
                     
                        <div class="card-body" style="display:none;"> <form action="https://www.setaat.com/post_commnet" method="post" class="commentForm"> <input type="hidden" @csrf <div class="form-group"> <input type="hidden" name="post_id" value="{{ $post->id }}"> <textarea class="form-control" name="comment" rows="3" required="" maxlength="300"></textarea> </div> <button type="submit" class="btn btn-primary" class="ResalaComment">أضف تعليق</button> <div class="show_comments"></div></form></div>

                     </div>
                     </li>
                    @endforeach
                    </ul>
                    @else
                    	<div style="margin:100px;"> <p>لا توجد رسائل بعد</p></div>
                    @endif
               {!! $posts->render() !!}
                </div>
                @if( !Mobile::isMobile() )
                <!--left side -->
                 <div class="col-md-4 col-sm-12">
                    <div class="left-side">
                  	@if(Sidebar::hasWidgets(Setting::get('category-sidebar')))
				@foreach(Sidebar::widgets(Setting::get('category-sidebar')) as $widget)
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
@section('cScripts')
<script>

function CommentBody(is_owner, comment_id, user_name, commentBody ){
    var commentsBody = '<div class="media mb-4 row"><div class="col-md-3">';
    commentsBody += (is_owner) ? '<a title="حذف التعليق" class="removeComment" CommentID="'+comment_id+'"><i class="fa fa-times" ></i></a>' : '';
    commentsBody += '<b class="imgCont"><img class="d-flex mr-3 rounded-circle" src="https://setaat.com/images/fuser.png" alt="" style=" height: auto; max-width: 68px; width: auto; "></b><b class="mt-0 comment-title">'+user_name+'</b></div><div class="col-md-9"><div class="media-body comment-body ">'+commentBody+'</div></div></div>';
    return commentsBody;
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    $('.commentBtn').click(function(){
        
        var c = $(this).parent().parent().find('.comments');
        c.css('clear','both');
        if( c.attr('shown') == 1 ) return false;
        c.attr('shown','1');
        c.find('.card-body').css('display','block');
        var id = c.attr('data-id');
        c.append('<img src="https://www.setaat.com/images/loader.gif" class="loaderIMG" />');
        $.ajax({
            url: '{{ url("resalaComments") }}',
            type:'post',
            dataType: 'json',
            data: { id: id },
            success:function(FetchedData){
                c.find('img.loaderIMG').remove();
                info = FetchedData['data'];
                data = FetchedData['comments'];
                console.log(data);
                for( i in data ){ console.log(data[i]);
                    var h = CommentBody( data[i].is_owner, data[i].comment_id, data[i].user_name, data[i].commentBody);
                    c.append(h);                 
                }
                if( info.currentPage < info.lastPage ){
                    c.append('<a class="showMoreBtn" data-id="'+info.id+'" current-page="'+info.currentPage+'" last-page="'+info.lastPage+'"><i class="fa fa-repeat"></i> المزيد من التعليقات</a>');
                }
            }
        });
    });

    
$(document).on("click",".removeComment",function() {

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


$(document).on("click",".showMoreBtn",function() {

    var id = $(this).attr('data-id');
    var currentPage = $(this).attr('current-page');
    var lastPage = $(this).attr('last-page');
    if( currentPage >= lastPage ) return false;
    var c = $(this).parent();
     $(this).remove();
        $.ajax({
            url: '{{ url("resalaComments") }}',
            type:'post',
            dataType: 'json',
            data: {
                id: id, page: ++currentPage
            },
            success:function(FetchedData){
                c.find('img.loaderIMG').remove();
                info = FetchedData['data'];
                data = FetchedData['comments'];
                console.log(data);
                for( i in data ){ console.log(data[i]);
                    var h = CommentBody( data[i].is_owner, data[i].comment_id, data[i].user_name, data[i].commentBody);
                    c.append(h);                 
                }
                if( info.currentPage < info.lastPage ){
                    c.append('<a class="showMoreBtn" data-id="'+info.id+'" current-page="'+info.currentPage+'" last-page="'+info.lastPage+'"><i class="fa fa-repeat"></i> المزيد من التعليقات </a>');
                }
               
            }
        });

    
});




$('.commentForm').submit(function(){
  var current = $(this);
  var form = $(this).serialize();
  var url = $(this).attr('action');
    $.ajax({
      url:url,
      dataType:'json',
      data:form,
      type:'post',
      beforeSend: function()
      {
        $('.alert_error h1').empty();
        $('.alert_error ul').empty();
      },success:function(data)
      {
        if(data.status == true)
        {
          current.find('.show_comments').last().append("<p>تم التعليق بنجاح ، الآن نإنتظار المراجعة للنشر.</p>");
          current.find('textarea').val('');
        }
      },error:function(data_error,exception)
      {
        if(exception == 'error')
        {
          alert(data_error);
        }
      }
    });
    return false;
  });

</script>
@endsection
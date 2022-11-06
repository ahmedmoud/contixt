@extends('layouts.master')

@section('title', $comp->title.' - '.$user->name )
@section('styles')
<link href="{{ asset('css/star-rating-svg.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link class="jsbin" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet">

@endsection
@section('content')
<!--content-->
    <section class="index-content">
        <div class="container"> 
             <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ url()->full() }}">{{ $comp->title.' - '.$user->name }} </a></li>
             </ol>
                <div class="post comptbody">
                <h1 class="text-center">{{ $comp->title.' - '.$user->name }}</h1>
                @if(session()->has('success'))
                    <div class="alert alert-success text-center">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <div class="pageContent">

                    @if( $compsub && $compsub->data->img )
                        <img class="img-responsive" src="{{ url($compsub->data->img) }}" style=" margin: auto; display: block; " />
                    @endif
                    <div class="boxedSocialLinks">
                     <i class="social-link fa fa-facebook" data-target="facebook" data-href="{{ url()->full() }}"></i>
                            <i class="social-link fa fa-twitter"  data-target="twitter" data-href="{{ url()->full() }}" data-text="{{ $comp->title.' - '.$user->name }}"></i>
                          <i class="social-link fa fa-google-plus" data-target="google" data-href="{{ url()->full() }}"></i>
                           <i class="social-link fa fa-pinterest" data-target="pinterest" data-href="{{ url()->full() }}"></i>
                </div>

                <div class="related-post beauty-box">
                            <div class="title-header">
                                <h4>التقيمات</h4>
                            </div>
                            @auth
                            <div class="rateSec">
                            <div class="col-md-6">
                            <label>تقيِيِمك</label>
                                <div class="my-rating-competition" data-href="{{ url('/competition/rate') }}" 
                                  data-post-id="{{ $compsub->id }}"
                                  @if( $myRate ) data-rating="{{ $myRate }}" @endif >
                                </div>
                            </div>
                             <div class="col-md-6">
                            <label>كافة التقييمات ( {{ $Rates->total }} عضوة - تقييم {{ round($Rates->rate, 1) }} من 5 )</label>
                                <div class="my-rating-competition" data-href="{{ url('/competition/rate') }}" 
                                  data-post-id="{{ $compsub->id }}"
                                  data-rating="{{ round($Rates->rate, 1) }}"  data-readonly="true"  >
                                </div>
                            </div>
                            </div>
                            @else
                                <div class="my-rating-competition" data-rating="{{ round($Rates->rate, 1) }}" data-readonly="true" ></div>
                            @endauth
                            </div>
                </div>
<br/>
 <div class="related-post beauty-box">
                                <div class="title-header">
                                    <h4>التعليقات</h4>
                                </div>
                                  <!-- Comments Form -->
                                <div class="card my-4" style="margin: 15px;">
                                    <h5 class="card-header">ضعي تعليقَكِ هنا</h5>
                                    <div class="card-body">
                                      <form action="{{url('/competitionCommnet')}}" method="post" id="commentForm">
                                        @csrf
                                        @auth
                                        <div class="form-group">
                                          <input type="hidden" name="sub_id" value="{{ $compsub->id }}">
                                          <textarea class="form-control" name="comment" rows="3" required maxlength="300"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary" id="CompComment">تعليق
                                        </button>
                                        @else
                                        <a href="#myModal2" data-toggle="modal"  class="btn btn-primary">تعليق
                                        </a>
                                        @endauth
                                      </form>
                                    </div>
                                  </div>

                                  <div class="show_comments">
                                  @foreach($comments as $comment)
                                  <!-- Single Comment -->
                                  
                                 @include('layouts.templates.comment') 
                                  @endforeach
                            </div>
            
            </div>
        </div>
    </section>
@endsection
@section('cScripts')
<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.removeComment').click(function(){
    $confirm = confirm('هل متأكدة من حذف هذا التعليق؟!');
    if( !$confirm ) return false;
var parent = $(this).parent();
    var CommentID = $(this).attr('CommentID');
    var output = '';
    $.ajax({
        url: '{{  url("/removeCompetitionComment") }}',
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


function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result) };
            reader.readAsDataURL(input.files[0]);
            $('#blah').css('display','block');
        }
    }
{{-- 
$('.moreInfo').submit(function(){
    var data = $(this).serialize();
    $.ajax({
        url: '{{ url("user-moreInfo") }}',
        type:'get',
        data: data,
        success:function(data){
            console.log(data);
        }
    });

    return false;   
}); --}}

$('#country').change(function(){
    var countryID = $(this).val();
    if( countryID == 0 ){
        return alert('يرجى اختيار دولتكي');
    }

    $.ajax({
        url: "{{ url('/getRegions') }}/"+countryID,
        type: "get",
        success:function(data){
            $('#region').removeAttr("disabled");
            for( var item in data ){
                $('#region').append('<option vale="'+data[item].id+'">'+data[item].name+'</option>');
            }
            $('.regionParent').show();
        }
    });


});

</script>
@endsection
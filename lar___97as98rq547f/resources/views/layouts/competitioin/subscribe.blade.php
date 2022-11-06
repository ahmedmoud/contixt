@extends('layouts.master')

@section('title', $post->title )
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link class="jsbin" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')

<!--content-->
    <section class="index-content">
        <div class="container"> 
             <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/competition/'.$post->slug.'/subscribe')}}">{{ $post->title }} </a></li>
             </ol>
                <div class="post comptbody">
                <h1 class="text-center">{{ $post->title }}</h1>
                @if( Session::get('UnderReview') )
                    <div class="alert alert-success text-center">
                        طلبك قيد المراجعة
                    </div>
                @else
                @if(session()->has('success'))
                    <div class="alert alert-success text-center">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if( $errors->has('msg') )
                    <h4>{{$errors->first('msg')}}</h4>
                @endif
                @if( !$subscribed )
                <form class="moreInfo" action="#" method="post" enctype="multipart/form-data" >
                <div class="">
                @csrf
                    <img id="blah" src="#" alt="your image" />
                    <input type="file" name="img" id="file" class="inputfile" onchange="readURL(this);" />
                    <label for="file"><i class="fa fa-image"></i> اختاري الصورة </label>
                </div>
                 <button type="submit" class="btn btn-setaat mauto">إرسال</button>
                </form>
                @else
                <div class="alert alert-success text-center">
                    <a href="{{ url('/competition/'.$post->slug.'/'.Auth::user()->id) }}" style="color:red;">رابط صفحتك</a>
                    @if( !session()->has('success') )
                        أنت بالفعل مشترك في هذه المسابقة. 
                        @if( !$subscribed->status ) - الطلب قيد المراجعة @endif
                    @endif
                     </div>
                @endif
                @endif
            </div>
        </div>
    </section>
@endsection
@section('cScripts')
<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

<script>
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
@extends('layouts.master')

@section('title', 'استكمال التسجيل')
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
                          <li class="breadcrumb-item"><a href="{{ url('/more-info')}}">بيانات المستخدم</a></li>
                        </ol>
                <div class="post comptbody">
                <h1 class="text-center">استكمال التسجيل</h1>

                @if( $errors->has('msg') )
                    <h4>{{$errors->first('msg')}}</h4>
                @endif
{{ $errors }}
                <form class="moreInfo" action="{{ url('user-moreInfo').( isset($_GET['return'])? '?return='.$_GET['return'] : '' ) }}" method="post" enctype="multipart/form-data" >
                <div class="">
                @csrf
                    <img id="blah" src="#" alt="your image" />
                    <input type="file" name="img" id="file" class="inputfile" onchange="readURL(this);" />
                    <label for="file"><i class="fa fa-image"></i> اختاري صورتك </label>
                </div>
                    {{-- <label> الدولة
                        <select class="select2" name="country" id="country" >
                        @foreach( $countries as $country )<option value="{{ $country->id }}">{{ $country->name }}</option> @endforeach
                        </select>
                    </label>
                    <style>
                        form.moreInfo label.regionParent{ display:none; }
                        form.moreInfo label.cityParent{ display:none; }
                    </style>
                    <label class="regionParent" > المحافظة
                        <select disabled id="region">
                            <option value="0">المحافظة</option>
                        </select>
                    </label>

                    <label  class="cityParent" > المدينة
                        <select disabled id="city">
                            <option value="0">المدينة</option>
                        </select>
                    </label> --}}
                    <label><div> تاريخ الميلاد 
                        @if($errors->has('year')) <span class="invalid-feedback"> : {{ $errors->first('year') }}<br/></span> @endif
                        @if($errors->has('month')) <span class="invalid-feedback"> : {{ $errors->first('month') }}<br/></span> @endif
                        @if($errors->has('day')) <span class="invalid-feedback"> : {{ $errors->first('day') }}</span> @endif
                    </div>
                        <div class="col-md-4">
                            <select name="day" required><option value="" >اليوم</option>
                                @foreach (range(1, 31) as $month): ?>
<option {{ ( old('day') && old('day') == $month )? 'selected' : '' }} value="{{sprintf("%02d", $month) }}">{{sprintf("%02d", $month) }}</option>
@endforeach
                            </select>
                        </div>
                         <div class="col-md-4">
                            <select name="month" required><option value="" >الشهر</option>
                                @foreach (range(1, 12) as $month): ?>
<option {{ ( old('month') && old('month') == $month )? 'selected' : '' }} value="{{sprintf("%02d", $month) }}">{{sprintf("%02d", $month) }}</option>
@endforeach
                            </select>
                        </div>
                         <div class="col-md-4">
                            <select  name="year" required><option value="" >السنة</option>
                                @foreach (range(1960, 2000) as $month): ?>
<option {{ ( old('year') && old('year') == $month )? 'selected' : '' }} value="{{sprintf("%02d", $month) }}">{{sprintf("%02d", $month) }}</option>
@endforeach
                            </select>
                        </div>
                    </label>
                    <label  class="cityParent" > الوظيفة  @if($errors->has('job_id')) <span class="invalid-feedback"> : {{ $errors->first('job_id') }}</span> @endif
                        <select  id="job" name="job_id" required >
                            <option value="">الوظيفة</option>
                            @foreach( $jobs as $job ) <option {{ ( old('job_id') && old('job_id') == $job->id )? 'selected' : '' }} value="{{ $job->id }}">{{ $job->title }}</option>@endforeach
                        </select>
                    </label>
                    <label>رقم الموبايل @if($errors->has('mobile'))
                	<span class="invalid-feedback"> : {{ $errors->first('mobile') }}</span>
                	@endif
                        <input type="phone" name="mobile" required class="@if($errors->has('mobile')) is-invalid @endif form-control" placeholder="رقم الموبايل" value="{{ old('mobile')? old('mobile') : '' }}" />
                    </label>
                    

                 <button type="submit" class="btn btn-setaat mauto">إرسال</button>

                </form>
                              
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
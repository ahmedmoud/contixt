@extends('layouts.master')

@section('title', $data->title )
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
                          <li class="breadcrumb-item"><a href="{{ url($data->slug )}}">{{ $data->title }}</a></li>
             </ol>
                <div class="post comptbody">
                <h1 class="text-center">{{ $data->title  }}</h1>
                @if( $errors->has('msg') )
                    <h4 style=" text-align: center; color: red; ">{{$errors->first('msg')}}</h4>
                @endif
                @if( $errors->has('success') )
                    <h4 style=" text-align: center; color: green; ">{{$errors->first('success')}}</h4>
                @endif

    <form class="moreInfo" action="{{ url('contactForm') }}" method="post" enctype="multipart/form-data" enctype="multipart/form-data" style="max-width:100%">
                @csrf
                <div class="col-md-6">
                    <label  class="cityParent" > الإسم بالكامل @if($errors->has('name')) <span class="invalid-feedback"> : {{ $errors->first('name') }}</span> @endif
                        <input type="text" name="name" required placeholder="الإسم بالكامل" value="{{ old('name')? old('name') : '' }}"/>
                    </label>
                    <input type="hidden" name="type" value="{{ $data->type }}" />
                </div>
                <div class="col-md-6">
                    <label  class="cityParent" > رقم الموبايل @if($errors->has('phone')) <span class="invalid-feedback"> : {{ $errors->first('phone') }}</span> @endif
                        <input type="text" name="phone" required placeholder="رقم الموبايل" {{ old('phone')? old('phone') : '' }}/>
                    </label>
                </div>
                <div class="col-md-6">
                    <label  class="cityParent" > البريد الإلكتروني  @if($errors->has('email')) <span class="invalid-feedback"> : {{ $errors->first('email') }}</span> @endif
                        <input type="text" name="email" required placeholder="البريد الإلكتروني" {{ old('email')? old('email') : '' }}/>
                    </label>
                </div>
                <div class="col-md-6">
                    <label  class="cityParent" > عنوان الرسالة   @if($errors->has('subject')) <span class="invalid-feedback"> : {{ $errors->first('subject') }}</span> @endif
                        <input type="text" name="subject" required placeholder=" عنوان الرسالة" {{ old('subject')? old('subject') : '' }}/>
                    </label>
                </div>
                     <div class="col-md-12">
                    <label>الرسالة @if($errors->has('message'))
                	<span class="invalid-feedback"> : {{ $errors->first('message') }}</span>
                	@endif
                        <textarea maxlength="700" style=" min-height: 150px; " class="@if($errors->has('message')) is-invalid @endif form-control" name="message" placeholder="الرسالة"  >{{ old('message')? old('message') : '' }}</textarea>
                    </label>
                    <div>
                        <img src='{{ url("getCaptchaIMg?_CAPTCHA") }}'  style=" margin: auto; display: block; " />       
                        <input type="text" required name="captcha" placeholder="اكتب النص الموجود بالصورة" style=" max-width: 235px; display: block; margin: 7px auto; text-align:center;" />
                    </div>
                    </div>
                 <button type="submit" class="btn btn-setaat mauto">إرسال</button>
                </form>
            </div>
        </div>
    </section>
    
@endsection
@section('cScripts')
<script>

    $("button[type='submit']").click(function(){
        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length)>3){
        alert("عدد الملفات بحد أقصى 3 ملفات");
        return false;
        }
    });    

</script>
@endsection
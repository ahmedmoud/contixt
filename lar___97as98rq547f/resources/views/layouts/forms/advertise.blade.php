@extends('layouts.master')

@section('title', 'انضمي لنا')
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
                          <li class="breadcrumb-item"><a href="{{ url('/اشتركي-معنا')}}">اشتركي معنا</a></li>
             </ol>
                <div class="post comptbody">
                <h1 class="text-center">شاركي معنا</h1>
                @if( $errors->has('msg') )
                    <h4 style=" text-align: center; color: red; ">{{$errors->first('msg')}}</h4>
                @endif
                @if( $errors->has('success') )
                    <h4 style=" text-align: center; color: green; ">{{$errors->first('success')}}</h4>
                @endif
@if( $is_there && !$is_there->status )
    <div class="alert alert-success text-center">
        @if( Auth::check() && Auth::user()->role_id != null )
            بالفعل أنتي منضمة معنا
        @else
        طلبكم قيد المراجعة ، سيتم التواصل معكم في اقرب وقت.
        @endif
    </div>
@elseif( $is_there && $is_there->status == 1 )
    <div class="alert alert-success text-center">
        تم قبول طلبكم بنجاح.
        @if( Auth::check() && Auth::user()->role_id != null )
            - بالفعل أنتي منضمة معنا
        @endif 
    </div>
@elseif( $is_there && $is_there->status == 2 )
        <div class="alert alert-danger text-center">
            {{ $is_there->reason }}
        </div>
@elseif(  $is_there && $is_there->status == 3 )

        <div class="alert alert-danger text-center">
        عذراً ، تم رفض الطلب <br/>
            <b>{{ $is_there->reason }}</b>
        </div>
@else
    <form class="moreInfo" action="{{ url('joinUs').( isset($_GET['return'])? '?return='.$_GET['return'] : '' ) }}" method="post" enctype="multipart/form-data" enctype="multipart/form-data" style="max-width:100%">
                @csrf
                  <div class="col-md-6">
                    <label  class="cityParent" > هل لديكي خبرة بالكتابة؟  @if($errors->has('job_id')) <span class="invalid-feedback"> : {{ $errors->first('job_id') }}</span> @endif
                        <select  id="experience" name="experience" required >
                            <option></option>
                            <option value="0">لا</option>
                            <option value="1">نعم</option>
                        </select>
                    </label>
                    </div>
                     <div class="col-md-6">
                     <label> ملفات أعمال سابقة ( docx, pdf ) @if($errors->has('oldFiles'))
                	<span class="invalid-feedback"> : {{ $errors->first('oldFiles') }}</span>
                	@endif
                       <input type="file" name="files[]" multiple  accept=".doc,.docx" />
                    </label>
                    </div>
                     <div class="col-md-6">
                    <label>روابط أعمال سابقة @if($errors->has('oldURLs'))
                	<span class="invalid-feedback"> : {{ $errors->first('oldURLs') }}</span>
                	@endif
                        <textarea maxlength="700" style=" min-height: 150px; " class="@if($errors->has('oldURLs')) is-invalid @endif form-control" name="oldURLs" placeholder="سابقة أعمال" value="{{ old('oldURLs')? old('oldURLs') : '' }}" ></textarea>
                    </label>
                    </div>
                    <div class="col-md-6">
                    <label>ملاحظات أخرى @if($errors->has('notice'))
                	<span class="invalid-feedback"> : {{ $errors->first('notice') }}</span>
                	@endif
                        <textarea maxlength="700" style=" min-height: 150px; " class="@if($errors->has('notice')) is-invalid @endif form-control" name="notice" placeholder="ملاحظات أخرى" value="{{ old('oldURLs')? old('notice') : '' }}" ></textarea>
                    </label>
                    </div>
                 <button type="submit" class="btn btn-setaat mauto">إرسال</button>
                </form>
@endif            
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
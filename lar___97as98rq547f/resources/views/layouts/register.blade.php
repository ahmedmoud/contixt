@extends('layouts.master')
@section('title',  'التسجيل' )
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>.select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        background: #ec1a74;
        color: #fff;
    }
    
    .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }
    
    input.select2-search__field {
        width: 10px !important;
        background: red;
        color: red;
        border: none;
    }
    .select2{
        max-width: 300px; margin: 0 auto;
    }
    .select2-container{
        max-width: 300px;
margin: 4px 0;
    }
    li.select2-search.select2-search--inline {
width: 100%;
height: 35px;
background: none !important;
}

ul.select2-selection__rendered {
padding: 0 !important;
border: none;
background: none;
}
input.select2-search__field {
    width: 100% !important;
    display: block;
    float: none;
    max-width: 100% !important;
}
    </style>
@endsection
@section('content')

<!--content-->
    <section class="index-content">
        <div class="container">
            <div class="row">
                <!-- right-side-->
                <div class="col-xs-12">
                    <ol class="breadcrumb" style=" margin-bottom: 7px; ">
                          <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li>
                          <li class="breadcrumb-item active"><a href="{{ url('register') }}">التسجيل</a></li>
                    </ol>
                    
                    
                </div>
            </div>

            <div class="container">
<div id="sign-up-modal">
                    <form action="{{url('user/register/new')}}" method="post" id="modalRegisterr">  <input type="text" name="name" placeholder="الاسم">  <input type="text" name="username" placeholder="إسم المستخدم">  <input type="text" name="email" placeholder="البريد الالكتروني">  <input type="password" name="password" placeholder="كلمة السر">  <input type="password" name="password_confirmation" placeholder="تأكيد كلمة السر">  {{-- <div id="captcha1" class="captcha"></div> --}} <img src="{{ url('getCaptchaIMg?_CAPTCHA') }}" alt="Setaat Captcha"/>  <input type="text" name="captcha" id="captcha2" placeholder="يرجى كتابة النص الموجود بالصورة" /> 
                        
                        <select  multiple name="categories[]" class="snew @if($errors->has('categories')) is-invalid @endif form-control select2">

                                @foreach( \App\Category::select('id','name')->get() as $category )
                                      <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                @endforeach
                               
                            </select>
<div><label style=" line-height: 32px; ">الحصول على إشعارات ؟ <input type="checkbox" value="1" checked="" name="notifications" style=" width: 16px; display: inline-block; float: right; margin: 0; margin-left: 8px; "></label></div>
                        <input type="submit" id="modalRegisterBtnn" value="تسجيل">  <p class="h5 text-center small">تسجيل من خلال</p>  <div class="sign-buttons">  <a href="{{url('/auth/facebook')}}" class="facebook">Facebook</a>  <a href="{{ url('/auth/twitter') }}" class="twitter">Twitter</a>  </div> </div> </form> 

                </div>    </div>


        </div>
    </section>

@endsection
@section('cScripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
     $(document).ready(function(){
        $(".snew").select2({
            placeholder: 'اختري الأقسام التي تهمك',
            dir: "rtl"
        });
     });
     </script>

@endsection
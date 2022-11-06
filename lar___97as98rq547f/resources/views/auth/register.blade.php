@extends('layouts.auth.auth')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/login-register-lock.css') }}">
@endsection
@section('content')
    <div class="login-box card">
        <div class="card-body">
            <form class="form-horizontal form-material" id="loginform" action="{{ route('register') }}" method="post">
                @csrf
                <h3 class="box-title m-b-20">التسجيل</h3>
                <div class="form-group">
                    <div class="@if($errors->has('name')) error @endif col-xs-12">
                        <input name="name" value="{{ old('name') }}" class="form-control" type="text" {{-- required --}} placeholder="الاسم">
                        @if($errors->has('name'))
                            <div class="help-block">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <div class="@if($errors->has('username')) error @endif col-xs-12">
                        <input name="username" value="{{ old('username') }}" class="form-control" type="text" {{-- required="" --}} placeholder="إسم المستخدم">
                        @if($errors->has('username'))
                            <div class="help-block">{{ $errors->first('username') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <div class="@if($errors->has('email')) error @endif col-xs-12">
                        <input name="email" value="{{ old('email') }}" class="form-control" type="text" {{-- required="" --}} placeholder="البريد الالكتروني">
                        @if($errors->has('email'))
                            <div class="help-block">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <div class="@if($errors->has('password')) error @endif col-xs-12">
                        <input name="password" class="form-control" type="password" {{-- required="" --}} placeholder="كلمة المرور">
                        @if($errors->has('password'))
                            <div class="help-block">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="@if($errors->has('password_confirmation')) error @endif col-xs-12">
                        <input name="password_confirmation" class="form-control" type="password" {{-- required="" --}} placeholder="تأكيد كلمة المرور">
                        @if($errors->has('password_confirmation'))
                            <div class="help-block">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center p-b-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">تسجيل</button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        هل لديك بريد الكتروني بالفعل؟ <a href="{{ route('login') }}" class="text-info m-l-5"><b>تسجيل الدخول</b></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
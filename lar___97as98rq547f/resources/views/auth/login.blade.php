@extends('layouts.auth.auth')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/login-register-lock.css') }}">
@endsection
@section('content')
            <div class="login-box card">
                @if($errors->has('auth'))
                    <div class="alert alert-danger flash">{{ $errors->first('auth') }}</div>
                @endif
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" action="{{ route('login') }}" method="post">
                        @csrf
                        <h3 class="box-title m-b-20">تسجيل الدخول</h3>
                        <div class="form-group ">
                            <div class="@if($errors->has('email')) error @endif col-xs-12">
                                <input class="form-control" name="email" type="text" value="{{ old('email') }}" required placeholder="إسم المستخدم او البريد الالكتروني">
                                @if($errors->has('email'))
                                    <div class="help-block">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="@if($errors->has('password')) error @endif col-xs-12">
                                <input class="form-control" name="password" type="password" required placeholder="كلمة المرور"> </div>
                                @if($errors->has('password'))
                                    <div class="help-block">{{ $errors->first('password') }}</div>
                                @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input name="remember" type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">تذكرني</label>
                                    <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> نسيت كلمة المرور ؟</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">تسجيل الدخول</button>
                            </div>
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">--}}
                                {{--<div class="social">--}}
                                    {{--<a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>--}}
                                    {{--<a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        
                    </form>
                    <form class="form-horizontal" id="recoverform" action="index.html">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>إستعادة كلمة المرور</h3>
                                <p class="text-muted">أدخل بريدك الالكتروني</p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="البريد الالكتروني"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">إستعادة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection

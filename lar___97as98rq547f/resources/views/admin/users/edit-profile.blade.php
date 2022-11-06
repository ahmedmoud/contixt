@php
    $isEdit = @$user ? true : false;
@endphp
@extends('admin.master')
@section('title', 'Add Categories')
@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                <h4 class="card-title">
                  {{ __('admin.edit_user') }}: {{ $user->name }}
                </h4>

                    <form class="form" action="{{ url('/admin/users/'.$user->id.'/edit-profile') }}" method="post">
                        @method('post')
            
                    @csrf

                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">الاسم</label>
                        <div class="col-10">
                            <input class="form-control" name="name" type="text"  id="example-text-input" placeholder="الاسم" @if($isEdit) value="{{ old('name') ??  @$user->name ?? '' }}" @else value="{{ old('name') }}" @endif>
                        </div>
                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">إسم المستخدم</label>
                        <div class="col-10">
                            <input class="form-control" name="username" type="text" disabled  id="example-text-input" placeholder="إسم المستخدم" @if($isEdit) value="{{ old('username') ??  @$user->username ?? '' }}" @else value="{{ old('username') }}" @endif>
                        </div>
                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">البريد الالكتروني</label>
                        <div class="col-10">
                            <input class="form-control" name="email" type="email"  id="example-text-input" placeholder="البريد الالكتروني" @if($isEdit) value="{{ old('email') ??  @$user->email ?? '' }}" @else value="{{ old('email') }}" @endif>
                        </div>
                    </div>
                    
                                        <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">كلمة السر </label>
                        <div class="col-10">
                            <input class="form-control" name="password" type="password"  id="example-text-input" placeholder="كلمة السر " @if($isEdit) value="{{ old('password') ??  @$user->password ?? '' }}" @else value="{{ old('password') }}" @endif>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-block">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

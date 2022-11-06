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
                    @if($isEdit)
                        {{ __('admin.edit') }}
                    @else
                    {{ __('admin.add') }}
                    @endif
                    {{ __('admin.user') }}
                </h4>
                @if($isEdit)
                    <form class="form" action="{{ $user->url->update }}" method="post">
                        @method('PUT')
                @else
                    <form class="form" action="{{ route('users.index') }}" method="post">
                @endif
                    @csrf

                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.name') }}</label>
                        <div class="col-10">
                            <input class="form-control" name="name" type="text"  id="example-text-input" placeholder="{{ __('admin.name') }}" @if($isEdit) value="{{ old('name') ??  @$user->name ?? '' }}" @else value="{{ old('name') }}" @endif>
                        </div>
                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.username') }}</label>
                        <div class="col-10">
                            <input class="form-control" name="username" type="text"  id="example-text-input" placeholder="{{ __('admin.username') }}" @if($isEdit) value="{{ old('username') ??  @$user->username ?? '' }}" @else value="{{ old('username') }}" @endif>
                        </div>
                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.email') }}</label>
                        <div class="col-10">
                            <input class="form-control" name="email" type="email"  id="example-text-input" placeholder="{{ __('admin.email') }}" @if($isEdit) value="{{ old('email') ??  @$user->email ?? '' }}" @else value="{{ old('email') }}" @endif>
                        </div>
                    </div>
                    
                                        <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.password') }}</label>
                        <div class="col-10">
                            <input class="form-control" name="password" type="password"  id="example-text-input" placeholder="{{ __('admin.password') }}" @if($isEdit) value="{{ old('password') ??  @$user->password ?? '' }}" @else value="{{ old('password') }}" @endif>
                        </div>
                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.role') }}</label>
                        <div class="col-10">
                            <select name="role_id" class="form-control">
                            <option value="">{{ __('admin.normal_user') }}</option>
                                @foreach($roles as $role)
                                    <option
                                            @if($isEdit)
                                                @if($user->role_id && $user->role->id == $role->id)
                                                    selected
                                                @endif
                                            @else
                                                @if(old('role_id') == $role->id)
                                                    selected
                                                @endif
                                            @endif
                                            value="{{ $role->id }}"> {{ $role->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">{{ __('admin.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
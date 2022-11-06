@extends('admin.master')
@section('title', 'Add Categories')
@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if(isset($role) && isset($role->id))
                        تعديل رتبة
                    @else
                        إنشاء رتبة
                    @endif
                </h4>
                @if(isset($role) && isset($role->id))
                    <form class="form" action="{{ url('/admin/roles/'. $role->id) }}" method="post">
                        @method('PUT')
                @else
                    <form class="form" action="{{ url('/admin/roles') }}" method="post">
                @endif
                    @csrf

                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">الاسم</label>
                        <div class="col-10">
                            <input class="form-control" name="name" type="text"  id="example-text-input" placeholder="الاسم" @if(isset($role) && isset($role->id)) value="{{ old('name') ??  @$role->name ?? '' }}" @else value="{{ old('name') }}" @endif>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

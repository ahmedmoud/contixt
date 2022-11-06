@extends('admin.master')
@section('title', 'Add Categories')
@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if(isset($tag) && isset($tag->id))
                        تعديل وسم
                    @else
                        إنشاء وسم
                    @endif
                </h4>
                @if(isset($tag) && isset($tag->id))
                    <form class="form" action="{{ url('/admin/tags/'. $tag->id) }}" method="post">
                        @method('PUT')
                @else
                    <form class="form" action="{{ url('/admin/tags') }}" method="post">
                @endif
                    @csrf

                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">الاسم</label>
                        <div class="col-10">
                            <input class="form-control" name="name" type="text"  id="example-text-input" placeholder="الاسم" @if(isset($tag) && isset($tag->id)) value="{{ old('name') ??  @$tag->name ?? '' }}" @else value="{{ old('name') }}" @endif>
                        </div>
                    </div>
                        <div class="form-group row">
                            <label for="example-month-input" class="col-2 col-form-label">الرابط</label>
                            <div class="col-10">
                                <input type="text" class="form-control" name="slug" value="{{ old('slug') ?? @$tag->slug ?? ''}}">
                            </div>
                        </div>
                    <button type="submit" class="btn btn-success btn-block">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

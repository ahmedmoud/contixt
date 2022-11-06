@extends('admin.master')
@section('title', 'Add Categories')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">تعديل {{ $data->name }}</h4>
                <form class="form" action="{{ url('admin/recipes_types/'.$type.'/'.$data->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.title') }}</label>
                        <div class="col-10">
<input class="form-control @if($errors->has('name')) is-invalid @endif" name="name" type="text"  id="example-text-input" placeholder="{{ __('admin.title') }}" value="{{ old('name') ? old('name') : $data->name  }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                    </div>
                   
                 
                    </div>
                    <button type="submit" class="btn btn-success btn-block">{{ __('admin.save') }}</button>
                </form>
            </div>
        </div>
    </div>


@endsection

@extends('admin.master')
@section('title', 'Edit Categories')

@section('styles')
        <link href="{{ asset('admin_panel/jquery-asColorPicker-master/css/asColorPicker.css') }}" rel="stylesheet" />

@endsection


@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"> {{ __('admin.edit_category') }} : {{ $category->name }}</h4>
                <form class="form" action="{{ url('admin/categories/'.$category->id) }}" method="post">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.cat_name') }}</label>
                        <div class="col-10">
                            <input class="@if($errors->has('name')) is-invalid @endif form-control" name="name" type="text"  id="example-text-input" value="{{ $category->name }}" placeholder="{{ __('admin.cat_name') }}">
                            @if($errors->has('name'))
                                <div class="feedback-invalid">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.slug') }}</label>
                        <div class="col-10">
                            <input  class="form-control" name="slug" type="text"  id="example-text-input" value="{{ urldecode($category->slug) }}" placeholder="{{ __('admin.slug') }}">
                        </div>
                    </div>
                    

                    <div class="form-group m-t-40 row">
                            <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.description') }}</label>
                            <div class="col-10">
<input name="description" class="form-control @if($errors->has('description')) is-invalid @endif" name="description" type="text"  id="example-text-input" placeholder="{{ __('admin.description') }}" value="{{ old('description') ?  old('description') : $category->description  }}">
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                        </div>

                    <div class="form-group row">
                        <label for="example-month-input" class="col-2 col-form-label">{{ __('admin.Parent') }}</label>
                        <div class="col-10">
                            <select   name="parent_id" class="custom-select col-12" id="inlineFormCustomSelect">
                                <option value="" selected="">{{ __('admin.Parent') }}</option>
                                @foreach($categories as $cat)
                                
                                    <option  value="{{ $cat->id }}" 
                                        @if($category->parent_id == $cat->id)
                                            {{ "selected" }}
                                        @endif
                                        ">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">{{ __('admin.color') }}</label>
                        <div class="col-10">
                            <input class="colorpicker form-control" name="color" type="text"  id="example-text-input" placeholder="#f00" value="{{ $category->color }}">
                            
                            

                            @if($errors->has('color'))
                                <div class="invalid-feedback">{{ $errors->first('color') }}</div>
                            @endif
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success btn-block">{{ __('admin.save') }}</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')


    <script src="{{ asset('admin_panel/jquery-asColorPicker-master/libs/jquery-asColor.js') }}"></script>
    <script src="{{ asset('admin_panel/jquery-asColorPicker-master/libs/jquery-asGradient.js') }}"></script>
    <script src="{{ asset('admin_panel/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js') }}"></script>

	<script>
	    
	     // Colorpicker
    $(".colorpicker").asColorPicker();
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });

	    
	</script>
	

@endsection
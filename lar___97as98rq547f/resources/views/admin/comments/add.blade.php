@extends('admin.master')
@section('title', 'Add Categories')

@section('styles')
        <link href="{{ asset('admin_panel/jquery-asColorPicker-master/css/asColorPicker.css') }}" rel="stylesheet" />

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">إضافة قسم جديد</h4>
                <form class="form" action="{{ url('admin/categories') }}" method="post">
                    @csrf
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">اسم القسم</label>
                        <div class="col-10">
                            <input class="form-control @if($errors->has('name')) is-invalid @endif" name="name" type="text"  id="example-text-input" placeholder="إسم القسم" value="{{ old('name') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">الرابط</label>
                        <div class="col-10">
                            <input name="slug" class="form-control @if($errors->has('slug')) is-invalid @endif" name="title" type="text"  id="example-text-input" placeholder="الرابط" value="{{ old('slug') }}">
                            @if($errors->has('slug'))
                                <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                            @endif
                        </div>

                    </div>
                    
                    <div class="form-group row">
                        <label for="example-month-input" class="col-2 col-form-label">القسم الاب</label>
                        <div class="col-10">
                            <select name="parent_id" class="custom-select col-12">
                                <option value="" selected="">اختار القسم الاب</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-2 col-form-label">اللون</label>
                        <div class="col-10">
                            <!--<input class="form-control @if($errors->has('color')) is-invalid @endif" name="color" type="color"  value="#ff0000" id="example-text-input" placeholder="القسم" value="{{ old('color') }}">-->
                            
                            
<input type="text" class="colorpicker form-control form-control @if($errors->has('color')) is-invalid @endif value="#ff0000" name="color"/> </div>

                            @if($errors->has('color'))
                                <div class="invalid-feedback">{{ $errors->first('color') }}</div>
                            @endif
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success btn-block">حفظ</button>
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
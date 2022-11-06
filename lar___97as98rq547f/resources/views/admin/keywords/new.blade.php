@extends('admin.master')
@section('title', 'Admin Categories')
@section('styles')
    <link href="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

@endsection
@section('content')
 
		<div>
            @can('create', 'posts')
			    <a href="{{ url('admin/posts/create') }}" class="btn btn-primary" style="margin: 10px;">{{ __('admin.add_post') }}</a>
            @endcan
			<br>
		</div> 
		<div class="row">
            <div class="col-12">
<style>
textarea{
    direction: rtl;
    text-align: right;
    width: 100%;
    min-height: 500px;
    border: 0;
    padding: 7px; margin: 7px 0;
}
</style>
@if (\Session::has('error'))
<div class="alert alert-danger">
    <label>موجود من قبل</label>
    <ul>
        @foreach( \Session::get('error') as $er )
        <li><a href="{{ $er['slug'] }}">{{ $er['line'] }}</a></li>
        @endforeach
    </ul>
</div>
@endif
                    <form action="{{ url('admin/keywords').'?ash=yes' }}" method="POST" class="form-horizontal m-t-40">
@csrf
@method('POST')

<div>
<label><input type="checkbox" name="is_recipe" value="1" />  وصفات ؟  </label>
<br/>
<div class="form-group">
    <label>{{ __('admin.categories') }} *</label>
    <select  multiple name="categories[]" class="snew @if($errors->has('categories')) is-invalid @endif form-control select2">

        @foreach( \App\Category::select('id','name')->get() as $category )
              <option value="{{ $category->id }}" 
              @if(  old('categories') && in_array( $category->id, old('categories') )  ) selected @endif
              >{{ $category->name }}</option>
        @endforeach
       
    </select>
    @if($errors->has('categories'))
      <div class="red-feedback">{{ $errors->first('categories') }}</div>
    @endif
 </div>

 
</div>

<label style=" direction: ltr; ">الكلمة الدلالية # الرابط # طول المقالة # العنوان # تعليمات # داخل المحتوى</label>
{{-- <input type="text" name="length" placeholder="عدد الكلمات" class=" form-control" /> --}}
                      <textarea name="data" placeholder="keyword per line">{{ old('data') ? old('data') : '' }}</textarea>
                        <button class="btn btn-danger" type="submit" >Create</button>
                    </form>
                    <br/><br/><br/>
            </div>
        </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
     <script>
     // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    $('select').select2();
    </script>


@endsection
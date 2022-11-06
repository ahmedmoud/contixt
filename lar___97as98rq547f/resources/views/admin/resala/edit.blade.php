@php
    $isEdit = @$post ? true : false;
@endphp
@extends('admin.master')
@section('styles')
<link href="{{ asset('admin_panel/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection
@section('content')
<script>
    var mainURL = '{{ url('/') }}';
</script>
    @include('media::modal')
  <div class="col-lg-12" >
   <div class="card">
      <div class="card-body">
      <h4 class="card-title" style=" text-align: center; color: #4f5467; ">
          @if($isEdit)
              تعديل
          @else
              اضافة
          @endif
          رسالة
      </h4>
      <form class="form-horizontal m-t-40" method="POST" action="@if($isEdit){{ url('admin/resala/'.$post->id) }}@else{{ url('admin/resala') }}@endif" enctype="multipart/form-data" >
        @csrf
          @if($isEdit)
              @method('PUT')
          @else
              @method('POST')
          @endif
          
          <div class="form-group">
            <label for="title">عنوان *</label>
            <div class="input-group mb-3">
                <input required value="{{ old('title') ? old('title') : ($isEdit ? @$post->title : '') }}" type="text" class="@if($errors->has('title')) is-invalid @endif form-control" placeholder="عنوان" name="title">
                @if($errors->has('title'))
                	<div class="invalid-feedback">{{ $errors->first('title') }}</div>
                	@endif
            </div>
          </div>
            <div class="form-group">
            <label for="title">الرابط *</label>
            <div class="input-group mb-3">
                <input value="{{ old('content') ? old('content') : ($isEdit ? @$post->content : '') }}" type="text" class="@if($errors->has('content')) is-invalid @endif form-control" placeholder="الرابط" name="content">
                @if($errors->has('content'))
                	<div class="invalid-feedback">{{ $errors->first('content') }}</div>
                	@endif
          </div>
          </div>

@if( UPerm::PublishResala() || ( $isEdit && $post->status == 1 ) )
<lable for="fstatus"> <input id="fstatus"  type="radio" name="status" value="1" @if(old('status') && old('status') == 1) checked @elseif($isEdit) @if($post->status && $post->status == 1 ) checked @endif @endif/> منشور</lable>
@endif

@can('control','resala') 
          <div class="form-group">
                        <label class="m-t-40">التاريخ - الوقت ( في حالة عدم تغيير الوقت هيكون الحالي )</label>
                        <input type="text" id="date-time-format" class="form-control" placeholder="Now" name="created_at" value="{{ empty('created_at') ? \Carbon\Carbon::now()  : old('created_at') ? old('created_at') : ($isEdit ? $post->created_at : \Carbon\Carbon::now() ) }}">
          </div>
@endcan
       <br/>
        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
            @if($isEdit)
                حفظ التعديل
            @else
                اضافة 
            @endif
        </button>
         </form>
          </div>
          </div>
          </div>


    @endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
     <script src="{{ asset('admin_panel/moment/moment.js') }}"></script>
     <script src="{{ asset('admin_panel/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
     <script>
    $('#date-time-format').bootstrapMaterialDatePicker({
         format: 'YYYY-MM-DD HH:mm:00' 
        });
    </script>
    
@endsection
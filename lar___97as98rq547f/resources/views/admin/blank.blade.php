@php
    $isEdit = @$post ? true : false;
@endphp
@extends('admin.master')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link href="{{ asset('admin_panel/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_panel/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection
@section('content')
<script>
    var mainURL = '{{ url('/') }}';
</script>

  <div class="col-lg-12" >
   <div class="card">
      <div class="card-body">
      <h4 class="card-title" style=" text-align: center; color: #4f5467; ">
         title
      </h4>






          </div>
          </div>
          </div>


    @endsection
@section('scripts')

@endsection




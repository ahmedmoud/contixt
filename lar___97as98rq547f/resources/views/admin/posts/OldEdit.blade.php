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
         <a href="{{ url($current->slug) }}" target="_blank">{{ $current->title }}</a>
         <br/>
         <span>{{ $current->id }}</span>

      </h4>
<style>
.diffs img {
    max-width: 100%;
}
.high {
    background: #f3ee18;
    padding: 3px;
}
h3.heading {
    background: #4f5467;
    color: #fff;
    padding: 7px;
    font-family: 'DroidArabicKufiRegular' !important;margin-top:15px;
}
</style>
<div class="diffs">
@foreach( $diffs as $dif )
<div class="row">
<div class="col-md-6">
<h3 class="heading">{{ $diff[$dif] }} - {{ __('admin.old') }}</h3>
@if( $dif == 'image' )
    <img src="{{ url(Media::ClearifyAttach($old->{$dif}, 'max')) }}" />
@elseif( $dif == 'slug' )

<a >{{ urldecode($old->{$dif}) }}</a>
@else
{!! $old->{$dif} !!}
@endif
</div>
<div class="col-md-6">
<h3 class="heading"> {{ $diff[$dif] }} - {{ __('admin.current') }}</h3>
@if( $dif == 'image' )
    <img src="{{ url(Media::ClearifyAttach($current->{$dif}, 'max')) }}" />
@elseif( $dif == 'slug' )

<a target="_blank" href="{{ url($current->slug) }}">{{ urldecode($current->{$dif}) }}</a>
@else
{!! $current->{$dif} !!}
@endif

</div>
</div>
@endforeach
</div>


          </div>
          </div>
          </div>


    @endsection
@section('scripts')

@endsection




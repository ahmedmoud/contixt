@extends('admin.master')
@section('title', 'Admin Categories')
@section('styles')

    <link href="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
 
		<div>
            @can('create', 'posts')
			    <a href="{{ url('admin/posts/create') }}" class="btn btn-primary" style="margin: 10px;">إضافة منشور جديد</a>
            @endcan
			<br>
		</div>

		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
<form action="{{ url('admin/search-posts') }}">
<div class="row m-t-40">
    <div class="col-md-3">
        <input type="text" name="query" placeholder="ابحث هنا " value="{{ ( isset($_GET['query']) )? $_GET['query'] : ''  }}"/>
    </div>
    <div class="col-md-2">

        <select name="status">
            <option value='' > كافة الحالات</option>
            <option value="1" {{ ( isset($_GET['status']) && $_GET['status'] == 1 )? 'selected' : '' }}>منشور</option>
            <option value="2" {{ ( isset($_GET['status']) && $_GET['status'] == 2 )? 'selected' : '' }}>بإنتظار المراجعة</option>
            <option value="3" {{ ( isset($_GET['status']) && $_GET['status'] == 3 )? 'selected' : '' }}>مسودة</option>
        </select>
    </div>
     <div class="col-md-3">

        <select name="category">
        <option value='' >كاقة الأقسام </option>
            @foreach( $categories as $cat )
                <option @if( isset( $_GET['category'] ) && $_GET['category'] == $cat->id ) selected @endif value="{{ $cat->id }}">{{ $cat->name }} </option>
            @endforeach

        </select>

    </div>

    <div class="col-md-3">
        <select name="user">
        <option value=''>كافة الأعضاء </option>
            @foreach( $users as $user )
                <option @if( isset( $_GET['user'] ) && $_GET['user'] == $user->id ) selected @endif value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }} </option>
            @endforeach
        </select>
    </div>
<br/>
     <div class="example" style="margin-top:15px;">
            <div class="input-group">
                <input type="text" class="form-control mydatepicker" placeholder="تاريخ المقال" name="date" value="{{ ( isset($_GET['date']) )? $_GET['date'] : ''  }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="icon-calender"></i></span>
                </div>
            </div>
        </div>
</div>
    <button type="submit" class="btn btn-danger clearfix" style="float: none;margin: 20px auto;display: block;padding: 10px 44px;"> ابحث </button>
       </form>             
                </div>
@if( isset($posts) )
<p style="margin:auto; text-align:center;" >عدد النتائج : {{ $posts->total() }}</p>
               @include('admin.posts.loopTable');
@endif
		</div>		

@endsection
@section('scripts')
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
    </script>
@endsection
@extends('admin.master')
@section('content')
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<h4 class="card-title" style=" text-align: center; color: #4f5467; ">
تحويل الروابط
</h4>

@if( $errors->has('redirect') )
    هذا <a href="{{ url( old('fromURL') ) }}"> الرابط </a> تم تحويله من قبل  
@endif
@if( isset($Success) && $Success )
{{ $Success }}
@endif
<form class="form-horizontal m-t-40" method="POST" action="{{ url('/admin/redirection') }}"  >
@csrf @method('post')
<div class="form-group">
<label for="title">من *</label>
<div class="input-group mb-3">
<input required value="{{ old('fromURL') ? old('fromURL') : '' }}" style="direction:ltr;text-align:left;" onchange="this.value = decodeURI(this.value);" type="url" class=" form-control" placeholder="Redirect from this URL" name="fromURL">
</div>
</div>
<div class="form-group">
<label for="title">إلى *</label>
<div class="input-group mb-3">
<input required value="{{ old('toURL') ? old('toURL') : '' }}"  style="direction:ltr;text-align:left;" type="url" onchange="this.value = decodeURI(this.value);" class=" form-control" placeholder="Redirect to this URL" name="toURL">
</div>
</div>
<br>
<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
اضافة
</button>
</form>
</div>


<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
    <th>ID</th>
    <th>From</th>
    <th>To</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>

        @foreach( $redirections as $redt )
        <tr>
            <td>{{ $redt->id }}</td>
            <td><a target="_blank" href="{{ url($redt->fromURL) }}">{{ $redt->fromURL }}</a></td>
            <td><a target="_blank" href="{{ url($redt->toURL) }}">{{ $redt->toURL }}</a></td>
            <td><form onclick="return confirm('هل متأكدة من حذفك لهدا التحويل');" action="{{ url('/admin/redirection/'.$redt->id.'/delete') }}" style="display: inline;" method="post"> @csrf @method('post') <button type="submit" class="btn btn-danger">حذف</button></form></td>
        </tr>
        @endforeach

    </tbody>
</table>
{{ $redirections->render() }}
</div>
</div>
@endsection
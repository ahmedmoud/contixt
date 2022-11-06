@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')
<div>
        @if( isset($post) )
    <h3>تحديثات المقال : {{ $post->title }} </h3>
    <a href="{{ url('admin/future-updates/'.$post->id.'/new') }}" class="btn btn-primary" style="margin: 10px;">إضافة تحديث</a>
    @endif
</div>
        
		<div class="row">
            <div class="col-12"> 
                <div class="card">
                    <div class="card-body">
                    <div class="row m-t-40">
                    
                                </div>
 <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
<thead>
<tr>
<th>ID</th>
<th>الناشر</th>
@if( !isset($post) ) <th>المقال</th> @endif
<th>عنوان التحديث</th>
<th>تاريخ الجدولة</th>
<th>Action</th>
</tr>
</thead>
<tbody>
@foreach( $updates as $up )
<tr>
<td>{{ $up->id }}</td>
<td>{{ $up->name }}</td>
@if( !isset($post) ) <th><a target="_blank" href="{{ url($up->pslug) }}">{{ $up->ptitle }}</a></th> @endif
<td>{{ $up->title }}</td>
<td>{{ $up->date }}</td>
<td>
        <a href="{{ url('/admin/future-updates/'.$up->id.'/edit') }}" class="btn btn-info">
        تعديل
        </a>
        <form onclick="return confirm('هل متأكدة من حذفك لهدا التحديث؟');" action="{{ url('/admin/future-updates/'.$up->id.'/delete') }}" style="display: inline;" method="post"> @csrf <input type="hidden" name="_method" value="post"><button type="submit" class="btn btn-danger">حذف</button></form>
  
        @if( !isset($post) ) <a href="{{ url('/admin/future-updates/'.$up->pID) }}" class="btn btn-warning">تحديثات المقال</a>@endif
        </td>
</tr>
@endforeach
</tbody></table>
@if( isset($render) && $render )
{{ $updates->render() }}
@endif

                    </div>
                </div>
               
            </div>
		</div>		


@endsection
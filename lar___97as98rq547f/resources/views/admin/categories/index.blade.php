@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')
 
		<div>
			<a href="{{ url('admin/categories/create') }}" class="btn btn-primary" style="margin: 10px;">{{ __('admin.add_new_cat') }}</a>
			<br>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.cat_name') }}</th>
                                        <th>{{ __('admin.Parent') }}</th>
                                        <th>{{ __('admin.color') }}</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach($categories as $cat)
                                	<tr>
                                        <td><a target="_blank" href="{{ asset('/' . $cat->slug) }}">{{ $cat->name }}</a></td>
                                        <td>
                                        	@if($cat->parent)
                                        	{{ $cat->parent->name }}
                                        	@else
                                        	---
                                        	@endif
                                        </td>
                                         <td>
                                        	<div style="width:100px; height:30px; background-color:{{$cat->color}}">
                                        	</div>
                                        
                                        </td>
                                        <td>
                                        {!! $cat->activationForm( __('admin.disable')  , __('admin.enable') ) !!}
                                        	<a href="{{ url('admin/categories/'.$cat->id.'/edit') }}" class="btn btn-info">
                                        	{{ __('admin.edit') }}
                                        	</a>
                                        	<form onclick="return confirm('هل متأكد من حذف هذا القسم؟');" action="{{ url('admin/categories/'.$cat->id) }}" style="display: inline;" method="post">
                                        		@csrf
                                        		<input type="hidden" name="_method" value="DELETE" />
	                                        	<button type="submit" class="btn btn-danger"> {{ __('admin.remove') }}</button>
                                        	</form>
                                        </td>
                                	</tr>
                                	@endforeach

                                </tbody>
                            </table>
                        </div>
                        {!! $categories->render() !!}
                    </div>
                </div>
            </div>
		</div>		
@endsection
@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')

		<div>
			<a href="{{ url('admin/permissions/'. (@$role ?  $role->id . '/' : '') .'create') }}" class="btn btn-primary" style="margin: 10px;">تعديل / حذف / اضافة صلاحية</a>
			<br>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <select id="RateSelect" class="form-control">
                            @foreach($roles as $one)
                                @if(!isset($role))
                                    <option value="" disabled selected></option>
                                @endif
                                <option @if(isset($role) && $role->id == $one->id) selected @endif value="{{ $one->id }}"> {{ $one->name  }} </option>
                            @endforeach
                        </select>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>الفعل</th>
                                        <th>الجزء</th>
                                        <th>الوصف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($permissions)
                                	@foreach($permissions as $permission)
                                        @include('admin.permissions.permission', ['permission' => $permission, 'role' => $role])
                                	@endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
		</div>


@endsection

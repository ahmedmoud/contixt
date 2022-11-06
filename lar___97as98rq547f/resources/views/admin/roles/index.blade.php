@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')

		<div>
			<a href="{{ url('admin/roles/create') }}" class="btn btn-primary" style="margin: 10px;">إنشاء رتبة</a>
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
                                        <th>الاسم</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach($roles as $role)
                                	
                                        @include('admin.roles.role', ['role' => $role])
                                	@endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
		</div>


@endsection

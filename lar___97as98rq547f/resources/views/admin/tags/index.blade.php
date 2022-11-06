@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')

		<div>
			<a href="{{ url('admin/tags/create') }}" class="btn btn-primary" style="margin: 10px;">إنشاء وسم</a>
			<br>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive m-t-40">
							@if(isset($msg))
								<div class="alert alert-success text-center">{{ $msg }}</div>
							@endif
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
                                <tdead>
                                    <tr>

                                        <th>الاسم</th>
                                        <th>الرابط</th>
                                        <th></th>
                                    </tr>
                                </tdead>

                                <tbody>
                                	@foreach($tags as $tag)
                                        @include('admin.tags.tag', ['tag' => $tag])
                                	@endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
		</div>


@endsection

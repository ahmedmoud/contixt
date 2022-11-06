@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')
<style>
td i.fa-facebook, td i.fa-twitter{ color:#fff; width: 35px; height: 35px; text-align:center; margin:auto; display:block; line-height: 35px; font-size: 19px; } td i.fa-facebook{ background:#3b5999; } td i.fa-twitter{ background:#55acee; }
</style>
		<div>
			<a href="{{ route('users.create')  }}" class="btn btn-primary" style="margin: 10px;">{{ __('admin.add').' '.__('admin.user') }}</a>
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
                                        <th>{{ __('admin.name') }}</th>
                                        <th>{{ __('admin.username') }}</th>
                                        <th>{{ __('admin.email') }}</th>
                                        <th>{{ __('admin.role') }}</th>
                                        <th>Provider</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach($users as $user)
                                        @include('admin.users.user', ['user' => $user])
                                	@endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $users->render() !!}
                    </div>
                </div>

            </div>
		</div>


@endsection

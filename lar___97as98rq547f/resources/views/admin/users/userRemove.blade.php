@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')

		<div>
			<span class="btn btn-primary" style="margin: 10px;">{{ __('admin.remove_user') }}: <b>{{ $user->name }}</b></span>
			<br>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive m-t-40">
                        <form method="post" >
                        @csrf
<b>{{ __('admin.choose_admin_to_attach_current_user_arts') }}</b>
                            <select name="new_id">
                            @foreach( $users as $user )
                                <option value="{{ $user->id }}">{{ $user->name }} </option>
                            @endforeach
                            </select>

<button class="btn btn-danger" type="submit" >{{ __('admin.remove_user_and_move_posts') }}</button>
</form>
                        </div>
                    </div>
                </div>

            </div>
		</div>


@endsection

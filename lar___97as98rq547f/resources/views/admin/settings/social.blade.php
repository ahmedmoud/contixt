@extends('admin.master')

@section('content')

    <div class="container-fluid">
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(isset($changes))
                            <div class="alert alert-success">
                                <ul class="text-center list-unstyled">
                                    @foreach (session()->get('changes') as $msg)
                                        <li>{{ $msg }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ url('/admin/social') }}" method="POST">
                        
                            @csrf
                            @foreach( $socials as $k=>$sc )
                            <div class="form-group">
                                <label for="_HeaderAd">{{ $k }}</label>
                                <input name="{{ $k }}" type="text" class="form-control" id="title" value="{{ $sc }}">
                            </div>
                            @endforeach

                            <button class="btn btn-success" type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection

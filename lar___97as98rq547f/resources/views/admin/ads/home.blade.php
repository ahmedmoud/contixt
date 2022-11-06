@extends('admin.master')
@section('styles')
<link href="{{ asset('admin_panel/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
@endsection
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

<form action="{{ url('admin/siteAds/'.$data->page.'/'.$data->device) }}" method="POST">
@csrf

@foreach( $ads as $ad )
<div class="form-group">

    <input type="checkbox" name="{{ $ad->area }}[status]" @if( $ad->status == 1 ) checked @endif class="js-switch" data-color="#00c292" value="1"/>
    <label for="_{{ $ad->id }}">{{ $ad->title }}</label>

    <textarea name="{{ $ad->area }}[code]" id="_{{ $ad->id }}" cols="30" rows="5" class="form-control" style="direction: ltr;">{!! $ad->code !!}</textarea>
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
@section('scripts')
    <script src="{{ asset('admin_panel/switchery/dist/switchery.min.js') }}"></script>
    <script>
    $(function () {
            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });
        });
    </script>
@endsection
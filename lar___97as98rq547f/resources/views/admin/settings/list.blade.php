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
    @include('media::modal')
    @stack('media-styles')
    @stack('media-scripts')
    @php $slocale = \App::isLocale('en') ? 'en_' : ''; @endphp

                        <form action="{{ url('/admin/settings') }}" method="POST">
                            @csrf
                            <input type="hidden" name="method" value="POST">
                            <div class="form-group">
                                <label for="title">{{ __('admin.title') }}</label>
                                <input name="{{ $slocale }}title" type="text" class="form-control" id="title" value="{{ Setting::get($slocale.'title') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('admin.description') }}</label>
                                <textarea name="{{ $slocale }}description" id="description" cols="30" rows="5" class="form-control"> {{ Setting::get($slocale.'description') }} </textarea>
                            </div>
                            <div class="form-group">
                                <label for="head_code">{{ __('admin.head_code') }}</label>
                                <textarea style="direction:ltr; text-align:left;" name="{{ $slocale }}head_code" id="head_code" cols="30" rows="5" class="form-control"> {{ Setting::get($slocale.'head_code') }} </textarea>
                            </div>
                            <div class="form-group">
                                <label for="firstviewpostsIDs">First View Posts IDs</label>
                                <textarea style="text-align:left; direction:ltr;" name="{{ $slocale }}firstviewpostsIDs" id="firstviewpostsIDs" cols="30" rows="5" class="form-control"> {{ Setting::get($slocale.'firstviewpostsIDs') }} </textarea>
                            </div>
                            
                            <div class="form-group">
                                @include('media::btn',['Mid'=>'logo','Mtitle'=>'اللوجو', 'currentValues'=> Setting::get('logo')])
                            </div>
                            <div class="form-group">
                                @include('media::btn',['Mid'=>'favicon','Mtitle'=>'ايقونة المفضلة', 'currentValues'=> Setting::get('favicon')])
                            </div>
                            
                            <button class="btn btn-success" type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection

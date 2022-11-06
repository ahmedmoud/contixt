@extends('admin.master')
@section('styles')
<link href="{{ asset('admin_panel/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
@endsection
@section('content')


    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">Manage Ads</h4>

                              
                                <div class="">
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
                        </div>
                        </div>


                  
<ul class="nav nav-pills m-t-30 justify-content-end m-b-30">
@foreach( ['Home','Post','Category'] as $kk=>$page )
    @foreach( ['Desktop','Mobile'] as $key=>$device )
    <li class=" box bg-success text-center nav-item"> <a href="#{{ $page }}-{{ $device }}" class="nav-link @if( isset($_GET['page'],$_GET['device']) && $page == $_GET['page'] && $_GET['device'] == $device ) active @elseif( !isset($_GET['page'], $_GET['device']) && $kk== 0 && $key == 0 ) active @endif show" data-toggle="tab" aria-expanded="false">{{ $page.' '.$device }}</a> </li>
    @endforeach
@endforeach
</ul>
<style>
h2 i{ font-size: 20px; margin-right: 8px; } .nav-pills .nav-link { color: white; font-weight: bold; font-size: 15px; font-family: monospace; padding: 6px; } li.box { margin: 5px  auto; }
    </style>
<div class="tab-content br-n pn">
@foreach( ['Home','Post','Category'] as $kk=>$page )
    @foreach( ['Desktop','Mobile'] as $key=>$device )
    <div id="{{ $page }}-{{ $device }}" class="tab-pane 
    @if( isset($_GET['page'],$_GET['device']) && $page == $_GET['page'] && $_GET['device'] == $device ) active @elseif( !isset($_GET['page'], $_GET['device']) && $kk== 0 && $key == 0 ) active @endif show">
    <?PHP $ads = $data[$page][$device]->ads; ?>
    <h2 class="text-center">{{ $page }}  <i class="icon-{{ $device == 'Desktop' ? 'screen-desktop' : 'screen-smartphone' }}"></i>{{ $device }} </h2>
    <form action="{{ url('admin/siteAds/'.$page.'/'.$device) }}" method="POST">
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
    @endforeach
@endforeach
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
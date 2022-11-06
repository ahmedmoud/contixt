@extends('admin.master')
@section('title', 'Add Categories')

@section('styles')
        <link href="{{ asset('admin_panel/jquery-asColorPicker-master/css/asColorPicker.css') }}" rel="stylesheet" />

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">أقسام الموقع</h4>

<style>
ul.main > li {
    font-size: 16px;
    color: red;
    margin-bottom: 6px;
}
</style>
<ul class="main">
<?PHP

$used = [];

?>
@foreach( $output[0] as $parent )

    <li><a target="_blank" href="{{ url($parent->slug) }}">{{ $parent->name }}</a></li>
    @if( isset($output[$parent->id]) )
    <ul>
    @foreach( $output[$parent->id] as $cat )
            <li><a target="_blank" href="{{ url($cat->slug) }}">{{ $cat->name }}</a></li>
                @if( isset($output[$cat->id]) )
                <ul>
                @foreach( $output[$cat->id] as $ca )

                            <li><a target="_blank" href="{{ url($ca->slug) }}">{{ $ca->name }}</a></li>
                            @if( isset($output[$ca->id]) )
                            <ul>
                            @foreach( $output[$ca->id] as $c )
                            <li><a target="_blank" href="{{ url($c->slug) }}">{{ $c->name }}</a></li>

                                @if( isset($output[$c->id]) )
                                <ul>
                                @foreach( $output[$c->id] as $ce )
                                <li><a target="_blank" href="{{ url($ce->slug) }}">{{ $ce->name }}</a></li>
                                @endforeach
                                </ul>
                                @endif

                            @endforeach
                            </ul>
                            @endif

                @endforeach
                </ul>
                @endif


    @endforeach
    </ul>
    @endif


@endforeach

</ul>


                </div>
                </div>
                </div>
                </div>
@endsection
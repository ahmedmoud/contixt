@extends('admin.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
@include('admin.NativeAds.loopTable', ['ads'=>$ads])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
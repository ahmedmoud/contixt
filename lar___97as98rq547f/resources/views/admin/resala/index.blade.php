@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')
 
		<div>
            @can('create', 'posts')
			    <a href="{{ url('admin/posts/create') }}" class="btn btn-primary" style="margin: 10px;">إضافة منشور جديد</a>
            @endcan
			<br>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">


                    <div class="row m-t-40">

                    @if( $posts )
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card">
                                            <div class="box bg-info text-center">
                                                <h1 class="font-light text-white">{{ $posts->total() }}</h1>
                                                <h6 class="text-white">رسالة</h6>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- Column -->
                    @endif
                                </div>
                                       @include('admin.resala.loopTable');

                    </div>
                </div>
               
            </div>
		</div>		


@endsection
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
                    @if( $published ) 
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card">
                                            <a href="{{ url('/admin/search-posts?status=1') }}"><div class="box bg-success text-center">
                                                <h1 class="font-light text-white">{{ $published }}</h1>
                                                <h6 class="text-white"> {{ __('admin.post') }}</h6>
                                            </div></a>
                                        </div>
                                    </div>
                    @endif
                    @if( $pending )
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card"><a href="{{ url('/admin/search-posts?status=2') }}">
                                            <div class="box bg-primary text-center">
                                                <h1 class="font-light text-white">{{ $pending }}</h1>
                                                <h6 class="text-white">{{ __('admin.revision') }}</h6>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                    @endif
                    @if( $draft )
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card"><a href="{{ url('/admin/search-posts?status=3') }}">
                                            <div class="box bg-info text-center">
                                                <h1 class="font-light text-white">{{ $draft }}</h1>
                                                <h6 class="text-white">{{ __('admin.draft') }}</h6>
                                            </div></a>
                                            
                                        </div>
                                    </div>
                                    <!-- Column -->
                    @endif
                    
                    @if( $schedule )
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card"><a href="{{ url('/admin/search-posts?status=schedule') }}">
                                            <div class="box bg-success text-center">
                                                <h1 class="font-light text-white">{{ $schedule   }}</h1>
                                                <h6 class="text-white">{{ __('admin.schedule') }}</h6>
                                            </div></a>
                                            
                                        </div>
                                    </div>
                                    <!-- Column -->
                    @endif
                                   
                                </div>
                        
                                       @include('admin.posts.loopTable');

                    </div>
                </div>
               
            </div>
		</div>		


@endsection
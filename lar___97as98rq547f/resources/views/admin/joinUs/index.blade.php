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
                    @if( $joined ) 
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card">
                                         <div class="box bg-success text-center">
                                                <h1 class="font-light text-white">{{ $joined }}</h1>
                                                <h6 class="text-white"> منضم </h6>
                                            </div>
                                        </div>
                                    </div>
                    @endif
                    @if( $pending )
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card">
                                            <div class="box bg-primary text-center">
                                                <h1 class="font-light text-white">{{ $pending }}</h1>
                                                <h6 class="text-white">بانتظار المراجعه</h6>
                                            </div>
                                        </div>
                                    </div>
                    @endif

                    @if( $rejected )
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card">
                                            <div class="box bg-primary text-center">
                                                <h1 class="font-light text-white">{{ $rejected }}</h1>
                                                <h6 class="text-white">مرفوض</h6>
                                            </div>
                                        </div>
                                    </div>
                    @endif
                  
                        
                                   
                                </div>
                        
                                       @include('admin.joinUs.loopTable');

                    </div>
                </div>
               
            </div>
		</div>		


@endsection
@extends('layouts.master')

@section('content')

<!--content-->
    <section class="index-content">
        <div class="container">
            <div class="row">
                <!-- right-side-->
                <div class="col-xs-12">
                    <ol class="breadcrumb" style=" margin-bottom: 7px; ">
                          <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li>
                          <li class="breadcrumb-item active"><a href="#">المفضلة</a></li>
                    </ol>
	                @if($posts->count())
		                @foreach($posts as $post)
                        <div class="col-md-4">
		                    	@include('layouts.templates.components.post2',['post'=>$post])
		                </div>
                        @endforeach
	                @else
	                	<div style="margin:150px;">
	                		<h4>لا توجد لديك منشورات مفضلة بعد </h4>
	                	</div>
	                @endif
                </div>
            </div>
{!! $posts->render() !!}

        </div>
    </section>

@endsection
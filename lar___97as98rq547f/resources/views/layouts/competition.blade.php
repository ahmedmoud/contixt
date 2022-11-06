@extends('layouts.master')

@section('title', $post->title)
@section('content')

<!--content-->
    <section class="">
        <div class="">            
               <div class="imgy" style="background:url(https://www.setaat.com/images/opt%20001.jpg);width:  100%;min-height: 400px;/* background-attachment:  fixed; */background-size: cover;background-repeat:  no-repeat;width:;background-position: 0;position:relative;margin:  auto;max-width:  1352px;">
                
                </div>

                {{-- <img src="{{ Media::ClearifyAttach($post->Murl, 'max') }}" class="img-responsive compimg" alt="{{ $post->title }}"> --}}
<div style="position:relative">

<h2 class="text-center" style=" border-bottom: 2px solid #b3adaf; max-width: 700px; margin: auto; text-align: center; padding-bottom: 7px; padding-top: 18px; color: #635e5e;margin-bottom:15px; ">خطوات الإشتراك</h2>

           
           
            <div class="container">
                {!! $post->content !!}
            </div>
                <a class="btn btn-danger subbtn">اشتركي الآن</a> 
</div>               
            </div>
        </div>
    </section>
    

@endsection
@section('cScripts')

<script>
    $('.subbtn').click(function(){
        @if( !Auth::check() || !Auth::user()->id )
             alert('يرجى تسجيل الدخول أولاً');
             $('#myModal2').modal('show');
             return false;
        @else
            window.location.href= '{{ url("/competition/".$post->slug."/subscribe") }}';

        @endif
    });
</script>

@endsection
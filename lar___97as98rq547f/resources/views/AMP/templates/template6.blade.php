<section class="recent col-md-{{ $widget->content->width }} {{ '___'.$widget->id }} nopadding"> 
<div class="title-header"> @if( isset($the_cat) && $the_cat ) <h4><a class="nostylea" href="{{ url($the_cat->slug) }}">{{ $the_cat->name }}</a></h4> @else <h4>{{ $widget->title }} <h4> @endif  </div>  
    <amp-carousel class="carousel1" layout="responsive" height="400" width="500" type="slides">

        @foreach( $posts as $post )

@php
    list($width,$height) = getimagesize( Media::ClearifyAttach($post->Murl,'medium') );
@endphp

<div class="slide">
            <amp-img  layout="responsive" width="{{ $width }}" height="{{ $height }}"  src="{{ url( Media::ClearifyAttach($post->Murl,   'medium' ) )  }}" alt="{{ $post->title }}" ></amp-img>
            <h4 >{{ $post->title }}</h4>
</div>


@endforeach

</amp-carousel>

</section>
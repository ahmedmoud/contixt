<div class="col-md-{{ $widget->content->width }}"> <div class="love-life clearfix {{ '___'.$widget->id }}"> <div class="title-header"> @if( isset($the_cat) && $the_cat ) <h4><a class="nostylea" href="{{ url($the_cat->slug) }}">{{ $the_cat->name }}</a></h4> @else <h4>{{ $widget->title }} <h4> @endif  @if( $widget->content->postsOrcategories == 'cats' && $posts[0]->category->count() > 0 ) <div class="childrencats"> @foreach( $posts[0]->category as $childCat )  <a href="{{ url($childCat->slug) }}">{{ $childCat->name }}</a> @endforeach </div> @endif </div>  @php $cpo = $posts->count(); @endphp <div><ul class="customUL"> @foreach($posts as $key => $post) <li class="clearfix"><a href="{{ url($post->slug) }}">
@php
    list($width,$height) = getimagesize( Media::ClearifyAttach($post->Murl,'medium') );
@endphp
<amp-img width="{{ $width }}" height="{{ $height }}" layout="responsive" src="{{ asset(Media::ClearifyAttach($post->Murl, 'tiny')) }}" alt="{{ $post->title }}" ></amp-img> <h5>{{ $post->title }}</h5> </a></li>  @endforeach </ul> </div>  </div>  </div>
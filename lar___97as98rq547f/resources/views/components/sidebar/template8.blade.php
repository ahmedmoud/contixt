<div class="col-md-{{ $widget->content->width }}">
    <div class="love-life life-box  {{ '___'.$widget->id }}">
        <div class="title-header"> @if( isset($the_cat) && $the_cat ) <h4><a class="nostylea" href="{{ url($the_cat->slug) }}">{{
                    $the_cat->name }}</a></h4> @else <h4>{{ $widget->title }} <h4> @endif @if(
                    $widget->content->postsOrcategories == 'cats' && $posts[0]->category->count() > 0 ) <div class="childrencats">
                        @foreach( $posts[0]->category as $childCat ) <a href="{{ url($childCat->slug) }}">{{
                            $childCat->name }}</a> @endforeach </div> @endif </div>
     @foreach($posts->chunk(4) as $collection) <div> @foreach($collection as $key => $post) 
        
        @if($key == count($collection)-1 ) 

        <div class="c-slide">
                <div class="c-overlay"></div>
                <div class="slide-img"> <img src="{{ asset(Media::ClearifyAttach($post->Murl, 'medium')) }}" class=" img-responsive d-block w-100"
                        alt="{{ $post->title }}"> </div>
                <div class="c-caption"> <button class="btn  {{ '__'.$widget->id }}">{{ $post->cname }}</button>
                    <h3><a href="{{ url($post->slug) }}">{{ $post->title }}</a></h3>
                </div>
            </div> 
            
            @else 
            
            @php $looped = 1; @endphp @if($looped == 1) @php $looped++; @endphp <ul class="list-ul">
                @endif <a href="{{ url($post->slug) }}">
                    <li>
                        <div class="list-ul-img"> <img src="{{ asset(Media::ClearifyAttach($post->Murl, 'tiny')) }}"
                                alt="{{ $post->title }}" /> </div>
                        <h5>{{ $post->title }}</h5>
                    </li>
                </a> @if($looped == 3) </ul> @endif 
                
                @endif 
                
                @endforeach </div>
                
                @endforeach
    </div>
</div>
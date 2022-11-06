<div class="col-md-{{ $widget->content->width }} nopadding">
<div class="widget">
        <div class="section-heading heading-dark">
            <h3 class="item-heading">{{ $widget->title }}</h3>
        </div>
        <div class="widget-latest">
            <ul class="block-list">
                    @foreach($posts as $key => $post) 
                <li class="single-item">
                    <div class="item-img">
                            <a href="{{ url($post->slug) }}"> <img src="{{ Media::ClearifyAttach($post->Murl, 'tiny')}}" alt="{{ $post->title }}" />   </a>
                        <div class="count-number">1</div>
                    </div>
                    <div class="item-content">
                        <div class="item-ctg">{{ $post->cname }}</div>
                        <h4 class="item-title"><a href="{{ url($post->slug) }}">{{ $post->title }}</a></h4>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div> 
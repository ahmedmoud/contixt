<div class="col-md-{{ $widget->content->width }} nopadding">
    <div class="widget">
        <div class="section-heading heading-dark">
            <h3 class="item-heading">{{ $widget->title }}</h3>
        </div>
        <div class="widget-featured-feed">
            <div class="rc-carousel nav-control-layout1" data-loop="true" data-items="5"
                data-margin="5" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="700"
                data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1"
                data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="1"
                data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="1"
                data-r-small-nav="true" data-r-small-dots="false" data-r-medium="1"
                data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="4"
                data-r-large-nav="true" data-r-large-dots="false" data-r-extra-large="3"
                data-r-extra-large-nav="true" data-r-extra-large-dots="false">

@foreach( $posts as $post ) 
                <div class="featured-box-layout1">
                    <div class="item-img">
                        <img src="{{ Media::ClearifyAttach($post->Murl, 'medium')}}" alt="{{ $post->title }}"  class="img-fluid">
                    </div>
                    <div class="item-content">
                        <span class="ctg-name">{{ $post->cname }}</span>
                        <h4 class="item-title"><a href="{{ url($post->slug) }}">{{ $post->title }}</a></h4>
                    </div>
                </div>
@endforeach
            </div>
        </div>
    </div>
</div>
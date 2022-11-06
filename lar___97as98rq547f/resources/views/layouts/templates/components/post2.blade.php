<div class="featured-box-layout1">
    <div class="item-img">
        <img src="{{ Media::ClearifyAttach($post->Murl, 'medium')}}" alt="{{ $post->title }}"  class="img-fluid">
    </div>
    <div class="item-content">
        <span class="ctg-name">{{ $post->cname }}</span>
        <h4 class="item-title"><a href="{{ url($post->slug) }}">{{ $post->title }}</a></h4>
    </div>
</div>
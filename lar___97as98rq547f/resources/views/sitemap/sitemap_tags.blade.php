<?='<?xml';?> version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($tags as $tag)
@if( empty(trim($tag->name)) )  @continue  @endif
<url><loc>{{url('/tag/'. str_replace(' ','-', $tag->name) )}}</loc></url>
@endforeach
</urlset>
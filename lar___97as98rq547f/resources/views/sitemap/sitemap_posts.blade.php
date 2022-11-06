<?='<?xml';?> version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

@foreach($posts as $post)<url><loc>{{url('/'.$post->slug)}}</loc>
    <lastmod>{{ Carbon\Carbon::parse(  $post->date > $post->updated_at && $post->date < \Carbon\Carbon::now()?  $post->date : $post->updated_at )->tz('UTC')->toAtomString()  }}</lastmod>
<priority>1</priority></url>@endforeach
</urlset>
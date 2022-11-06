<?='<?xml';?> version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach( range(1, $tags) as $tag)
<sitemap><loc>{{url('sitemap/tags_page?page='.$tag)}}</loc></sitemap>
@endforeach   
</sitemapindex>
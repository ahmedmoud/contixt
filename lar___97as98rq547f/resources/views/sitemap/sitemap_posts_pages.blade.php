<?='<?xml';?> version="1.0" encoding="UTF-8"?>
   <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach( range(1, $posts) as $post)
   <sitemap>
      <loc>{{url('sitemap/posts_page?page='.$post)}}</loc>
   </sitemap>
@endforeach   
 </sitemapindex>
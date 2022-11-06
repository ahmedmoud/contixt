<?='<?xml';?> version="1.0" encoding="UTF-8"?>
   <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach( range(1, $categories) as $category)
   <sitemap>
      <loc>{{url('sitemap/categories_page?page='.$category)}}</loc>
   </sitemap>
@endforeach   
 </sitemapindex>
<?='<?xml';?> version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

@foreach($pages as $key=>$page)<url><loc>{{ $page }}</loc><priority>{{ $key > 0 ? '0.6' : 1 }}</priority></url>@endforeach
</urlset>
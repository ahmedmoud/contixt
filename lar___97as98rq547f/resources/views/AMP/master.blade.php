<!doctype html>
<html dir="rtl" amp lang="{{ APP::getLocale() }}">
@include('AMP.parts.head')
  <body>
@include('AMP.parts.header')

@yield('content')

<?PHP
$footer__ = Cache::remember('AMP_footer_'.\App::getLocale(), 60*24, function() {
    return View::make('AMP.parts.footer')->render();
});

echo $footer__;
// @include('AMP.parts.footer')
?>

  </body>
</html>
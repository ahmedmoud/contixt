@include('layouts.parts.head')
@include('layouts.parts.navtop')
<?PHP

 $is_mobile = Mobile::isMobile() ? 'MOB___' : 'DESK___';
  
$header__ = Cache::remember('header__part_'.$is_mobile.\App::getLocale(), 60*24, function() {
$a = View::make('layouts.parts.header')->render();
$b =  View::make('layouts.parts.menu')->render();

return $a.$b;

});
 
//@include('layouts.parts.header')
//@include('layouts.parts.menu')


echo $header__;
// @include('layouts.parts.footer')
?>
@yield('content')
<?PHP
$footer__ = Cache::remember('footer_'.\App::getLocale(), 60*24, function() {
    return View::make('layouts.parts.footer')->render();
});

echo $footer__;
// @include('layouts.parts.footer')
?>

@include('layouts.parts.foot')
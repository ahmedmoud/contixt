@php $slocale = \App::isLocale('en') ? 'en_' : '' ; @endphp
 <section class="footer"> <div class="container"> <div class="row"> <div class="col-md-3"> <p class="h4">{{ __('trans.latest_arts') }}</p> <ul class="footer-menu"> @foreach( $recentPosts as $rpo ) <li><a href="{{ $rpo->slug }}">{{ $rpo->title }}</a></li> @endforeach </ul>  </div> <div class="col-md-3"> <p class="h4">{{ __('trans.important_cats') }}</p>
 
 <ul class="footer-menu">
     

 @foreach( $topCats as $cat )
 <li><a href="{{ url($cat->slug) }}">{{ $cat->name }}</a></li>
 @endforeach
 </ul>
 
 
 </div>  <div class="col-md-3">
      <p class="h4">{{ __('trans.important_links') }}</p> 
 <ul class="footer-menu"> 
 @foreach( $pages as $key=>$page )
 <li><a href="{{ url($key) }}">{{ $page }}</a></li>
 @endforeach
 </ul> 
 </div>
 <div class="col-md-3"> <amp-img height="104" width="256" layout="responsive"  src="{{ env('MAX_CDN_DOMAIN') }}/assets/images/logo.png" alt="ستات دوت كوم"  class="img-responsive"></amp-img> <p><a href="{{ url('/') }}">Setaat</a> </p> </ul>  <p class="socials"> @foreach( $socials as $sk=>$sc ) @if( $sc && !empty($sc) && $sc != null ) <a rel="nofollow" target="_blank" href="{{ $sc }}"><amp-img width="45" height="40" src="{{ env('MAX_CDN_DOMAIN') }}/assets/images/icons/{{ $sk }}.png" alt="ستات دوت كوم {{ $sk }}" ></amp-img></a> @endif @endforeach         </p> </div>         </div> <div class="navbottom">
 @if( App::isLocale('ar') ) 
 <p class="copyrights">جميع الحقوق محفوظة &copy; 2019 <a href="{{ url('/') }}">ستات دوت كوم</a></p> 
 @else
 <p class="copyrights">All Rights Reserved &copy; 2019 <a href="{{ url('/') }}">Setaat.com</a></p> 
 @endif
 <p class="developer">Managed & Developed By <a style="color: rgba(77, 56, 144, 0.89)" rel="nofollow" target="_blank" href="http://www.godigitaleg.com/">Go Digital</a></p> </div> </div> </section>
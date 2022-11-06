@extends('layouts.master') @section('title', 'نتائج البحث عن '.@$_GET['q']) @section('content')  <!--content--> <section class="index-content"> <div class="container"> <div class="row"> <!-- right-side--> <div class="col-md-8 col-xs-12"> <ol class="breadcrumb"> <li class="breadcrumb-item"><a href="{{ url('/')}}">الرئيسية</a></li> <li class="breadcrumb-item active"><a href="#">نتائج ا البحث عن {{  @$_GET['q'] }} </a></li> </ol> <div class="beauty-box big"> <div class="title-header"> <h4>نتائج البحث عن {{  @$_GET['q'] }}</h4>  </div>

<style>
    .gsc-control-cse .gs-spelling, .gsc-control-cse .gs-result .gs-title, .gsc-control-cse .gs-result .gs-title * {
    font-size: 20px !important;
    font-family: 'DroidArabicKufiRegular';
    text-decoration:none;
    height: 27px;
}
.gs-webResult .gs-snippet, .gs-imageResult .gs-snippet, .gs-fileFormatType {
    font-family: 'DroidArabicKufiRegular';
}
.gsc-webResult.gsc-result, .gsc-results .gsc-imageResult {
    border-color: #FFFFFF;
    background-color: #f5f5f5;
    border-right: 2px solid #ed106e;
    margin-bottom: 7px;
    padding-right: 6px;
}
</style>
<!-- <script>
  (function() {
    var cx = '003298475927232807653:fgc4c8_uqso';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search> -->


<script src="https://www.google.com/cse/api/partner-pub-2036644403902115/cse/9824353747/queries/js?oe=UTF-8&amp;callback=(new+PopularQueryRenderer(document.getElementById(%22queries%22))).render"></script>
<!-- 
<script>

  (function() {
    var cx = 'partner-pub-2036644403902115:9824353747';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
    
  })();
</script>
<gcse:search></gcse:search> -->


<div id="test"></div>

<script>


function arPagination(){
  console.log('arpagination', $('div.gsc-cursor-page').length );
  var ar_nums = ["٠","١","٢","٣","٤","٥","٦","٧","٨","٩"];
  $('div.gsc-cursor-page').each(function(){
for( var x = 0; x<10; x++){
	$(this).html( $(this).html().replace(x, ar_nums[x]) );
}
});
}

var myCallback = function() {
  
  if (document.readyState == 'complete') {
    google.search.cse.element.render(
        {
          div: "test",
          tag: 'search'
         });
  } else {
    google.setOnLoadCallback(function() {
        google.search.cse.element.render(
            {
              div: "test",
              tag: 'search'
            });
           
    }, true);
  }

};


window.__gcse = {
  parsetags: 'explicit',
  callback: myCallback
};

(function() {
  var cx = 'partner-pub-2036644403902115:9824353747';
  var gcse = document.createElement('script'); gcse.type = 'text/javascript';
  gcse.async = true;
  gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
})();
</script>



<?PHP /* ?>
@if($results->count()) @foreach($results as $post) <div class="col-md-6"> @include('layouts.templates.components.post2',['post'=>$post]) </div> @endforeach {!! $results->render() !!} @else <div style="margin:100px; text-align: center;"> <p>عفوا لا توجد نتائج مماثلة</p> </div> 
@endif
<?PHP */ ?>
</div>
</div>  <!--left side --> @if( !Mobile::isMobile() ) <!--left side --> <div class="col-md-4 col-sm-12"> <div class="left-side"> @if(Sidebar::hasWidgets(Setting::get('category-sidebar'))) @foreach(Sidebar::widgets(Setting::get('category-sidebar')) as $widget) {!!  Sidebar::render($widget) !!} @endforeach @endif </div>
</div>   @endif 
</div>

</div> </section>   @endsection
@section('cScripts')
<script>
setInterval(() => {
  arPagination();
}, 2000);
</script>
@endsection
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/jquery-3.3.1.min.js"></script>
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/popper.min.js"></script>
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/bootstrap.min.js"></script>
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/plugins.js"></script>
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/owl.carousel.min.js"></script>
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/smoothscroll.min.js"></script>
<script src="{{ env('MAX_CDN_DOMAIN').'/des/js/theia-sticky-sidebar.min.js' }}"></script>
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/main.js"></script>
<noscript>
<style type="text/css">
        * { display:none !important; opacity: 0 !important }
    </style>
<div class="noscriptmsg">
    You don't have javascript enabled.  Good luck with that.
    </div>      </noscript>
@yield('cScripts')</body></html>
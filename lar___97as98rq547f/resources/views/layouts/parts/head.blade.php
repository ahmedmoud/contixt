<!doctype html><html lang="{{ App::getLocale() }}" dir="rtl" ><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="csrf-token" content="{{ csrf_token() }}"><title>@yield('title')</title><meta name="description" content="@yield('description')"><meta name="theme-color" content="#ec106e">
<meta name="robots" content="noindex">
<link rel="shortcut icon" type="image/x-icon" href="{{ env('MAX_CDN_DOMAIN') }}/assets/3.png"><style> @font-face { font-family: 'DroidArabicKufiBold'; src: url('{{ env('MAX_CDN_DOMAIN') }}/assets/fonts/droid/DroidArabicKufiBold.ttf') format('truetype'); font-weight: bold; font-style: normal; } @font-face { font-family: 'DroidArabicKufiRegular'; src: url('{{ env('MAX_CDN_DOMAIN') }}/assets/fonts/droid/DroidArabicKufiRegular.ttf') format('truetype'); font-weight: normal; font-style: normal; } </style>
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/normalize.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/main.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/animate.min.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/fontawesome-all.min.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/fonts/flaticon.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/owl.carousel.min.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/style.css">
<script src="{{ env('MAX_CDN_DOMAIN') }}/des/js/modernizr-3.6.0.min.js"></script>
@if( App::isLocale('ar') )
<link rel="stylesheet" type="text/css" href="{{ env('MAX_CDN_DOMAIN') }}/des/css/style_ar.css?ver=1.1">
@endif
<link rel='stylesheet' type='text/css'  href='//fonts.googleapis.com/earlyaccess/notokufiarabic' />

@php $slocale = \App::isLocale('ar') ? '' : 'en_'; @endphp
{!! Setting::get($slocale.'head_code') !!}
@if( !isset($post) || 
    ( isset($post) &&  ( !in_array($post->id , $BlockAdsenseAdsPosts )  && !str_contains($post->title , $BlockAdsenseAdsPostsKewords )  )   ) )
@if( !isset($blockAdsense) || ( isset($blockAdsense) &&  !$blockAdsense ) )
 {{-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> --}}
 @endif 
 @endif
 <!-- Global site tag (gtag.js) - Google Analytics --> <script async src="https://www.googletagmanager.com/gtag/js?id=UA-29789881-21"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-29789881-21'); </script>
</head><body class="{{ Route::currentRouteName() == 'home' ? 'home' : '' }}" ><div id="wrapper" class="wrapper">

<!DOCTYPE html>
<html lang="en" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <title>Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex" />
    @yield('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/admin.css') }}?ver=1.1" rel="stylesheet">
    @if( App::isLocale('ar') )
    <link href="{{ asset('css/admin-rtl.css') }}?ver=1.1" rel="stylesheet">
    @endif
 
 <style>.form-group input[type="radio"] { margin: 0px 8px; }</style>
    <!-- Dashboard 1 Page CSS -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   
<script>
var Main_URL = "{{ url('/') }}";
</script>
</head>

<body class="skin-default fixed-layout mini-sidebar">


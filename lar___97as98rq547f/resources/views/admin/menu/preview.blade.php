<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Menu Display Sample - Easy Menu Manager</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="{{ url('admin_panel/assets/menu/design') }}/css/sample.css">
<link rel="stylesheet" type="text/css" href="{{ url('admin_panel/assets/menu/design') }}/css/menu.css">
{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 --}}
 <script src="{{url('admin_panel/asset/design')}}/js/jquery-1.9.1.min.js"></script>
<script>
        var base_url = '{{ url('/') }}';

$(function() {
	$('.vertical li:has(ul)').addClass('parent');
	$('.horizontal li:has(ul)').addClass('parent');
});
</script>
</head>
<body>
<div id="wrapper">

{!! $menu !!}

<h3>with Class</h3>

<form  id="form-menu" method="POST" action="{{ url('admin/menu/preview_css/'.$group_id) }}">
	<input type="text" name="attr">
	<button type="submit" class="button green small" id="btn-save-menu">show</button>
</form>

</div>
</body>
</html>


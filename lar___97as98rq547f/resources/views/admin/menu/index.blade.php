<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Menu Editor</title>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="{{url('admin_panel/assets/menu/design')}}/css/style.css">
<!--[if lte IE 8]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

        <link href="{{ asset('admin_panel/jquery-asColorPicker-master/css/asColorPicker.css') }}" rel="stylesheet" />



<script src="{{url('admin_panel/assets/menu/design')}}/js/jquery-1.9.1.min.js"></script>
<script src="{{url('admin_panel/assets/menu/design')}}/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="{{url('admin_panel/assets/menu/design')}}/js/jquery.mjs.nestedSortable.js"></script>
<script src="{{url('admin_panel/assets/menu/design')}}/js/menu.js"></script>
<script >
	var current_group_id = {{  $group_id }};
        var base_url = '{{ url('/') }}/';
</script>




</head>
<body>
	<div id="wrapper">
		<header>
			<h1><a href="{{url('/')}}">Menu Editor</a></h1>
			<div id="link">
				<a class="button red" href="{{ url('admin/posts') }}" >Back To Admin</a>
			</div>
		</header>
		<div id="content">
			<div id="main">
				<ul id="menu-group">
					 @foreach ($menu_groups as $menu_group)
					<li id="group-{{ $menu_group->id }}">
						<a href="{{ url('admin/menu/' . $menu_group->id) }}">
							{{ $menu_group->title }}
						</a>
					</li>
					@endforeach
					<li id="add-group"><a href="{{ url('admin/menu_group_add') }}" title="Add New Menu">+</a></li>
						
				</ul>
				<div class="clear"></div>

				<form  id="form-menu" method="POST" action="{{ url('admin/menu/update/') }}">
					<div class="ns-row" id="ns-header">
						<div class="ns-actions">Actions</div>
						<div class="ns-class">Class</div>
						<div class="ns-url">URL</div>
						<div class="ns-title">Title</div>
					</div>
					
						{!! $data['menu_ul'] !!}
					</div>
					
					<div id="ns-footer">
						<button type="submit" class="button green small" id="btn-save-menu">Save Menu</button>
					</div>
				</form>
			</div>

			
			<aside>

               
				<section class="box">
					<h2>Add To Menu</h2>
					<div>
						<form id="" method="post" action="{{ url('admin/menu/add_to_menu/') }}">
                            @csrf
							<p>
								<label for="menu-title">Title</label>
								<input type="text" name="title" id="menu-title">
							</p>
							<p id="state">
								
							</p>
							<p>
								<label for="menu-url">Use Category instead</label>
								<input id="use-category" type="checkbox" name="use-category">
							</p>
							<p>
								<label for="menu-color">Color</label>
                            <!--<input class="form-control" name="color" type="color"  value="#ff0000" id="menu-color">-->
                                                                        <input type="text" class="colorpicker form-control" value="#7ab2fa" name="color"/> </div>

							</p>
							
							<p>
								<label for="menu-class">Class</label>
								<input type="text" name="class" id="menu-class">
							</p>
							<p class="buttons">
								<input type="hidden" name="group_id" value="{{ $group_id }}">
								<button id="" type="submit" class="button green small">Add Menu Item</button>
							</p>
						</form>
					</div>
				</section>
  
			</aside>
			<div class="clear"></div>
		</div>
		
	</div>
	<div id="loading">
		<img src="{{asset('admin_panel/assets/menu/design')}}/images/ajax-loader.gif" alt="Loading">
		Processing...
	</div>
	<script>
		var useCategory = $('#use-category');
		var atFirst = true;
		var initVal = true;
		$(document).on('ready', setState);
		useCategory.on('change', setState);
		function setState(){
			if(atFirst){
				useCategory.prop('checked', initVal);
				setOutput(initVal);
			}else{
				setTimeout(setOutput(useCategory.prop('checked')), 300);				
			}
		}
		
		function setOutput(state = false){
			var output = '';
			$('#state').slideUp();
			setTimeout(function(){
				if(state){
					output += '<label for="menu-category">Category</label>';
					output += '<select name="category">';
					getCategories().done(function(categories){
						for(category in categories){
							output += '<option value="' + categories[category].id + '">' + categories[category].name + '</option>';
						}
						output += '</select>';
						$('#state').html(output);
						setTimeout(function(){
							$('#state').slideDown();
							if(atFirst){
								atFirst = false;
							}
						}, 300);	
					});		
			}else{
				output += '<label for="menu-url">URL</label>';
				output += '<input type="text" name="url" id="menu-url">';
				$('#state').css({display: 'none'});
				$('#state').html(output);
				setTimeout(function(){
					$('#state').slideDown();
					if(atFirst){		
						atFirst = false;
					}
				}, 600);
			}
			}, 300);
			
		}
		function getCategories(){
			return $.ajax({
				url: "{{ url('/admin/categories/get') }}",
				method: 'get'
			});
		}		
	</script>
	
	

    <script src="{{ asset('admin_panel/jquery-asColorPicker-master/libs/jquery-asColor.js') }}"></script>
    <script src="{{ asset('admin_panel/jquery-asColorPicker-master/libs/jquery-asGradient.js') }}"></script>
    <script src="{{ asset('admin_panel/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js') }}"></script>

	<script>
	    
	     // Colorpicker
    $(".colorpicker").asColorPicker();
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });

	    
	</script>
	
	
	
	
</body>
</html>
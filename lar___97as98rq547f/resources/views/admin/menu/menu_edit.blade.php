
			<div id="edit">
				<div id="edit-popup"> 
					<h2>Edit Menu Item</h2>
					<form method="post" action="">
						<p>
							<label for="edit-menu-title">Title</label>
							<input type="text" name="title" id="edit-menu-title" value="{{ $data->title }}">
						</p>
						<p>
							<label for="edit-menu-url">URL</label>
							<input type="text" name="url" id="edit-menu-url" value="{{ $data->url }}">
						</p>
						<p>
								<label for="menu-color">Use Category instead</label>
                            <!--<input class="form-control" name="color" type="color"  value="{{ $data->color }}" id="menu-color">-->
                                                                                                    <input type="text" class="colorpicker form-control" value="{{ $data->color }}" id="menu-color"name="color"  /> </div>

							</p>
						<p>
							<label for="edit-menu-class">Class</label>
							<input type="text" name="class" id="edit-menu-class" value="{{ $data->class }}">
						</p>

					</form>

					</div>
				</div>

		<!-- end div edit -->
		
			<script>
	    
	     // Colorpicker
    $(".colorpicker").asColorPicker();
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });

	    
	</script>
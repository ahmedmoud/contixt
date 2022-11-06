		<h2>Add New Menu</h2>
		<form method="post" action="{{ url('admin/menu_group_add') }}">
			{{ csrf_field() }}
			<p>
				<label for="menu-group-title">Title</label>
				<input type="text" name="title" id="menu-group-title">
			</p>
			<button type="submit" class="button green small">save</button>
			<button type="cancel" class="button red small">cancel</button>
		</form>
	
<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-plus color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<p><b>Notes:</b></p>
		<p>Check google icon <a href="https://fonts.google.com/icons?selected=Material+Symbols+Outlined:settings:FILL@0;wght@400;GRAD@0;opsz@48" target="_blank">here</a>. Example: celebration</p>
		<p>Check font awesome icon <a href="https://fontawesome.com/search?o=r&m=free" target="_blank">here</a>. Example: fa-regular fa-thumbs-up</p>
		<p>For fontawesome icon, not all styles can be used because we are using free version.</p>
		<hr>
		<form id="addsidebar-form" enctype="multipart/form-data">
			<div style="margin-top: 10px;">
				<p class="_tr5">Name</p>
				<div class="vByg5">
					<input name="sidebar_name" type="text" required>
				</div>
			</div>
			<div style="margin-top: 10px;">
				<p class="_tr5">Sidebar Type</p>
				<select name="sidebar_type" class="_p4s8 select2" style="width: 500px;" required>
					{{SIDEBAR_TYPES}}
				</select>
			</div>
			<div style="margin-top: 10px;">
				<p class="_tr5">Sidebar Category/Tags</p>
				<select name="sidebar_category_tags" class="_p4s8 select2" style="width: 500px;">
					{{SIDEBAR_CATEGORY_TAGS}}
				</select>
			</div>
			<div style="margin-top: 10px;">
				<p class="_tr5">Custom Link</p>
				<div class="vByg5">
					<input name="sidebar_custom_link" type="text">
				</div>
			</div>
			<div style="margin-top: 10px;">
				<p class="_tr5">Icon</p>
				<div class="vByg5">
					<input name="sidebar_icon" type="text">
				</div>
			</div>
			<div style="margin-top: 10px;">
				<p class="_tr5">Ordering</p>
				<div class="vByg5">
					<input name="sidebar_ordering" type="number" min="0">
				</div>
			</div>
			<button type="submit"  id="addsidebar-btn" class="btn-p btn-p1">
				<i class="fa fa-plus icon-middle"></i>
				@add@
			</button>
		</form>
	</div>
	<div class="_5e4">
	<ul class="sidebars-list scroll-custom">
		<li class="__mc-header g-d5 _j4 categories-item">
		<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_sidebar-type">Name</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_sidebar-type">Type</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_sidebar-category-tags">Category/Tags</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_sidebar-category-tags">Custom Link</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_sidebar-category-tags">Icon</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_sidebar-category-tags">Ordering</div>
			<div>
				Action
			</div>
		</li>
		{{VIEW_SIDEBAR_LIST}}
	</ul>
	</div>
</div>
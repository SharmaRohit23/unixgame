<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-plus color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<form id="addslider-form" enctype="multipart/form-data">
			<div style="margin-top: 10px;">
				<p class="_tr5">Slider Type</p>
				<select name="slider_type" class="_p4s8 select2" style="width: 500px;">
					{{SLIDER_TYPES}}
				</select>
			</div>
			<div style="margin-top: 10px;">
				<p class="_tr5">Slider Category/Tags</p>
				<select name="slider_category_tags" class="_p4s8 select2" style="width: 500px;">
					{{SLIDER_CATEGORY_TAGS}}
				</select>
			</div>
			<div style="margin-top: 10px;">
				<p class="_tr5">Ordering</p>
				<div class="vByg5">
					<input name="slider_ordering" type="number" min="0">
				</div>
			</div>
			<button type="submit"  id="addslider-btn" class="btn-p btn-p1">
				<i class="fa fa-plus icon-middle"></i>
				@add@
			</button>
		</form>
	</div>
	<div class="_5e4">
	<ul class="sliders-list scroll-custom">
		<li class="__mc-header g-d5 _j4 categories-item">
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-type">Type</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-category-tags">Category/Tags</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-category-tags">Ordering</div>
			<div>
				Action
			</div>
		</li>
		{{VIEW_SLIDERS_LIST}}
	</ul>
	</div>
</div>
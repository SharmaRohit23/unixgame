<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-plus color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<form id="editslider-form" enctype="multipart/form-data">
			<input type="hidden" name="slider_id" class="slider_id" value="{{SLIDER_ID}}">

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
					<input name="slider_ordering" type="number" min="0" value="{{SLIDER_ORDERING}}">
				</div>
			</div>
			<button type="submit"  id="addslider-btn" class="btn-p btn-p1">
				<i class="fa fa-plus icon-middle"></i>
				@edit@
			</button>
		</form>
	</div>
</div>
<div class="general-box _0e4">
	<div class="header-box">
		<button id="enableDisableSidebar" class="btn-p {{VIEW_SIDEBAR_ENABLE_DISABLE_BUTTON}}" style="float: left;"><i class="fa fa-{{VIEW_SIDEBAR_ENABLE_DISABLE_ICON}} icon-middle icon-18"></i> {{VIEW_SIDEBAR_ENABLE_DISABLE_TEXT}}</button>
		<button class="btn-p btn-p4" data-href="{{CONFIG_SITE_URL}}/admin/sidebar/add"><i class="fa fa-plus icon-middle icon-18"></i> @add_new_sidebar@</button>
	</div>
	<ul class="sidebar-list scroll-custom">
		<li class="__mc-header g-d5 _j4 categories-item">
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-type">Name</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-type">Type</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-category-tags">Category/Tags</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-category-tags">Custom Link</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-category-tags">Icon</div>
			<div style="text-align: left;float: left;flex:1;margin-left:20px" class="_slider-category-tags">Ordering</div>
			<div>
				Action
			</div>
		</li>
		{{VIEW_SIDEBAR_LIST}}
	</ul>
</div>
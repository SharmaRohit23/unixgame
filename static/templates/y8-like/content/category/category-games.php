<div class="category-section-top">
	<img src="{{CATEGORY_THUMB}}" alt="{{CATEGORY_NAME}}">
	<div>
		<h1>Category {{CATEGORY_NAME}}</h1>
		<p id="header-desc">{{HEADER_DESC}}</p>
	</div>
</div>
<div class="category-divider"></div>
<div class="content">
	<div id="content" style="margin-bottom:50px;">
	{{CATEGORY_GAMES_LIST}}

</div>

<div class="bgs bottomtext fn-clear" style="padding:20px; width:90% !important;">    
	{{FOOTER_DESCRIPTION_MODIFIED}}
</div>

<script src="{{CONFIG_THEME_PATH}}/js/libs/jquery.show-more.js"></script>
<script>
	if (window.innerWidth <= 768) {
		$('#header-desc').showMore({
			minheight: 105,
			maxWidth: "100%",
		});
	}
var cat = "{{CATEGORYID}}";
</script>

{{FOOTER_CONTENT}}
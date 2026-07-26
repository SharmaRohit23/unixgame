<div class="category-section-top">
	<div>
		<h1 style="text-align: center;">Tagged {{TAGS_NAME}} Games</h1>
		<div id="header-desc" style="text-align: center;">{{HEADER_DESC}}</div>
	</div>
</div>
<div class="category-divider"></div>

<div class="content">
	<div id="content" style="margin-bottom:50px;">
		{{TAGS_GAMES_LIST}}

	</div>
</div>

<div class="bgs bottomtext fn-clear" style="padding:20px; width:90% !important;">    
	{{FOOTER_DESCRIPTION_MODIFIED}}. Tagged {{TAGS_NAME}} Games
</div>

<script src="{{CONFIG_THEME_PATH}}/js/libs/jquery.show-more.js"></script>
<script>
	if (window.innerWidth <= 768) {
		$('#header-desc').showMore({
			minheight: 40,
			maxWidth: "100%",
		});
	}
</script>

{{FOOTER_CONTENT}}
<div class="general-box _0e4">
	<div class="_5e4" style="padding-top: 10px;padding-left: 30px;">
		<form id="updatelink-form" enctype="multipart/form-data">
			<div style="display: flex;">
				<p class="_tr5" style="margin-right: 10px;">Autopost Rephrase/rewrite</p>
				<select name="rewrite_method" class="_p4s8">
					{{LINK_REWRITE_METHOD}}
				</select>
			</div>
			<div style="display: flex; flex-direction: column; margin-top: 10px;">
				<p class="_tr5" style="margin-right: 10px;">Google Translate Language (Separate with comma)</p>
				<textarea name="google_translate_language" class="_p4s8" style="width: 500px;">{{GOOGLE_TRANSLATE_LANGUAGE}}</textarea>
				<p class="_tr5" style="margin-right: 10px;">Available: en, es, de, nl, it, fr, pl</p>
			</div>
			<button type="submit"  id="updatelink-btn" class="btn-p btn-p1">
				<i class="fa fa-plus icon-middle"></i>
				@save@
			</button>
		</form>
	</div>
	<p style="padding-top: 20px; padding-left: 30px;font-style: italic">
		Note: Enable and Disable Autopost link to get unique LINK!
	</p>

	<ul class="categories-list scroll-custom">
		{{VIEW_LINKS_LIST}}
	</ul>
</div>
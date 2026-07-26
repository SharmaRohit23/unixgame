<div class="general-box _0e4">
	<div class="_5e4" style="display:none;padding-top: 10px;padding-left: 30px;">
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
	
	<div style="margin:20px;padding:20px;background:#2f3545;border-left:4px solid #00bcd4;">
	<h3 style="margin-top:0;color:#fff;">🚀 Autopost Setup Guide</h3>

	<p>Step 1: Enable the autopost link you want to use.</p>
	<p>Step 2: Click the <strong>Add Cron</strong> button next to that link.</p>
	<p>Step 3: FreeCronJob will open with the URL already added.</p>
	<p>Step 4: Save the cron job and choose how often it should run.</p>
	<p>Step 5: Your website will publish content automatically.</p>

	<p style="margin-top:15px;color:#ccc;">
		<strong>Recommended:</strong><br>
		autopost = publish new games<br>
		autopost_old_games = rewrite old game descriptions<br>
		autopost_tags = generate SEO tag content
	</p>

	<div style="margin-top:15px;">
		<a href="https://www.freecronjob.com.es/dashboard.php" target="_blank" class="btn-p btn-p1">Open FreeCronJob Dashboard</a>
		<button type="button" onclick="document.getElementById('autopostLinksVideo').style.display='block'" class="btn-p btn-p1">Video Tutorial</button>
	</div>

	<div id="autopostLinksVideo" style="display:none;margin-top:20px;">
		<video controls style="width:100%;max-width:720px;border-radius:8px;background:#000;">
			<source src="/gm-content/autopost-tutorial.mp4" type="video/mp4">
		</video>
	</div>
</div>

	<ul class="categories-list scroll-custom">
		{{VIEW_LINKS_LIST}}
	</ul>
</div>
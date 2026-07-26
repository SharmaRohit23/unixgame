<div class="_header-section admin-hh-style">
	<span class="_content-title _content-color-a"><img class="img-50" src="{{CONFIG_THEME_PATH}}/image/icon-color/shield.png"> @administration@</span>
</div>

<div class="general-box" style="margin-bottom:15px;padding:20px;background:#2f3545;border-left:4px solid #00bcd4;">
	<h3 style="margin:0 0 10px 0;color:#fff;">🚀 Quick Start Autopost</h3>

	<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin:15px 0;">
		<div style="background:#252b38;padding:12px;border-radius:6px;color:#fff;">
			Active Links:<br>
			<b style="color:#2ecc71;">{{AUTOPOST_ACTIVE_LINKS}}</b>
		</div>

		<div style="background:#252b38;padding:12px;border-radius:6px;color:#fff;">
			Last Published:<br>
			<b style="color:#f1c40f;">{{AUTOPOST_LAST_PUBLISH}}</b>
		</div>

		<div style="background:#252b38;padding:12px;border-radius:6px;color:#fff;">
			Games Today:<br>
			<b style="color:#00bcd4;">{{AUTOPOST_GAMES_TODAY}}</b>
		</div>

		<div style="background:#252b38;padding:12px;border-radius:6px;color:#fff;">
			Total Games:<br>
			<b style="color:#00bcd4;">{{AUTOPOST_TOTAL_GAMES}}</b>
		</div>
		<div style="background:#252b38;padding:12px;border-radius:6px;color:#fff;">
			Total Game Plays:<br>
			<b style="color:#9b59b6;">{{ADMIN_STATS_GAMES}}</b>
		</div>
	</div>

	<p style="color:#ddd;">Enable Autopost Links, copy the generated URL, then add it to FreeCronJob.</p>

	<button type="button" id="enableAutopostCronBtn" class="btn-p btn-p1">
		Enable Autopost + Add Cron
	</button>
	<a href="https://www.freecronjob.com.es/dashboard.php" target="_blank" class="btn-p btn-p1">Open Cron Dashboard</a>
	<button type="button" onclick="document.getElementById('autopostVideoBox').style.display='block'" class="btn-p btn-p1">Watch Tutorial</button>

	<div id="autopostVideoBox" style="display:none;margin-top:20px;">
		<video controls style="width:100%;max-width:720px;border-radius:8px;background:#000;">
			<source src="/gm-content/autopost-tutorial.mp4" type="video/mp4">
		</video>
	</div>
</div>
<div class="general-box stats-box-container _yt10 _yb10">
	{{NEWS}}
</div>



 
<div class="_header-section admin-hh-style">
	<span class="_content-title _content-color-a"><img class="img-50" src="{{CONFIG_THEME_PATH}}/image/icon-color/shield.png"> @administration@</span>
</div>

{{CMS_UPDATE_NOTICE_BOX}}


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

<div id="cmsUpdateModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:99999;align-items:center;justify-content:center;padding:20px;">
	<div style="width:100%;max-width:620px;background:#222436;border:1px solid #e11d48;border-radius:14px;padding:22px;color:#fff;">
		<h2 style="margin-top:0;">CMS Update Running</h2>

		<div style="width:100%;height:18px;background:#111;border-radius:20px;overflow:hidden;margin:15px 0;">
			<div id="cmsUpdateBar" style="height:100%;width:0%;background:#16a34a;transition:.3s;"></div>
		</div>

		<div id="cmsUpdateText" style="white-space:pre-wrap;line-height:1.6;">Preparing...</div>

		<div style="margin-top:15px;">
			<button type="button" id="cmsUpdateCloseBtn" class="btn-p btn-p1" style="display:none;">Close</button>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var btn = document.getElementById('cmsUpdateNowBtn');
	var modal = document.getElementById('cmsUpdateModal');
	var text = document.getElementById('cmsUpdateText');
	var bar = document.getElementById('cmsUpdateBar');
	var closeBtn = document.getElementById('cmsUpdateCloseBtn');

	if (btn && modal && text && bar) {

		function setProgress(percent, msg) {
			bar.style.width = percent + '%';
			text.textContent = msg;
		}

		btn.addEventListener('click', function () {
		if (!confirm('Start CMS update now?')) return;

		modal.style.display = 'flex';
		closeBtn.style.display = 'none';
		setProgress(10, 'Starting download...');

		fetch('/assets/requests/admin/cms-update-run.php?action=run', {
			method: 'GET',
			credentials: 'same-origin'
		})
		.then(function (response) { return response.json(); })
		.then(function (data) {
			if (!data.ok) {
				setProgress(100, 'Error: ' + (data.error || 'Unknown error'));
				closeBtn.style.display = 'inline-block';
				return;
			}

			var msg = data.message + '\n\n';
			msg += 'Version: ' + data.version + '\n';
			msg += 'Files replaced: ' + data.summary.files_replaced + '\n';
			msg += 'Files created: ' + data.summary.files_created + '\n';
			msg += 'Files same: ' + data.summary.files_same + '\n';
			msg += 'Files skipped: ' + data.summary.files_skipped + '\n';
			msg += 'HTACCESS blocks updated: ' + (data.summary.htaccess_patched || 0) + '\n';
			msg += 'DB tables created: ' + data.summary.db_tables_created + '\n';
			msg += 'DB columns added: ' + data.summary.db_columns_added + '\n';
			msg += 'Cleanup deleted: ' + data.summary.cleanup_deleted + '\n';
			msg += '\nUpdate completed successfully. You can close this window.';
			setProgress(100, msg);
			closeBtn.style.display = 'inline-block';
		})
		.catch(function (error) {
			setProgress(100, 'Request failed: ' + error);
			closeBtn.style.display = 'inline-block';
		});
	});

	closeBtn.addEventListener('click', function () {
			location.reload();
		});

		}
});
</script>
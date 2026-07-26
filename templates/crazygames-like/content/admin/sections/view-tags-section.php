<div class="general-box _0e4">
	<div class="header-box">
		<button class="btn-p btn-p4" data-href="{{CONFIG_SITE_URL}}/admin/tags/add">
			<i class="fa fa-plus icon-middle icon-18"></i> @add_new_tags@
		</button>

		<button type="button" id="generateTagImagesBtn" class="btn-p btn-p1" style="margin-left:8px;">
			<i class="fa fa-image icon-middle icon-18"></i> Generate Tag Images
		</button>
	</div>

	<div id="tagImageGeneratorBox" style="display:none;margin:12px 0;padding:16px;border-radius:10px;background:#202938;color:#fff;">
		<p style="font-weight:800;margin-bottom:8px;font-size:15px;">
			Generate tag images for your website
		</p>

		<p style="color:#b8c0cc;margin-bottom:12px;line-height:1.5;">
			This creates tag images inside <b>/tag-img/</b> as <b>256x144 WebP</b>.
			You can stop and continue later.
		</p>

		<div id="tagImageStatusBox" style="padding:12px;border-radius:8px;background:rgba(255,255,255,.06);margin-bottom:12px;color:#d7e3ff;line-height:1.5;">
			Checking status...
		</div>

		<label style="display:flex;align-items:flex-start;gap:8px;margin-bottom:10px;cursor:pointer;">
			<input type="checkbox" id="tagImageReset">
			<span>
				Reset and remake all tag images from zero
				<small style="display:block;color:#ffcf7a;margin-top:3px;">
					Use this only when you want to overwrite all old tag images. After reset starts, you can refresh and continue without checking this again.
				</small>
			</span>
		</label>

		<div style="display:flex;gap:10px;align-items:center;margin-top:14px;flex-wrap:wrap;">
			<button type="button" id="tagImageStartBtn" class="btn-p btn-p1">
				Continue / Generate
			</button>

			<button type="button" id="tagImageCancelBtn" class="btn-p btn-p3">
				Cancel
			</button>

			<button type="button" id="tagImageRefreshBtn" class="btn-p btn-p4">
				Refresh Status
			</button>
		</div>

		<div id="tagImageProgressBox" style="display:none;margin-top:16px;padding:12px;border-radius:8px;background:rgba(0,0,0,.18);">
			<div style="margin-bottom:8px;font-weight:800;color:#fff;">
				Progress
			</div>

			<div id="tagImageGeneratorResult" style="color:#d7e3ff;white-space:pre-line;line-height:1.45;"></div>
		</div>
	</div>

	<ul class="categories-list scroll-custom">
		{{VIEW_TAGS_LIST}}
	</ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var openBtn = document.getElementById('generateTagImagesBtn');
	var box = document.getElementById('tagImageGeneratorBox');
	var startBtn = document.getElementById('tagImageStartBtn');
	var cancelBtn = document.getElementById('tagImageCancelBtn');
	var refreshBtn = document.getElementById('tagImageRefreshBtn');
	var resultBox = document.getElementById('tagImageGeneratorResult');
	var progressBox = document.getElementById('tagImageProgressBox');
	var statusBox = document.getElementById('tagImageStatusBox');
	var resetInput = document.getElementById('tagImageReset');

	if (!openBtn || !box || !startBtn || !cancelBtn || !refreshBtn || !resultBox || !progressBox || !statusBox) {
		return;
	}

	var endpoint = '{{CONFIG_SITE_URL}}/assets/requests/admin/generate-tag-images.php';
	var currentStatus = null;
	var isRunning = false;

	function postAction(action, extra) {
		var form = new FormData();
		form.append('action', action);

		if (extra) {
			Object.keys(extra).forEach(function (key) {
				form.append(key, extra[key]);
			});
		}

		return fetch(endpoint, {
			method: 'POST',
			body: form,
			credentials: 'same-origin'
		}).then(function (res) {
			return res.json();
		});
	}

	function renderStatus(data) {
		currentStatus = data || {};

		var total = parseInt(currentStatus.total || 0, 10);
		var existing = parseInt(currentStatus.existing || 0, 10);
		var missing = parseInt(currentStatus.missing || 0, 10);
		var remakeActive = !!currentStatus.remake_active;
		var remakeRemaining = parseInt(currentStatus.remake_remaining || 0, 10);
		var remakeGenerated = parseInt(currentStatus.remake_generated || 0, 10);
		var remakeFailed = parseInt(currentStatus.remake_failed || 0, 10);

		var html = '';

		html += '<b>Total tags:</b> ' + total + '<br>';
		html += '<b>Images already created:</b> ' + existing + '<br>';
		html += '<b>Missing images:</b> ' + missing + '<br>';

		if (remakeActive) {
			html += '<br><b style="color:#ffcf7a;">Remake mode is active.</b><br>';
			html += '<b>Remake generated:</b> ' + remakeGenerated + '<br>';
			html += '<b>Remake failed:</b> ' + remakeFailed + '<br>';
			html += '<b>Remaining to remake:</b> ' + remakeRemaining + '<br>';
			html += '<small style="color:#b8c0cc;">Do not check reset again. Just press Continue / Generate.</small>';

			startBtn.textContent = 'Continue Remake';
			resetInput.checked = false;
		} else if (missing > 0) {
			html += '<br><b style="color:#70ff7a;">Normal mode:</b> ready to generate missing images.<br>';
			html += '<small style="color:#b8c0cc;">If you stop, it continues later by skipping existing files.</small>';

			startBtn.textContent = 'Generate Missing Images';
		} else {
			html += '<br><b style="color:#70ff7a;">Finished.</b> All tag images exist.<br>';
			html += '<small style="color:#b8c0cc;">Use reset only if you want to remake all images again.</small>';

			startBtn.textContent = 'Finished - Remake Only';
		}

		statusBox.innerHTML = html;
	}

	function refreshStatus() {
		statusBox.innerHTML = 'Checking status...';

		return postAction('status').then(function (json) {
			if (!json || !json.status) {
				throw new Error(json && json.message ? json.message : 'Status request failed');
			}

			renderStatus(json.data || {});
		}).catch(function (err) {
			statusBox.innerHTML = '<span style="color:#ff8a8a;">Status error: ' + err.message + '</span>';
		});
	}

	openBtn.addEventListener('click', function () {
		box.style.display = 'block';
		progressBox.style.display = 'none';
		resultBox.textContent = '';
		refreshStatus();
	});

	refreshBtn.addEventListener('click', function () {
		refreshStatus();
	});

	cancelBtn.addEventListener('click', function () {
		box.style.display = 'none';
	});

	startBtn.addEventListener('click', function () {
		if (isRunning) {
			return;
		}

		var resetMode = resetInput && resetInput.checked;
		var remakeActive = currentStatus && currentStatus.remake_active;
		var missing = currentStatus ? parseInt(currentStatus.missing || 0, 10) : 0;

		if (resetMode) {
			if (!confirm('Reset and remake ALL tag images from zero? Existing images will be overwritten.')) {
				return;
			}
		} else if (remakeActive) {
			if (!confirm('Continue the active remake process from where it stopped?')) {
				return;
			}
		} else if (missing > 0) {
			if (!confirm('Generate only missing tag images?')) {
				return;
			}
		} else {
			if (!confirm('All tag images already exist. Do you want to start a full remake from zero?')) {
				return;
			}

			resetMode = true;
		}

		isRunning = true;
		startBtn.disabled = true;
		startBtn.textContent = 'Generating...';
		progressBox.style.display = 'block';
		resultBox.textContent = 'Starting...';

		var totalGenerated = 0;
		var totalFailed = 0;
		var rounds = 0;
		var forceMode = resetMode || remakeActive;

		function startRun() {
			if (resetMode) {
				postAction('reset').then(function (json) {
					if (!json || !json.status) {
						throw new Error(json && json.message ? json.message : 'Reset failed');
					}

					forceMode = true;
					runBatch();
				}).catch(stopWithError);
			} else {
				runBatch();
			}
		}

		function runBatch() {
			rounds++;

			postAction('generate', {
				limit: '100',
				cards: '0',
				force: forceMode ? '1' : '0'
			}).then(function (json) {
				if (!json || !json.status) {
					throw new Error(json && json.message ? json.message : 'Request failed');
				}

				var data = json.data || {};
				var generatedNow = parseInt(data.generated || 0, 10);
				var failedNow = parseInt(data.failed || 0, 10);
				var left = parseInt(data.left || 0, 10);

				totalGenerated += generatedNow;
				totalFailed += failedNow;

				var statusText = '';

				statusText += 'Mode: ' + (forceMode ? 'REMAKE FROM SAVED POSITION' : 'MISSING ONLY') + '\n';
				statusText += 'Round: ' + rounds + '\n';
				statusText += 'Generated this round: ' + generatedNow + '\n';
				statusText += 'Generated total this run: ' + totalGenerated + '\n';
				statusText += 'Failed total this run: ' + totalFailed + '\n';

				if (forceMode) {
					statusText += 'Remaining to remake: ' + left + '\n';
				} else {
					statusText += 'Missing left: ' + left + '\n';
				}

				statusText += '\nLast generated:\n';

				resultBox.textContent =
					statusText +
					(data.items ? data.items.slice(-10).join('\n') : '');

				if (!data.done && rounds < 200) {
					setTimeout(runBatch, 650);
				} else {
					finishRun();
				}
			}).catch(stopWithError);
		}

		function finishRun() {
			isRunning = false;
			startBtn.disabled = false;
			startBtn.textContent = 'Continue / Generate';

			refreshStatus();

			if (confirm('Finished for now. Reload page?')) {
				window.location.reload();
			}
		}

		function stopWithError(err) {
			isRunning = false;
			startBtn.disabled = false;
			startBtn.textContent = 'Continue / Generate';
			resultBox.textContent = 'Error: ' + err.message;
			refreshStatus();
		}

		startRun();
	});
});
</script>
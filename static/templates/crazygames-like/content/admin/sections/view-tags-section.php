<div class="general-box _0e4">
	<div class="header-box">
		<button class="btn-p btn-p4" data-href="{{CONFIG_SITE_URL}}/admin/tags/add">
			<i class="fa fa-plus icon-middle icon-18"></i> @add_new_tags@
		</button>

		<button type="button" id="generateTagImagesBtn" class="btn-p btn-p1" style="margin-left:8px;">
			<i class="fa fa-image icon-middle icon-18"></i> Generate Tag Images
		</button>
	</div>

	<div id="tagImageGeneratorBox" style="display:none;margin:12px 0;padding:14px;border-radius:10px;background:#202938;color:#fff;">
		<p style="font-weight:700;margin-bottom:8px;">Generate tag images for your website?</p>
		<p style="color:#b8c0cc;margin-bottom:12px;">
			This will find similar old game images for tags without image and create /tag-img/slug.webp as 180x180.
		</p>

		<label style="display:block;margin-bottom:10px;">
			<input type="checkbox" id="tagImageGenerateCards" checked>
			Generate tag cards after image creation
		</label>

		<label style="display:block;margin-bottom:10px;">
			<input type="checkbox" id="tagImageForce">
			Force remake existing tag images
		</label>

		<button type="button" id="tagImageStartBtn" class="btn-p btn-p1">
			Yes Generate
		</button>

		<button type="button" id="tagImageCancelBtn" class="btn-p btn-p3" style="margin-left:8px;">
			Cancel
		</button>

		<div id="tagImageGeneratorResult" style="margin-top:12px;color:#d7e3ff;white-space:pre-line;"></div>
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
	var resultBox = document.getElementById('tagImageGeneratorResult');
	var cardsInput = document.getElementById('tagImageGenerateCards');
	var forceInput = document.getElementById('tagImageForce');

	if (!openBtn || !box || !startBtn || !cancelBtn || !resultBox) {
		return;
	}

	openBtn.addEventListener('click', function () {
		box.style.display = 'block';
		resultBox.textContent = '';
	});

	cancelBtn.addEventListener('click', function () {
		box.style.display = 'none';
	});

	startBtn.addEventListener('click', function () {
		if (!confirm('Do you want to generate tag images for your website?')) {
			return;
		}

		startBtn.disabled = true;
		startBtn.textContent = 'Generating...';

		var totalGenerated = 0;
		var totalFailed = 0;
		var totalCards = 0;
		var rounds = 0;

		function runBatch() {
			rounds++;

			var form = new FormData();
			form.append('limit', '200');
			form.append('cards', cardsInput && cardsInput.checked ? '1' : '0');
			form.append('force', forceInput && forceInput.checked ? '1' : '0');

			fetch('{{CONFIG_SITE_URL}}/assets/requests/admin/generate-tag-images.php', {
				method: 'POST',
				body: form,
				credentials: 'same-origin'
			})
			.then(function (res) {
				return res.json();
			})
			.then(function (json) {
				if (!json || !json.status) {
					throw new Error(json && json.message ? json.message : 'Request failed');
				}

				var data = json.data || {};

				totalGenerated += parseInt(data.generated || 0, 10);
				totalFailed += parseInt(data.failed || 0, 10);
				totalCards += parseInt(data.cards || 0, 10);

				resultBox.textContent =
					'Round: ' + rounds + '\n' +
					'Generated images: ' + totalGenerated + '\n' +
					'Generated cards: ' + totalCards + '\n' +
					'Failed: ' + totalFailed + '\n' +
					'Missing left: ' + (data.left || 0) + '\n\n' +
					(data.items ? data.items.slice(-8).join('\n') : '');

				if (!data.done && rounds < 100) {
					setTimeout(runBatch, 650);
				} else {
					startBtn.disabled = false;
					startBtn.innerHTML = 'Yes Generate';

					if (confirm('Finished. Reload page now?')) {
						window.location.reload();
					}
				}
			})
			.catch(function (err) {
				resultBox.textContent = 'Error: ' + err.message;
				startBtn.disabled = false;
				startBtn.innerHTML = 'Yes Generate';
			});
		}

		runBatch();
	});
});
</script>

<div class="home-categories-tags-container">
	<div class="home-categories">
		{{CATEGORIES_LIST_HOME}}
		<a href="{{CONFIG_SITE_URL}}/categories" class="">More Categories</a>
	</div>
	<div class="home-tags">
		{{TAGS_LIST_HOME}}
		<a href="{{CONFIG_SITE_URL}}/tags" class="">More Tags</a>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Pilih tombol "More Tags"
		var moreTagsButton = document.querySelector('.home-tags li a[href$="/tags"]');
		
		if (moreTagsButton) {
			moreTagsButton.addEventListener('click', function(event) {
				event.preventDefault(); // Mencegah link membuka halaman baru
				
				// Pilih semua item tag yang disembunyikan
				var hiddenTags = document.querySelectorAll('.home-tags li:nth-child(n+12)');
				
				// Ubah display dari semua elemen yang disembunyikan menjadi 'flex'
				hiddenTags.forEach(function(tag) {
					tag.style.display = 'flex';
				});

				// Sembunyikan tombol "More Tags" setelah diklik
				moreTagsButton.parentElement.style.display = 'none';
			});
		}
	});
</script>
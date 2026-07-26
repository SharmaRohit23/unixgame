<script language="javascript">var PageType ="{{NEW_GAME_PAGE}}"; var ids ="{{NEW_GAME_IDS}}";</script>
<div class="content">
	<!-- <script>
		// Function untuk mengganti konten h1 dan p berdasarkan halaman
		function updatePageTitle(page) {
			const pageTitle = document.querySelector(".page-title h1");
			const pageDescription = document.querySelector(".page-title p");

			switch (page) {
			case "":
				pageTitle.textContent = "Crazy Games X";
				pageDescription.textContent = "Best Free Online Games For You";
				break;
			case "new-games":
				pageTitle.textContent = "New Games";
				pageDescription.textContent = "Discover the latest free online games!";
				break;
			case "best-games":
				pageTitle.textContent = "Popular Games";
				pageDescription.textContent = "Check out the most popular games trending right now!";
				break;
			case "featured-games":
				pageTitle.textContent = "Featured Games";
				pageDescription.textContent = "Enjoy our selection of featured games for you!";
				break;
			default:
				pageTitle.textContent = "Page Not Found";
				pageDescription.textContent = "Sorry, we couldn't find the page you're looking for.";
			}
		}

		function getCurrentPage() {
			const path = window.location.pathname; 
			const page = path.split("/").filter(Boolean).pop(); 
			return page || ""; 
		}

		document.addEventListener("DOMContentLoaded", function() {
			const currentPage = getCurrentPage();

			updatePageTitle(currentPage);
		});

	</script> -->
	<div class="page-title">
		<h1>{{PAGE_TITLE}}</h1>
		<p>{{IS_SIDEBAR_ENABLED}}</p>
	</div>
	{{CATEGORIES_TAGS_HOME}}
	{{IS_SIDEBAR_ENABLED}}
	{{NEW_GAMES}}
</div>

{{FOOTER_CONTENT}}
<div class="hide-text">
	<div>
		<h1>Category {{CATEGORY_NAME}}</h1>
		<p id="header-desc">{{HEADER_DESC}}</p>
	</div>
</div>


<div class="game-list-grid-container">
    <div class="home-search-container">
        <a href="/" class="logo-home hide-text" aria-label="home">
            Home
        </a>
        <div class="home-search">
            <a href="/" class="home-icon">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
            <div id="search" class="home-icon">
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div id="search-left">
        <div class="search-container">
            <div id="search-left-close">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </div>
            <div class="search-form">
                <form id="search-data-form" onsubmit="return false;">
                    <img src="/templates/poki-like/image/poki-circle-logo.png" class="poki-circle-logo" alt="poki-circle-logo">
                    <div class="divider"></div>
                    <input type="text" class="txt fn-left search-input" id="Search-InArea" name="search_parameter" type="text" placeholder="What are you playing today?">
                    <input type="submit" class="btn" value="" id="search" aria-label="search-button">
                    <div id="clear-search">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </div>
                </form>
            </div>
            <div id="search-results" class="search-results games-list">
                <!-- Hasil pencarian akan muncul di sini -->
            </div>
            <div id="tag-and-games-contaner">
                <div class="tag-container">
                    <div class="tag-list">
                        {{TAGS_LIST_HOME}}
                    </div>
                </div>
                <p class="title">Popular Games</p>
                <div class="games-list">
                    {{POPULAR_GAME_LIST}}
                </div>
                <p class="title">Last Played</p>
                <div class="games-list played-games">
                    {{GAMES_PLAYED_LEFT}}
                </div>
            </div>
        </div>
    </div>
    <div></div>
    <div class="title-box">
        Category {{CATEGORY_NAME}}
    </div>
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
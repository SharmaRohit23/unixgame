<div class="home-search-container blog-page">
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
<div id="Pages" class="bgs">
    <div class="privacy-t">ABOUT US</div>
    <div class="">
        {{FOOTER_DESCRIPTION_CONTENT_VALUE}}
    </div>
    <dl class="bgs bottomtext fn-clear" style="padding:20px;">    
        {{FOOTER_DESCRIPTION}}
    </dl>
    <a href="https://gamemonetize.com" target="_blank" aria-label="GameMonetize.com CMS" style="display: block;text-align: center;padding-top: 20px;">
        <img src="https://api.gamemonetize.com/powered_by_gamemonetize.png" alt="GameMonetize.com CMS" style="width:290px;text-align: center;margin: 0 auto;">
    </a>
</div>
<div id="header" class="fix-top">

    <div class="head-inner">
        <div class="menu-mobile">
            <i class="material-icons-outlined material-symbols-outlined">menu</i>
            <i class="material-icons-outlined material-symbols-outlined fn-hide">close</i>
        </div>
        <div class="logo">
            <a href="{{CONFIG_SITE_URL}}/" class="hide-text">Play Best Free Online Games</a>
        </div>
        <div class="search-form">
            <form id="search-data-form" method="POST" autocomplete="off">
                <input type="text" class="txt fn-left search-input" id="Search-InArea" name="search_parameter" type="text" placeholder="@search_games@">
                <input type="submit" class="btn" value="" id="search" aria-label="search-button">
            </form>
        </div>
        <div class="other-btn">
            <div class="menu-btn new-games">
                <i class="new"></i>
                <div>
                    <div>New Games</div>
                    <div class="more"><span>&</span> more</div>
                </div>
                <i class="arrow-down"></i>
                <div class="new-games-pop-up fn-hide">
                    <a href="{{CONFIG_SITE_URL}}/new-games">
                        <i class="material-icons-outlined material-symbols-outlined">new_releases</i>
                        New Games
                    </a>
                    <a href="{{CONFIG_SITE_URL}}/best-games">
                        <i class="material-icons-outlined material-symbols-outlined">star</i>
                        Best Games
                    </a>
                    <a href="{{CONFIG_SITE_URL}}/featured-games">
                        <i class="material-icons-outlined material-symbols-outlined">auto_graph</i>
                        Featured Games
                    </a>
                    <a href="{{CONFIG_SITE_URL}}/played-games">
                        <i class="material-icons-outlined material-symbols-outlined">play_circle</i>
                        Played Games
                    </a>
                </div>
            </div>
            <a class="menu-btn" href="{{CONFIG_SITE_URL}}/blogs">
                <i class="blog"></i>
                <div>Blog</div>
            </a>
        </div>
        <div class="right-btn-mobile">
            <div class="search-btn">
            </div>
            <!-- <a class="menu-btn blog-link-mobile" href="{{CONFIG_SITE_URL}}/blogs">
                <i class="blog"></i>
                <div>Blog</div>
            </a> -->
        </div>
        <!-- <div class="menu">
            <ul class="menu-ul fn-clear">
                <li class="submenu">
                    <a href="{{CONFIG_SITE_URL}}/categories" class=""><i class="cate"></i><span>Category</span></a>
                    <div class="menupopup fn-hide">
                        <ul class="cate-list">
                            {{CATEGORIES_LIST_2}}
                            <li><a href="{{CONFIG_SITE_URL}}/categories" class="">More Categories &gt;&gt;</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="tips" href="{{CONFIG_SITE_URL}}/new-games"><i class="new"></i><span>New</span></a>
                    <div class="tooltip fn-hide">
                        <span class="arrow"></span>
                        <div class="tip-txt">New Games</div>
                    </div>
                </li>
                <li>
                    <a class="tips" href="{{CONFIG_SITE_URL}}/best-games"><i class="best"></i><span>Best</span></a>
                    <div class="tooltip fn-hide">
                        <span class="arrow"></span>
                        <div class="tip-txt">Best Games</div>
                    </div>
                </li>
                <li>
                    <a href="{{CONFIG_SITE_URL}}/featured-games"><i class="featur"></i><span>Featured</span></a>
                    <div class="tooltip featip fn-hide">
                        <span class="arrow"></span>
                        <div class="tip-txt">Featured Games</div>
                    </div>
                </li>

                <li>
                    <a href="{{CONFIG_SITE_URL}}/played-games"> <i class="recent"></i> <span>Played</span></a>
                    <div class="tooltip featip fn-hide">
                        <span class="arrow"></span>
                        <div class="tip-txt">Played Games</div>
                    </div>
                </li>
                <li>
                    <a href="{{CONFIG_SITE_URL}}/blogs"> <i class="blog"></i> <span>Blog</span></a>
                    <div class="tooltip featip fn-hide">
                        <span class="arrow"></span>
                        <div class="tip-txt">Blog Post</div>
                    </div>
                </li>

            </ul>
        </div> -->
    </div>

</div>

<div class="h-head"></div>


<div class="new-games-pop-up-mobile fn-hide">
    <div class="new-games-btns">
        <a href="{{CONFIG_SITE_URL}}/new-games">
            <i class="material-icons-outlined material-symbols-outlined">new_releases</i>
            New Games
        </a>
        <a href="{{CONFIG_SITE_URL}}/best-games">
            <i class="material-icons-outlined material-symbols-outlined">star</i>
            Best Games
        </a>
        <a href="{{CONFIG_SITE_URL}}/featured-games">
            <i class="material-icons-outlined material-symbols-outlined">auto_graph</i>
            Featured Games
        </a>
        <a href="{{CONFIG_SITE_URL}}/played-games">
            <i class="material-icons-outlined material-symbols-outlined">play_circle</i>
            Played Games
        </a>
    </div>
    <div class="home-categories">
        {{CATEGORIES_LIST_2}}
        <a href="{{CONFIG_SITE_URL}}/categories" class="">More Categories</a>
    </div>
    <div class="home-tags">
        {{TAGS_LIST}}
        <a href="{{CONFIG_SITE_URL}}/tags" class="">More Tags</a>
    </div>
</div>
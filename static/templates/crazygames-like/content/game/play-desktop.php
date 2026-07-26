<script language="javascript">
    var PageType = "";
    var ids = "";
</script>

<div class="flex flex-col gap-6 pt-5 lg:flex-row">
    <div class="relative flex-1 overflow-hidden text-white">
        <div class="game-container game-col">
            <div class="game-info">
                <div id="loader_container">
                    <div id="preloader_box"></div>
                </div>
                <div id="gameDiv">
                    <div id="ava-game_container" class="w-full game-box aspect-video max-h-[calc(100svh-240px)]" data-norate="1">
                        <div id="gamePlay-content" oncontextmenu="return false">
                            <img src="{{PLAY_GAME_IMAGE}}" class="absolute z-[1] object-cover object-bottom w-full h-full backdrop-blur-sm opacity-80 left-0 top-0 lazyload" data-src="{{PLAY_GAME_IMAGE}}" alt="image bg {{PLAY_GAME_NAME}}" loading="lazy">
                            <video loop="" autoplay="" muted preload="metadata" playsinline="" disableremoteplayback="" disablepictureinpicture="" class="absolute z-[2] object-cover object-center w-full h-full left-0 top-0">
                                <source src="{{GAME_VIDEO_URL}}" type="video/mp4">
                            </video>
                            <div class="absolute z-[3] w-full h-full bg-black opacity-80 backdrop-blur-lg left-0 top-0"></div>
                            <div class="flex flex-col items-center justify-center relative z-[4] h-full w-full space-y-5 top-0 left-0">
                                <img class="w-48 rounded-xl" src="{{PLAY_GAME_IMAGE}}" alt="image {{PLAY_GAME_NAME}}">
                                <div class="text-2xl font-extrabold">{{PLAY_GAME_NAME}}</div>
                                <div class="flex items-center justify-center w-[200px] h-14 text-xl font-extrabold rounded-full cursor-pointer bg-violet-600 play-now-button hover:scale-105 transition-transform duration-300 ease-in-out">
                                    <span>Play Now</span>
                                    <svg class="ml-2 size-8 fill-white" focusable="false" aria-hidden="true" viewBox="0 0 24 24" width="24" height="24">
                                        <path d="M10 15.0657V8.93426C10 8.53491 10.4451 8.29671 10.7773 8.51823L15.376 11.584C15.6728 11.7819 15.6728 12.2181 15.376 12.416L10.7774 15.4818C10.4451 15.7033 10 15.4651 10 15.0657Z"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 15.0657V8.93426C9.5 8.13556 10.3901 7.65917 11.0547 8.10221L15.6533 11.1679C16.247 11.5638 16.247 12.4362 15.6533 12.8321L11.0547 15.8978C10.3901 16.3408 9.5 15.8644 9.5 15.0657ZM10 8.93426V15.0657C10 15.4651 10.4451 15.7033 10.7774 15.4818L15.376 12.416C15.6728 12.2181 15.6728 11.7819 15.376 11.584L10.7773 8.51823C10.4451 8.29671 10 8.53491 10 8.93426Z"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div id="pre-count">
                            <font lib="game-loading">Game loading..</font>
                            <div id="pre-count-num">25</div>
                        </div>
                        <div id="game-preloading"></div>
                        <div id="game-preloader"></div>
                        <div id="game-box"></div>

                        <div id="adsContainer">
                            <div id="adContainer"></div>
                            <video id="videoElement"></video>
                        </div>
                    </div>
                    <div class="flex justify-between items-center bg-[#212233] text-white h-[45px] px-4">
                        <div class="flex items-center text-base">
                            <img class="mr-2 rounded-lg size-6" src="{{PLAY_GAME_IMAGE}}" alt="image bg {{PLAY_GAME_NAME}}">
                            <p>{{PLAY_GAME_NAME}}</p>
                        </div>
                        <!-- dreapta -->
                        <div class="flex items-center gap-3 shrink-0">

                            <div class="flex items-center gap-2 px-2 h-14 text-white">
                                <i class="fa-solid fa-gamepad text-[18px]"></i>
                                <span id="play-count">{{PLAY_GAME_PLAYS}} plays</span>
                            </div>

                            <div class="flex items-center h-14">

                                <button class="vote-btn flex items-center gap-2 px-4 h-14 text-white"
                                    data-type="like"
                                    data-id="{{PLAY_GAME_ID}}">
                                    <i class="fa-regular fa-thumbs-up text-[20px]"></i>
                                    <span id="like-count">{{PLAY_GAME_LIKES}}</span>
                                </button>

                                <button class="vote-btn flex items-center px-4 h-14 text-white"
                                    data-type="dislike"
                                    data-id="{{PLAY_GAME_ID}}">
                                    <i class="fa-regular fa-thumbs-down text-[20px]"></i>
                                    <span id="dislike-count" class="ml-2">{{PLAY_GAME_DISLIKES}}</span>
                                </button>

                                <button class="vote-btn flex items-center px-4 h-14 text-white"
                                    data-type="favorite"
                                    data-id="{{PLAY_GAME_ID}}">
                                    <i class="fa-regular fa-heart text-[20px]"></i>
                                    <span id="favorite-count" class="ml-2">{{PLAY_GAME_FAVORITES}}</span>
                                </button>



                                <div class="relative" id="report-dropdown-wrap">
                                    <button id="report-open-menu"
                                        class="flex items-center gap-2 px-4 h-14 text-white"
                                        data-game-id="{{PLAY_GAME_ID}}"
                                        data-game-name="{{PLAY_GAME_NAME}}">
                                        <i class="fa-regular fa-flag text-[20px]"></i>
                                        <span class="text-[18px]">Report</span>
                                        <i class="fa-solid fa-chevron-down text-[14px]"></i>
                                    </button>

                                    <div id="report-menu"
                                        class="hidden absolute right-0 bottom-full mb-2 w-[220px] rounded-[22px] bg-[#2f3150] shadow-2xl overflow-hidden z-[9999]">
                                        <button class="report-type-item flex items-center gap-4 w-full px-6 py-4 text-left text-white hover:bg-[#3a3d5c]" data-type="Bug">
                                            <i class="fa-solid fa-bug text-[20px] w-6"></i>
                                            <span class="text-[17px]">Bug</span>
                                        </button>

                                        <button class="report-type-item flex items-center gap-4 w-full px-6 py-4 text-left text-white hover:bg-[#3a3d5c]" data-type="Legal">
                                            <i class="fa-solid fa-scale-balanced text-[20px] w-6"></i>
                                            <span class="text-[17px]">Legal</span>
                                        </button>

                                        <button class="report-type-item flex items-center gap-4 w-full px-6 py-4 text-left text-white hover:bg-[#3a3d5c]" data-type="Harmful">
                                            <i class="fa-solid fa-triangle-exclamation text-[20px] w-6"></i>
                                            <span class="text-[17px]">Harmful</span>
                                        </button>
                                    </div>
                                </div>





                                <div id="report-modal-overlay" class="hidden fixed inset-0 bg-black/70 z-[9998]"></div>

                                <div id="report-modal"
                                    class="hidden fixed left-1/2 top-1/2 z-[9999]
            w-[450px] h-[450px]
            -translate-x-1/2 -translate-y-1/2
            rounded-[18px] bg-[#2f3150]
            p-4
            text-white shadow-2xl
            overflow-y-auto">

                                    <button id="report-close-btn"
                                        class="absolute right-3 top-2 text-white text-2xl leading-none">&times;</button>

                                    <h2 class="text-lg font-bold mb-1">Report</h2>
                                    <p class="text-xs text-white/80 mb-2">
                                        Fill the form and submit.
                                    </p>

                                    <form id="report-form" class="space-y-2">

                                        <input type="hidden" name="game_id" id="report-game-id" value="">
                                        <input type="hidden" name="game_name" id="report-game-name" value="">

                                        <!-- TYPE -->
                                        <div>
                                            <label class="block text-xs font-semibold mb-1">Type</label>
                                            <select name="report_type" id="report-type"
                                                class="w-full rounded-lg border border-[#4b4e73]
                           bg-white text-[#2f3150]
                           px-3 py-2 text-xs outline-none">
                                                <option value="Bug">Bug</option>
                                                <option value="Legal">Legal</option>
                                                <option value="Harmful">Harmful</option>
                                            </select>
                                        </div>

                                        <!-- EMAIL -->
                                        <div>
                                            <label class="block text-xs font-semibold mb-1">Email</label>
                                            <input type="email" name="user_email" id="report-email"
                                                placeholder="email"
                                                class="w-full rounded-lg border border-[#4b4e73]
                          bg-white text-[#2f3150]
                          px-3 py-2 text-xs outline-none"
                                                required>
                                        </div>

                                        <!-- SUBJECT -->
                                        <div>
                                            <label class="block text-xs font-semibold mb-1">Subject</label>
                                            <input type="text" name="subject" id="report-subject"
                                                class="w-full rounded-lg border border-[#4b4e73]
                          bg-white text-[#2f3150]
                          px-3 py-2 text-xs outline-none"
                                                required>
                                        </div>

                                        <!-- MESSAGE -->
                                        <div>
                                            <label class="block text-xs font-semibold mb-1">Message</label>
                                            <textarea name="message" id="report-message"
                                                placeholder="Describe issue..."
                                                class="w-full rounded-lg border border-[#4b4e73]
                             bg-white text-[#2f3150]
                             px-3 py-2 text-xs outline-none
                             h-[80px] resize-none"
                                                required></textarea>
                                        </div>

                                        <!-- BUTTON -->
                                        <button type="submit"
                                            class="w-full rounded-lg bg-red-600
                       py-2 text-sm font-bold text-white
                       hover:bg-red-700">
                                            Submit
                                        </button>

                                    </form>
                                </div>





                            </div>

                            <div class="game-zoom-btn size-[18px] cursor-pointer ml-2" onclick="ReqGameFullscreen();return false;">
                                <a href="#" id="gameFull" title="Play game fullscreen"></a>
                            </div>

                            <div id="exitFullscreen-btn" class="hidden cursor-pointer">
                                <img class="size-[18px]" src="{{CONFIG_THEME_PATH}}/image/exit-fullscreen.svg" alt="exit fullscreen" id="exit-button">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="js-ad-box flex mt-8 relative items-center justify-center min-h-[90px] mx-auto max-w-[720px] border border-[#28293D] bg-[#181925]" data-ad-name="header">{{ADS_HEADER}}</div>
        
        <div class="flex items-start gap-4 mt-8">
            <div class="flex-1">
                <div class="bg-[#1a1b28] p-6 w-full rounded-lg text-white space-y-4" style="min-height: 200px;">
                    <div class="flex items-center gap-1">
                        <a href="/" class="font-bold text-violet-500 hover:text-violet-700">Games</a>
                        <div>»</div>
                        <a href="/category/{{PLAY_GAME_CATEGORY_URL}}" class="font-bold text-violet-500 hover:text-violet-700">{{PLAY_GAME_CATEGORY_NAME}}</a>
                        <div>»</div>
                        <a href="/tag/{{PLAY_GAME_FIRST_TAG_URL}}" class="font-bold text-violet-500 hover:text-violet-700">{{PLAY_GAME_FIRST_TAG_NAME}}</a>
                    </div>
                    <h1 class="text-4xl font-extrabold">{{PLAY_GAME_NAME}}</h1>
                    <div class="text-sm play-game-desc">
                        {{PLAY_GAME_DESC}}
                    </div>
                    <div class="flex flex-wrap gap-4">
                        {{PLAY_GAME_TAGS}}
                    </div>
                </div>

                <div class="bg-[#1a1b28] p-6 rounded-lg text-white space-y-4" style="min-height: 200px;">
                    <div class="text-xl font-extrabold">Play {{PLAY_GAME_NAME}} {{PLAY_GAME_WALKTHROUGH}}</div>
                    <div class="description" id="gamemonetize-video" style="width: 100%; height: 480px;">
                    </div>
                    <script type="text/javascript">
                        window.VIDEO_OPTIONS = {
                            gameid: "{{GAME_UNIQUE_ID}}",
                            width: "100%",
                            height: $(document).width() < 600 ? "320px" : "480px",
                            color: "#3f007e"
                        };
                        (function(a, b, c) {
                            var d = a.getElementsByTagName(b)[0];
                            a.getElementById(c) || (a = a.createElement(b), a.id = c, a.src = "https://api.gamemonetize.com/video.js?v=" + Date.now(), d.parentNode.insertBefore(a, d))
                        })(document, "script", "gamemonetize-video-api");
                    </script>
                </div>
            </div>

        <div class="js-ad-parent space-y-4 shrink-0 bg-[#1a1b28] p-2 rounded-lg">
            <div class="js-ad-box relative flex items-center justify-center w-[300px] ads300-container border border-[#28293D] h-[600px] bg-[#181925]" data-ad-name="sidebar">{{ADS_SIDEBAR}}</div>
        </div>

        </div>
    </div>

    <div class="w-full lg:w-[340px]">
        <div class="grid grid-cols-5 gap-2 lg:grid-cols-2">
            <div class="js-ad-box relative hidden col-span-2 row-span-2 ads300-container border border-[#28293D] h-[282px] bg-[#181925]" data-ad-name="right-300">{{ADS_300}}</div>
            {{PLAY_SIDEBAR_WIDGETS}}
            {{PLAY_SIDEBAR_WIDGETS2}}
            {{PLAY_SIDEBAR_WIDGETS3}}
        </div>
    </div>
</div>

<script type="text/javascript">
    var objGameFlash = null;
    var percentage = 0;
    t1 = setInterval("getPercentage()", 200);

    function getPercentage() {
        if (objGameFlash == null) objGameFlash = getGameFlashObj();
        if (objGameFlash) {
            try {
                percentage = objGameFlash.PercentLoaded();
                if (percentage < 0 || typeof(percentage) == 'undefined') percentage = 100;
            } catch (e) {
                percentage = 100;
            }
        } else {
            percentage = 100;
        }
        if (percentage == 100) {
            clearInterval(t1);
        }
        return percentage;
    }

    function getGameFlashObj() {
        if (window.document.GameEmbedSWF) return window.document.GameEmbedSWF;
    }

    function showGame() {
        $("#loader_container").css({
            visibility: "hidden",
            display: "none"

        });
        $("#gameDiv").css({
            visibility: "visible",
            display: "block",
            height: "100%"
        });
        showGameBox();
        u3dplay();
    }
</script>

<style>
    .js-ad-box:not(:has(a, img, iframe, script, ins, object, embed)) {
        display: none !important;
    }

    .js-ad-parent:not(:has(a, img, iframe, script, ins, object, embed)) {
        display: none !important;
    }

    .js-ad-box.hidden:has(a, img, iframe, script, ins, object, embed),
    .ads300-container.hidden:has(a, img, iframe, script, ins, object, embed) {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
</style>

{{FOOTER_CONTENT}}

<script type="text/javascript">
    var PreGameAdURL = "{{ADS_VIDEO}}";

    function getcookie(name) {
        var cookie_start = document.cookie.indexOf(name);
        var cookie_end = document.cookie.indexOf(";", cookie_start);
        return cookie_start == -1 ? '' : unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
    }

    function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
        var expires = new Date();
        expires.setTime(expires.getTime() + seconds);
        document.cookie = escape(cookieName) + '=' + escape(cookieValue) +
            (expires ? '; expires=' + expires.toGMTString() : '') +
            (path ? '; path=' + path : '/') +
            (domain ? '; domain=' + domain : '') +
            (secure ? '; secure' : '');
    }

    function ClearPlayedGames() {
        setcookie("lastplayedgames", "", -360000, "/");
        return false;
    }

    function PlayedGames(game_id) {
        var playedgames = getcookie("playedgames");
        if (playedgames.indexOf("," + game_id + ",") > -1) {
            playedgames = playedgames.replace("," + game_id + ",", '');
        } else {
            if (playedgames == "" || playedgames == ",") {
                playedgames = "," + game_id + ",";
            } else {
                playedgames = "," + game_id + "," + playedgames;
            }
        }
        setcookie("playedgames", playedgames, 25920000000, "/");
    }
    var playGameId = Number('{{PLAY_GAME_ID}}');

    window.setTimeout(function() {
        if (typeof __upGame_rx8 === 'function' && playGameId > 0) {
            __upGame_rx8(playGameId);
        }
    }, 2000);

    var descriptionURL = "{{DESCRIPTION_URL}}";
    var iframe = '{{PLAY_GAME_EMBED}}';

    function ReqGameFullscreen() {
        let gameElement = document.getElementById('gameDiv');
        $("#ava-game_container").removeClass("max-h-[calc(100svh-240px)]");
        $("#ava-game_container").addClass("max-h-[calc(100svh-45px)]");
        $('.game-zoom-btn').addClass("hidden");
        $('#exitFullscreen-btn').removeClass("hidden");
        if (gameElement.requestFullscreen) {
            gameElement.requestFullscreen();
        } else if (gameElement.mozRequestFullScreen) { // Mozilla
            gameElement.mozRequestFullScreen();
        } else if (gameElement.webkitRequestFullscreen) { // Webkit
            gameElement.webkitRequestFullscreen();
        } else if (gameElement.msRequestFullscreen) { // IE/Edge
            gameElement.msRequestFullscreen();
        }
    }
    document.getElementById('exitFullscreen-btn').addEventListener('click', function() {
        exitFullscreen();
    });

    function exitFullscreen() {
        let gameElement = document.getElementById('gameDiv');
        $("#ava-game_container").removeClass("max-h-[calc(100svh-45px)]");
        $("#ava-game_container").addClass("max-h-[calc(100svh-240px)]");
        $('.game-zoom-btn').removeClass("hidden");
        $('#exitFullscreen-btn').addClass("hidden");
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { // Mozilla
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { // Webkit
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { // IE/Edge
            document.msExitFullscreen();
        }
    }
    $(document).ready(function() {
        $('.play-now-button').click(function(e) {
            $("#play-game-box").removeClass("hidden");
            SkipAdAndShowGame();
            $("#gamePlay-content").hide();
            // $('#adsContainer').show();

            if ($(document).width() < 1024) {
                $("#header").hide();
                $("#topad").hide();
                $("#game-bottom").hide();
                $(".play-game-bottom").hide();
                $(".tags-walkthrough-container").hide();
                $(".h-head").hide();
                $(".game-zoom").hide();
                // $("#adsContainer").hide();
                $("#game-col").css("margin", "0px");
                $("#game-col").css("height", "100svh");
                $("#gameDiv").css("height", "100svh");
                $("#gameDiv").css("width", "100vw");
                $("#gameDiv").css("position", "fixed");
                $("#gameDiv").css("top", "0");
                $("#gameDiv").css("left", "0");
                $("#gameDiv").css("z-index", "9999");
                $("#ava-game_container").css("height", "100svh");
                $('body').css('overflow', 'hidden');
                $('.close-fullscreen').css('display', 'flex');
                // GameFullscreen()
                // $("#game-preloading").show();
                // setTimeout(
                // function() 
                // {
                //     $("#game-preloading").hide();
                //     PreRollAd.start();
                // }, 550);
                // Tambahkan fungsi fullscreen

                // Call the fullscreen function
                ReqGameFullscreen();
            }
        });

        $('.show-more-games-button').click(function() {
            $(".gameplay-container").show();
            $('a.hidden').removeClass('hidden');
            $(this).hide();
        });
    });

    function SkipAdAndShowGame() {
        $("#adsContainer").hide();
        $(".game-box").html(iframe);
    }

    $(function() {
        $('.ad300').eq(0).show();
        if ($('.ad300').size() > 1) {
            setInterval(function() {
                var first = $('.ad300').eq(0);
                first.hide();
                $('.ad300').last().after(first);
                $('.ad300').eq(0).fadeIn();
            }, 3000);
        }
        $('.adsmall').eq(0).show();
        if ($('.adsmall').size() > 1) {
            setInterval(function() {
                var first = $('.adsmall').eq(0);
                first.hide();
                $('.adsmall').last().after(first);
                $('.adsmall').eq(0).fadeIn();
            }, 3000);
        }
    })
</script>

{{IMA_SDK}}

<script>
    $(document).ready(function() {
        $("#adsContainer").hide();
        $("#game-box").html(iframe);

        $('.js-ad-box').each(function() {
            var $box = $(this);

            var hasRealAd =
                $box.find('a, img, iframe, script, ins, object, embed').length > 0 ||
                $box.html().indexOf('adsbygoogle') !== -1 ||
                $box.html().indexOf('data-ad-client') !== -1 ||
                $box.html().indexOf('data-ad-slot') !== -1;

            if (hasRealAd) {
                $box.removeClass('hidden').addClass('flex items-center justify-center');
            } else {
                $box.remove();
            }
        });

        $('.js-ad-parent').each(function() {
            var hasRealAd =
                $(this).find('a, img, iframe, script, ins, object, embed').length > 0 ||
                $(this).html().indexOf('adsbygoogle') !== -1 ||
                $(this).html().indexOf('data-ad-client') !== -1 ||
                $(this).html().indexOf('data-ad-slot') !== -1;

            if (!hasRealAd) {
                $(this).remove();
            }
        });
    });
</script>

<!-- <div id="BackTop"></div> -->
</div>

<script src="{{CONFIG_THEME_PATH}}/js/libs/jquery.show-more.js"></script>
<script>
    if (window.innerWidth <= 768) {
        $('#play-game-desc').showMore({
            minheight: 145,
            maxWidth: "100%",
        });
    }
    var cat = "{{CATEGORYID}}";
</script>




<script>
    function showPopup(message) {
        const popup = document.createElement('div');
        popup.className = 'vote-popup';
        popup.textContent = message;
        document.body.appendChild(popup);
        setTimeout(() => popup.classList.add('show'), 10);
        setTimeout(() => {
            popup.classList.remove('show');
            setTimeout(() => popup.remove(), 250);
        }, 2000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.vote-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                var type = this.getAttribute('data-type');
                var gameId = this.getAttribute('data-id');
                var button = this;

                console.log('CLICK', type, gameId);

                fetch('/ajax_vote.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'type=' + encodeURIComponent(type) + '&game_id=' + encodeURIComponent(gameId)
                    })
                    .then(function(response) {
                        return response.text();
                    })
                    .then(function(text) {
                        console.log('RAW RESPONSE:', text);

                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            showPopup('Invalid JSON response');
                            return;
                        }

                        if (data.status === 'ok') {
                            if (document.getElementById('like-count')) {
                                document.getElementById('like-count').innerText = data.likes;
                            }
                            if (document.getElementById('dislike-count')) {
                                document.getElementById('dislike-count').innerText = data.dislikes;
                            }
                            if (document.getElementById('favorite-count')) {
                                document.getElementById('favorite-count').innerText = data.favorites;
                            }

                            button.style.opacity = '0.5';
                            button.style.pointerEvents = 'none';
                            showPopup('Saved');
                        } else if (data.status === 'exists') {
                            button.style.opacity = '0.5';
                            button.style.pointerEvents = 'none';
                            showPopup('Already voted');
                        } else {
                            showPopup(data.message || 'Vote error');
                        }
                    })
                    .catch(function(error) {
                        console.log('FETCH ERROR:', error);
                        showPopup('Request failed');
                    });
            });
        });
    });
</script>

<script>
    function formatNumber(num) {
        num = parseInt(num, 10);
        if (isNaN(num)) return '0';
        if (num >= 1000000000) return (num / 1000000000).toFixed(1).replace('.0', '') + 'B';
        if (num >= 1000000) return (num / 1000000).toFixed(1).replace('.0', '') + 'M';
        if (num >= 1000) return (num / 1000).toFixed(1).replace('.0', '') + 'K';
        return num.toString();
    }

    function showPopup(message) {
        const popup = document.createElement('div');
        popup.className = 'vote-popup';
        popup.textContent = message;
        document.body.appendChild(popup);
        setTimeout(() => popup.classList.add('show'), 10);
        setTimeout(() => {
            popup.classList.remove('show');
            setTimeout(() => popup.remove(), 250);
        }, 2000);
    }

    function setCounts(data) {
        const like = document.getElementById('like-count');
        const dislike = document.getElementById('dislike-count');
        const favorite = document.getElementById('favorite-count');
        const plays = document.getElementById('play-count');

        if (like) like.innerText = formatNumber(data.likes || 0);
        if (dislike) dislike.innerText = formatNumber(data.dislikes || 0);
        if (favorite) favorite.innerText = formatNumber(data.favorites || 0);
        if (plays) plays.innerText = formatNumber(data.plays || 0) + ' plays';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const firstBtn = document.querySelector('.vote-btn');
        if (firstBtn) {
            const gameId = firstBtn.getAttribute('data-id');

            fetch('/ajax_vote.php?action=get_counts&game_id=' + encodeURIComponent(gameId))
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.status === 'ok') {
                        setCounts(data);
                    }
                })
                .catch(function(error) {
                    console.log('COUNT LOAD ERROR:', error);
                });
        }

        document.querySelectorAll('.vote-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                var type = this.getAttribute('data-type');
                var gameId = this.getAttribute('data-id');
                var button = this;

                fetch('/ajax_vote.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'type=' + encodeURIComponent(type) + '&game_id=' + encodeURIComponent(gameId)
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.status === 'ok') {
                            setCounts(data);
                            button.style.opacity = '0.5';
                            button.style.pointerEvents = 'none';
                            showPopup('Saved');
                        } else if (data.status === 'exists') {
                            showPopup(data.message || 'Already voted');
                        } else {
                            showPopup(data.message || 'Vote error');
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                        showPopup('Request failed');
                    });
            });
        });
    });
</script>




<style>
    .report-toast {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.95);
        background: #2f3150;
        color: #fff;
        padding: 12px 18px;
        border-radius: 12px;
        z-index: 10000;
        opacity: 0;
        transition: .25s ease;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .35);
        font-size: 15px;
        font-weight: 600;
    }

    .report-toast.show {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
</style>



<script>
    function showReportToast(message) {
        const toast = document.createElement('div');
        toast.className = 'report-toast';
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 10);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 250);
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('report-open-menu');
        const menu = document.getElementById('report-menu');
        const wrap = document.getElementById('report-dropdown-wrap');

        const modal = document.getElementById('report-modal');
        const overlay = document.getElementById('report-modal-overlay');
        const closeBtn = document.getElementById('report-close-btn');
        const form = document.getElementById('report-form');

        const typeSelect = document.getElementById('report-type');
        const subjectInput = document.getElementById('report-subject');
        const gameIdInput = document.getElementById('report-game-id');
        const gameNameInput = document.getElementById('report-game-name');

        function updateSubject() {
            const type = typeSelect.value;
            const gameName = gameNameInput.value || '';
            const gameId = gameIdInput.value || '';
            subjectInput.value = 'Game ' + type + ' report: ' + gameName + ' ' + gameId;
        }

        function openModal(reportType) {
            const gameId = menuBtn.getAttribute('data-game-id') || '';
            const gameName = menuBtn.getAttribute('data-game-name') || '';

            gameIdInput.value = gameId;
            gameNameInput.value = gameName;
            typeSelect.value = reportType;
            updateSubject();

            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');
            menu.classList.add('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
        }

        if (menuBtn) {
            menuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                menu.classList.toggle('hidden');
            });
        }

        document.querySelectorAll('.report-type-item').forEach(function(item) {
            item.addEventListener('click', function() {
                openModal(this.getAttribute('data-type'));
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (overlay) {
            overlay.addEventListener('click', closeModal);
        }

        document.addEventListener('click', function(e) {
            if (wrap && !wrap.contains(e.target) && modal && !modal.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        if (typeSelect) {
            typeSelect.addEventListener('change', updateSubject);
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                console.log('REPORT FORM DATA:');
                for (const pair of formData.entries()) {
                    console.log(pair[0] + ':', pair[1]);
                }

                fetch('/ajax_report.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(function(response) {
                        console.log('REPORT STATUS:', response.status);
                        console.log('REPORT CONTENT-TYPE:', response.headers.get('content-type'));
                        return response.text();
                    })
                    .then(function(text) {
                        console.log('REPORT RAW RESPONSE START');
                        console.log(text);
                        console.log('REPORT RAW RESPONSE END');

                        let data;
                        try {
                            data = JSON.parse(text.trim());
                        } catch (e) {
                            console.log('JSON PARSE ERROR:', e);
                            showReportToast('Invalid response from server.');
                            return;
                        }

                        if (data.status === 'ok') {
                            closeModal();
                            form.reset();
                            gameIdInput.value = '';
                            gameNameInput.value = '';
                            typeSelect.value = 'Bug';
                            subjectInput.value = '';
                            showReportToast(data.message || 'Your report has been submitted successfully.');
                        } else {
                            showReportToast(data.message || 'Failed to send report.');
                        }
                    })
                    .catch(function(error) {
                        console.log('REPORT ERROR:', error);
                        showReportToast('Request failed.');
                    });
            });
        }
    });
</script>
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
                                    <svg class="ml-2 size-8 fill-white" focusable="false" aria-hidden="true" viewBox="0 0 24 24" width="24" height="24"><path d="M10 15.0657V8.93426C10 8.53491 10.4451 8.29671 10.7773 8.51823L15.376 11.584C15.6728 11.7819 15.6728 12.2181 15.376 12.416L10.7774 15.4818C10.4451 15.7033 10 15.4651 10 15.0657Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 15.0657V8.93426C9.5 8.13556 10.3901 7.65917 11.0547 8.10221L15.6533 11.1679C16.247 11.5638 16.247 12.4362 15.6533 12.8321L11.0547 15.8978C10.3901 16.3408 9.5 15.8644 9.5 15.0657ZM10 8.93426V15.0657C10 15.4651 10.4451 15.7033 10.7774 15.4818L15.376 12.416C15.6728 12.2181 15.6728 11.7819 15.376 11.584L10.7773 8.51823C10.4451 8.29671 10 8.53491 10 8.93426Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"></path></svg>
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
                        <div class="flex items-center gap-4">
                            <div class="game-zoom-btn size-[18px] cursor-pointer" onclick="ReqGameFullscreen();return false;">
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
        
        <div class="flex mt-8 relative items-center justify-center min-h-[90px] mx-auto max-w-[720px] border border-[#28293D] bg-[#181925]">{{ADS_HEADER}}</div>
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
                        gameid : "{{GAME_UNIQUE_ID}}",
                        width  : "100%",
                        height : $( document ).width() < 600 ? "320px" : "480px",
                        color  : "#3f007e"
                    };
                    (function (a, b, c) {
                        var d = a.getElementsByTagName(b)[0];
                        a.getElementById(c) || (a = a.createElement(b), a.id = c, a.src = "https://api.gamemonetize.com/video.js?v=" + Date.now(), d.parentNode.insertBefore(a, d))
                    })(document, "script", "gamemonetize-video-api"); 
                    </script> 
                </div>
            </div>
            <div class="space-y-4 shrink-0 bg-[#1a1b28] p-2 rounded-lg">
                <div class="relative flex items-center justify-center w-[300px] ads300-container border border-[#28293D] h-[600px] bg-[#181925]">{{ADS_SIDEBAR}}</div>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-[340px]">
        <div class="grid grid-cols-5 gap-2 lg:grid-cols-2">
            <div class="relative hidden col-span-2 row-span-2 ads300-container border border-[#28293D] h-[282px] bg-[#181925]">{{ADS_300}}</div>
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
    $(document).ready(function() {
        PlayedGames({{PLAY_GAME_ID}});
    });

    window.setTimeout(function() {
        __upGame_rx8({{PLAY_GAME_ID}})
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
            
            if ($( document ).width() < 1024) {
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

        if ($('.ads300-container').children().length > 0) {
            $('.ads300-container').removeClass('hidden');
            $('.ads300-container').addClass('flex items-center justify-center');
        }
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
<script language="javascript">
    var PageType = "";
    var ids = "";
</script>

<div id="top-section" class="h-[calc(100svh-200px)] md:h-[calc(100svh-300px)] w-full relative text-white">
    <img class="absolute z-10 object-cover object-bottom w-full h-full backdrop-blur-sm opacity-80" src="{{PLAY_GAME_IMAGE}}" loading="lazy" alt="image bg {{PLAY_GAME_NAME}}">
    <video loop="" autoplay="" muted preload="metadata" playsinline="" disableremoteplayback="" disablepictureinpicture="" class="absolute z-20 bottom-[20%] object-cover object-bottom w-full h-full" poster="{{PLAY_GAME_IMAGE}}">
        <source src="{{GAME_VIDEO_URL}}" type="video/mp4">
    </video>
    <div class="h-full w-full absolute bottom-0 z-30 bg-gradient-to-b from-[rgba(19,20,30,0)] via-[rgb(12,13,20)_60%] to-[rgb(12,13,20)_100%]"></div>
    <div class="relative z-40 flex flex-col w-full h-full px-4">
        <div class="flex flex-col items-center justify-end flex-1 w-full space-y-4">
            <img class="w-48 rounded-2xl shadow-[0px_0px_90px_0px_rgb(0,0,0)]" src="{{PLAY_GAME_IMAGE}}" alt="image {{PLAY_GAME_NAME}}">
            <div class="text-2xl font-extrabold">{{PLAY_GAME_NAME}}</div>
            <div class="flex items-center">
                <img class="mr-2 rounded size-4" src="{{PLAY_GAME_CATEGORY_IMAGE}}" alt="image {{PLAY_GAME_CATEGORY_NAME}}">
                {{PLAY_GAME_CATEGORY_NAME}}
            </div>
            <div class="flex items-center justify-center w-10/12 h-12 text-xl font-extrabold rounded-full cursor-pointer bg-violet-600 play-now-button">
                <img class="mr-2 size-7 -mt-0.5" src="/templates/crazygames-like/image/icon-color/joystick.webp" alt="joystick-icon">
                <span>Play now</span>
            </div>
        </div>
    </div>
</div>

<div id="play-game-box" class="hidden">
    <div>{{ADS_SIDEBAR}}</div>
    <div>{{ADS_HEADER}}</div>
    <div>{{ADS_300}}</div>
    <div class="game-container game-col">
        <div class="game-info">
            <div id="loader_container">
                <div id="preloader_box"></div>
            </div>
            <div id="gameDiv">
                <div class="p-1 bg-[#1a1b28] fixed top-0 left-0 w-full z-[99999999]">
                    <div id="exit-button" class="flex items-center py-1 px-1.5 bg-violet-600 text-white text-xs font-extrabold rounded cursor-pointer w-fit">
                        <svg class="fill-white" focusable="false" aria-hidden="true" viewBox="0 0 18 18" width="18" height="18" style="width: 18px; height: 18px; margin-right: 3px;"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 2.25H12.75C13.9926 2.25 15 3.1998 15 4.37143V13.6286C15 14.8002 13.9926 15.75 12.75 15.75H10.5V14.5929H12.75C13.3148 14.5929 13.7727 14.1611 13.7727 13.6286V4.37143C13.7727 3.83887 13.3148 3.40714 12.75 3.40714H10.5V2.25Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3.5873 2.71474C3.24415 2.79292 3 3.10496 3 3.46536V14.5346C3 14.895 3.24415 15.2071 3.5873 15.2853L8.8373 16.4814C9.30569 16.5881 9.75 16.2227 9.75 15.7308V2.26924C9.75 1.77732 9.30569 1.41191 8.8373 1.51862L3.5873 2.71474ZM7.5 10.5379C7.91421 10.5379 8.25 10.0215 8.25 9.38447C8.25 8.74746 7.91421 8.23107 7.5 8.23107C7.08579 8.23107 6.75 8.74746 6.75 9.38447C6.75 10.0215 7.08579 10.5379 7.5 10.5379Z"></path></svg>
                        Exit
                    </div>
                </div>
                <div id="ava-game_container" class="game-box" data-norate="1"></div>
            </div>
        </div>
    </div>
</div>

<div class="px-4 mt-10">
    <div class="grid grid-cols-3 gap-2 md:grid-cols-6 play-games-page-game-list">
        {{PLAY_SIDEBAR_WIDGETS}}
        {{PLAY_SIDEBAR_WIDGETS2}}
        {{PLAY_SIDEBAR_WIDGETS3}}
        <div class="bg-[#373952] text-white md:col-span-6 flex items-center h-10 justify-center col-span-3 rounded-full cursor-pointer text-base font-bold mt-4 show-more-games-button">
            <i class="mr-2 text-xl fa fa-plus" aria-hidden="true"></i>
            Show more games
        </div>
    </div>
    <div class="bg-[#1a1b28] mt-8 p-6 rounded-lg text-white space-y-4">
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
        

    <div class="bg-[#1a1b28] mt-8 p-6 rounded-lg text-white space-y-4">
        <div class="text-xl font-extrabold">Play {{PLAY_GAME_NAME}} {{PLAY_GAME_WALKTHROUGH}}</div>
        <div class="description" id="gamemonetize-video">
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
            function ReqGameFullscreen() {
                let gameElement = document.getElementById('gameDiv');
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

            // Panggil fungsi fullscreen
            ReqGameFullscreen();
            }
        });

        $('#exit-button').click(function(e) {
            $("#play-game-box").addClass("hidden");
            $("#gamePlay-content").show();
            $("#header").show();
            $("#topad").show();
            $("#game-bottom").show();
            $(".play-game-bottom").show();
            $(".tags-walkthrough-container").show();
            $(".h-head").show();
            $(".game-zoom").show();
            $("#game-col").css("margin", "");
            $("#game-col").css("height", "");
            $("#gameDiv").css("height", "");
            $("#gameDiv").css("width", "");
            $("#gameDiv").css("position", "");
            $("#gameDiv").css("top", "");
            $("#gameDiv").css("left", "");
            $("#gameDiv").css("z-index", "");
            $("#ava-game_container").css("height", "");
            $('body').css('overflow', '');
            $('.close-fullscreen').css('display', 'none');
            $('.play-now-button span').text('Continue playing...').css('animation', 'pulse 0.5s cubic-bezier(0.1, 0.2, 0.1, 0.8) 0s infinite alternate both running');
            if (document.exitFullscreen) {
            document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { // Mozilla
            document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { // Webkit
            document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { // IE/Edge
            document.msExitFullscreen();
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
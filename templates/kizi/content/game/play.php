<script language="javascript">
    var PageType = "";
    var ids = "";
</script>
<style type="text/css">
    .fix-top {
        position: relative;
    }

    .h-head {
        height: 0px;
    }

    #footer {
        position: relative;
    }
</style>
<div id="topad" class="fn-clear" style="display: {{ADS_HEADER_DISPLAY}};">
    <div class="adbox bgs fn-left">
        <div class="adtitle">
            <img src="{{CONFIG_THEME_PATH}}/image/bg_a728.png" alt="bg-img">
        </div>
        <div class="ad728">
        {{ADS_HEADER}}
        </div>
    </div>
</div>

<div id="game-col" class="fn-clear" style="margin-top:{{GAME_COL_MARGIN_TOP}}px;">

    <div class="game-left fn-left">
        {{ADS_SIDEBAR}}
        <div class="relategames fn-right">
            Similar Games
            {{PLAY_SIDEBAR_WIDGETS2}}
        </div>


    </div>

    <div class="game-info bgs fn-left">
        <div class="game-info">
            <div id="loader_container">
                <div id="preloader_box"></div>
            </div>
            <div id="gameDiv">

                <div class="gametitle fn-clear">
                     
                    <h1 class="gamename fn-left" title="{{PLAY_GAME_NAME}}"><i class="flag"></i><span>{{PLAY_GAME_NAME}}</span></h1>
                    <div class="game-share  ">
                        
<div class="flex items-center w-full bg-white p-3 rounded-b-xl">
    <div class="flex items-center gap-3 ml-auto">
        
        <div class="play-info-blue">
            <i class="fa-solid fa-gamepad"></i>
            <span>{{PLAY_GAME_PLAYS}} plays</span>
        </div>

        <button class="vote-btn" data-type="like" data-id="{{PLAY_GAME_ID}}">
            <i class="fa-regular fa-thumbs-up"></i>
            <span>{{PLAY_GAME_LIKES}}</span>
        </button>

        <button class="vote-btn" data-type="dislike" data-id="{{PLAY_GAME_ID}}">
            <i class="fa-regular fa-thumbs-down"></i>
            <span>{{PLAY_GAME_DISLIKES}}</span>
        </button>

        <button class="vote-btn" data-type="favorite" data-id="{{PLAY_GAME_ID}}">
            <i class="fa-regular fa-heart"></i>
        </button>   
    </div>
</div>
                        
                        <div class="game-zoom">
                            <a href="#" id="gameFull" title="Play game fullscreen" onclick="GameFullscreen();return false;"></a>
                            
                        </div>
                        
                        
    
 


                        <div class="social"></div>
                    </div>
                </div>

                <div id="ava-game_container" class="game-box" data-norate="1">

                    <div id="gamePlay-content" oncontextmenu="return false" style="position: relative;">
                        <img class="gamePlay-bg" src="{{PLAY_GAME_IMAGE}}" alt="image {{PLAY_GAME_NAME}}">

                        <div class="gamePlay-icon" style="background-image: url({{PLAY_GAME_IMAGE}});background-size: 241px;background-position-x: 50%;background-position-y: 50%;"></div>
                        <div class="gamePlay-button">Play Now!</div>
                        <div class="gamePlay-title">{{PLAY_GAME_NAME}}</div>
                    </div>
                    
                    
                    <div id="pre-count">
                        <font lib="game-loading">Game loading..</font>
                        <div id="pre-count-num">25</div>
                    </div>
                    <div id="game-preloading"></div>
                    <div id="game-preloader"></div>
                    <div id="game-box">
                    </div>

                    <div id="adsContainer">
                        <div id="adContainer"></div>
                        <video id="videoElement"></video>
                    </div>
                </div>
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

    <div class="game-right fn-left">
        <div class="relategames fn-left">
            Similar Games

            {{PLAY_SIDEBAR_WIDGETS}}
        </div>

        {{ADS_SIDEBAR}}
    </div>


</div>

<div class="game-walkthrough bgs fn-clear">
    <p>Play {{PLAY_GAME_NAME}} {{PLAY_GAME_WALKTHROUGH}}</p>
    <hr>
    <div class="description" id="gamemonetize-video">
    </div>
    <script type="text/javascript">
        window.VIDEO_OPTIONS = {
            gameid : "{{GAME_UNIQUE_ID}}",
            width  : "100%",
            height : "480px",
            color  : "#3f007e"
        };
        (function (a, b, c) {
            var d = a.getElementsByTagName(b)[0];
            a.getElementById(c) || (a = a.createElement(b), a.id = c, a.src = "https://api.gamemonetize.com/video.js?v=" + Date.now(), d.parentNode.insertBefore(a, d))
        })(document, "script", "gamemonetize-video-api"); 
    </script>  

</div>
<div id="game-bottom" class="bgs fn-clear">
    <div class="game-dec fn-left">
        <div class="thumb">
            <div style="background-image: url({{PLAY_GAME_IMAGE}});background-size: 241px;background-position-x: 50%;background-position-y:50%;width: 100%;height: 100%;border-radius: 6px;background-repeat:no-repeat;"></div>
        </div>
        <div class="description">
            <p class="pl game-title" style="font-size: 25px !important;">{{PLAY_GAME_NAME}}</p>
            <p class="d-text" style="margin-top:15px;font-size:16px">
                {{PLAY_GAME_DESC}}
            </p>
        </div>
    </div>
    <div class="game-tags" class="fn-right">
        {{PLAY_GAME_TAGS}}
    </div>
</div>

<div id="game-bottom" style="margin-top:20px !important;" class="play-game-bottom flex-similar-games flex-col bgs fn-clear">
    <h2 lib="similar-games">Similar Games</h2>
    {{PLAY_SIDEBAR_WIDGETS3}}
</div>
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
        $('.gamePlay-icon, .gamePlay-button, #gamePlay-content').click(function(e) {  
        SkipAdAndShowGame();
        // $('#adsContainer').show();
        $("#gamePlay-content").hide();
        // $("#adsContainer").hide();
        $("#game-box").html(iframe);
        // $("#game-preloading").show();
        // setTimeout(
        // function() 
        // {
        //     $("#game-preloading").hide();
        //     PreRollAd.start();
        // }, 550);
        });
    });

    function SkipAdAndShowGame() {
        $("#adsContainer").hide();
        $("#game-box").html(iframe);
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

<div id="BackTop"></div>
</div>

<style>
.gametitle{
    display:flex;
    align-items:center;
    justify-content:space-between;
    width:100%;
}

.gamename{
    margin:0;
    float:none !important;
}

.game-share{
    float:none !important;
    display:flex;
    align-items:center;
    gap:12px;
    margin-left:auto;
}

.game-share .flex.items-center.w-full.bg-white.p-3.rounded-b-xl{
    display:flex;
    align-items:center;
    width:auto !important;
    background:transparent !important;
    padding:0 !important;
    border-radius:0 !important;
}

.game-share .flex.items-center.gap-3.ml-auto{
    display:flex;
    align-items:center;
    gap:12px;
    margin-left:0 !important;
}

.game-zoom{
    display:flex;
    align-items:center;
    margin-left:8px;
}

.play-info-blue{
    display:flex;
    align-items:center;
    gap:8px;
    color:#32bbf9;
    font-weight:700;
    font-size:12px;
}

/* blue style like website background */
.vote-btn{
    display:flex;
    align-items:center;
    gap:8px;
    background:transparent !important;
    border:none !important;
    box-shadow:none !important;
    border-radius:14px;
    padding:8px 10px;
    color:#32bbf9;
    cursor:pointer;
    font-weight:700;
}

.vote-btn:hover{
    background:rgba(77,163,255,0.12) !important;
    color:#7fc0ff;
}

.vote-btn i{
    font-size:18px;
}

.vote-btn[data-type="favorite"]{
    padding:8px 10px;
}
</style>

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

    setTimeout(function () {
        popup.classList.add('show');
    }, 10);

    setTimeout(function () {
        popup.classList.remove('show');
        setTimeout(function () {
            popup.remove();
        }, 250);
    }, 2000);
}

function getBtn(type) {
    return document.querySelector('.vote-btn[data-type="' + type + '"]');
}

function setBtnCount(type, value) {
    var btn = getBtn(type);
    if (!btn) return;

    var span = btn.querySelector('span');
    if (!span) {
        span = document.createElement('span');
        btn.appendChild(span);
    }

    span.innerText = formatNumber(value || 0);
}

function setCounts(data) {
    var playCount = document.getElementById('play-count');
    if (playCount) {
        playCount.innerText = formatNumber(data.plays || 0) + ' plays';
    }

    setBtnCount('like', data.likes || 0);
    setBtnCount('dislike', data.dislikes || 0);

    if (typeof data.favorites !== 'undefined') {
        setBtnCount('favorite', data.favorites || 0);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var firstBtn = document.querySelector('.vote-btn');
    if (!firstBtn) return;

    var gameId = firstBtn.getAttribute('data-id');

    fetch('/ajax_vote.php?action=get_counts&game_id=' + encodeURIComponent(gameId))
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.status === 'ok') {
                setCounts(data);
            }
        })
        .catch(function (error) {
            console.log('COUNT LOAD ERROR:', error);
        });

    document.querySelectorAll('.vote-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            var button = this;
            var type = button.getAttribute('data-type');
            var gameId = button.getAttribute('data-id');

            fetch('/ajax_vote.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'type=' + encodeURIComponent(type) + '&game_id=' + encodeURIComponent(gameId)
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.status === 'ok') {
                    setCounts(data);
                    button.style.opacity = '0.5';
                    button.style.pointerEvents = 'none';
                    showPopup(data.message || 'Saved');
                } else if (data.status === 'exists') {
                    button.style.opacity = '0.5';
                    button.style.pointerEvents = 'none';
                    showPopup(data.message || 'Already voted');
                } else {
                    showPopup(data.message || 'Vote error');
                }
            })
            .catch(function (error) {
                console.log('FETCH ERROR:', error);
                showPopup('Request failed');
            });
        });
    });
});
</script>
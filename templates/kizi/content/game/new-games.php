<div class="ad728list">
    {{ADS_TOP}}
</div>
{{GAMES_PLAYED}}

<style>
    .splide-container{
        margin-bottom: 5px;
    }
    .slider {
        height: 200px;
        /* width: 100%; */
        margin: 2em 2em;
        border: 1px solid red;
    }

    .splide-header {
        position: relative
    }
    @keyframes flickerAnimation {

        0%,
        100% {
            opacity: 1
        }

        50% {
            opacity: .5
        }
    }

    @-o-keyframes flickerAnimation {

        0%,
        100% {
            opacity: 1
        }

        50% {
            opacity: .7
        }
    }

    @-moz-keyframes flickerAnimation {

        0%,
        100% {
            opacity: 1
        }

        50% {
            opacity: .7
        }
    }

    @-webkit-keyframes flickerAnimation {

        0%,
        100% {
            opacity: 1
        }

        50% {
            opacity: .7
        }
    }

    .animate-flicker {
        -webkit-animation: 1s infinite flickerAnimation;
        -moz-animation: 1s infinite flickerAnimation;
        -o-animation: 1s infinite flickerAnimation;
        animation: 1s infinite flickerAnimation
    }

    .splide .fillBox {
        background-color: #0000000f !important
    }

    .splide .slider_item img {
        -o-object-fit: fill !important;
        object-fit: fill !important
    }

    .splide .slider_item {
        margin-right: 15px;
        /* width: 180px !important;
        height: 135px !important; */
        /* background-color: #0c0d14 !important; */
    }

    .splide .slider_item:hover {
        /* box-shadow: 0 8px 6px -6px #0000006e !important; */
        /* transform: scale(1.15) translate(0, 0) !important */
    }

    .splide__track {
        padding: 0 25px !important;
        overflow-x: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .splide__track::-webkit-scrollbar {
        display: none;
    }

    .splide {
        margin: -5px auto 0;
        width: 100%;
        visibility: visible !important
    }

    .splide__list {
        /* height: 165px; */
        align-items: center
    }

    .splide .item_game:hover {
        z-index: 20 !important
    }

    .splide-header {
        display: flex;
        align-items: center;
        width: 100%;
        margin-left: 2em;
        margin-bottom: 1em;
        z-index: 2
    }

    .splide-header p {
        color: white;
        font-size: 1.2rem;
        font-weight: 900;
        margin: 0
    }

    .splide-header a {
        color: white;
        font-size: .9em;
        margin-left: 1em;
        font-weight: 700
    }

    .splide__arrow--prev {
        left: 0
    }

    .splide__arrow--next {
        right: 0
    }

    .splide__arrow {
        -ms-flex-align: center;
        align-items: center;
        background: #000;
        border: 0;
        border-radius: 0;
        cursor: pointer;
        display: -ms-flexbox;
        display: flex;
        height: 100%;
        -ms-flex-pack: center;
        justify-content: center;
        opacity: 0;
        padding: 0;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 2.5em;
        z-index: 1;
        transition: opacity .25s, background-color .25s
    }

    .splide__arrow svg {
        fill: #f4f8fb;
        height: 1.5em;
        width: 1.5em
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // lazyLoadObserver(), 
        $("#csGridSistem .item_game .test").mouseenter(function() {
            $(this).css("border", "2px solid rgb(110 95 170)"), $(this).parent().css("z-index", "30")
        }), $("#csGridSistem .item_game .test").mouseleave(function() {
            $(this).css("border", "none"), $(this).parent().css("z-index", "10")
        }), $(document).on("mouseenter", ".slider_item.test", function() {
            $(this).css("border", "2px solid rgb(110 95 170)")
        }), $(document).on("mouseleave", ".slider_item.test", function() {
            $(this).css("border", "none")
        }), $(".splide__list").hover(function() {
            if (!$(this).hasClass("loaded")) {
                $(this).addClass("loaded");
                var e = $(this).attr("id"),
                    s = $(this).data("slider_id"),
                    t = $(this).data("slider_special_type");

                $("#" + e).append(s);
                var t = e.split("-");
                $("#" + (t = t[0]) + " .fillBox").remove(), new Splide("#" + t, {
                    perPage: 7,
                    rewind: !1,
                    autoWidth: !0,
                    gap: "15px",
                    pagination: !1
                }).mount();

                // $.ajax({
                //     url: "ajax/getCompleteSliderGames",
                //     type: "post",
                //     dataType: "json",
                //     data: {
                //         slider_id: s,
                //         slider_special_type: t
                //     },
                //     success: function(s) {

                //     },
                //     error: function(e, s, t) {
                //         console.log(e), console.log(t)
                //     }
                // })
            }
        }), $(document).on("mouseenter", ".splide__slide", function() {
            var e = $(this).attr("id");
            $("#" + (e = e.split("-")[0]) + " .splide__arrow").css("opacity", ".5")
        }), $(document).on("mouseleave", ".splide__slide", function() {
            var e = $(this).attr("id");
            $("#" + (e = e.split("-")[0]) + " .splide__arrow").css("opacity", "0")
        }), $(document).on("mouseenter", ".splide__arrow", function() {
            var e = $(this).attr("aria-controls");
            $("#" + (e = e.split("-")[0]) + " .splide__arrow").css("opacity", ".9")
        }), $(document).on("mouseleave", ".splide__arrow", function() {
            var e = $(this).attr("aria-controls");
            $("#" + (e = e.split("-")[0]) + " .splide__arrow").css("opacity", "0")
        })
    });
</script>

{{ALL_SPLIDE_CONTAINERS}}

<!-- <div class="splide-container">
    <div class="splide-header">
        <p>Girls</p> <a href="https://www.kizi10.org/home/keyword/girls">View more</a>
    </div>
    <div class="splide splide--slide splide--ltr splide--draggable is-active is-initialized" id="splide_3">
        <div class="splide__arrows"><button class="splide__arrow splide__arrow--prev" type="button" aria-controls="splide_3-track" disabled="" aria-label="Previous slide" style="opacity: 0;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                    <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                </svg></button><button class="splide__arrow splide__arrow--next" type="button" aria-controls="splide_3-track" aria-label="Next slide" style="opacity: 0;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                    <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                </svg></button></div>
        <div class="splide__track" id="splide_3-track" style="padding-left: 0px; padding-right: 0px;">
            <ul class="splide__list gameList" id="splide_3-list" style="transform: translateX(0px);" data-slider_id="11" data-slider_special_type="">
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
                <li class="post splide__slide item_game slider_item">
                    <a href="https://www.insanegamesonline.com/game/ace-car-racing" class="game-item">
                        <img src="https://img.gamemonetize.com/mgb8g6m8oc5zonl9ii1fjdv1ua3xjady/512x384.jpg" alt="Ace Car Racing">
                        <p class="post-name" data-url="https://www.youtube.com/watch?v=fiVjltNvS6A" data-scale="1.2" data-translate="-23px,-25px" style="display: none;">Ace Car Racing</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div> -->

<div id="content">

    {{ADS_300}}

    {{NEW_GAMES_LIST}}
</div>

<div class="bgs bottomtext fn-clear" style="padding:20px; width:90% !important;">
    {{FOOTER_DESCRIPTION}}
</div>

<script>
    $( document ).ready(function() {
        $('#300x250-main-ads').css({ display: "inline-block" });
    });
</script>
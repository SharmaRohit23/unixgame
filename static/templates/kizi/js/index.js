$(function () {
    // Registration form
    $('.signup-form').ajaxForm({
        url: Ajaxrequest() + '?t=register',
        beforeSend: function () {
            signup_form = $('.signup-form');
            signup_button = signup_form.find('.submit-btn');
            signup_button.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                window.location = data.redirect_url;
            } else {
                signup_button.attr('disabled', false);
                Toast.error(data.error_message);
            }
        }
    });

    // Login form
    $('.signin-form').ajaxForm({
        url: Ajaxrequest() + '?t=login',
        beforeSend: function () {
            var is_recaptcha = $(this).attr('data-recaptcha');
            if (is_recaptcha == "yes") {
                grecaptcha.reset()
            }
            signup_form = $('.signin-form');
            signup_button = signup_form.find('.submit-btn');
            signup_button.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                window.location = data.redirect_url;
            } else {
                signup_button.attr('disabled', false);
                Toast.error(data.error_message);
            }
        }
    });

    // Secure login form
    $('.securelogin-form').ajaxForm({
        url: Ajaxrequest() + '?t=login&a=secure_idlogin',
        beforeSend: function () {
            signup_form = $('.securelogin-form');
            signup_button = signup_form.find('.submit-btn');
            signup_button.attr('disabled', true);
        },
        success: function (data) {
            if (data.status == 200) {
                window.location = data.redirect_url;
            } else {
                signup_button.attr('disabled', false);
                Toast.error(data.error_message);
            }
        }
    });

    var page = 2;
    // Blogs
    $('.blog-load-more').click(function () {
        $.ajax({
            type: "POST",
            url: Ajaxrequest() + '?t=blogs&a=loadmore',
            data: {
                page: page
            },
            success: function (data) {
                if (data.status == 200) {
                    // console.log(data);
                    $('.blog-load-more').before(data.blogs);
                    page = data.page;
                } else {
                    // console.log('errpr');
                }
            }
        });
    });

    $(document).on('mouseenter', '.game-item', function () {
        // var video_url = $(this).children('.post-name').attr("data-url");
        // var unique_code = video_url.split('?v=');
        // var scale = $(this).children('.post-name').attr("data-scale");
        // var translate = $(this).children('.post-name').attr("data-translate");
        // if (video_url.length > 0 && unique_code.length > 1) {
        //     $(this).children('.post-name').attr("style", "display: inline;z-index: 10;color: white;background: black;opacity: 0.8;bottom: 3px;");
        //     $(this).children('.post-name').before(`<div class='game-item-video'>
        //     <iframe width="230" height="190" src="https://www.youtube.com/embed/${unique_code[1]}?autoplay=1&mute=1&controls=0&loop=1&modestbranding=1" style="transform: scale(${scale}) translate(${translate});pointer-events: none;" frameborder="0"></iframe>
        //     </div>`);
        //     setTimeout(function (thisValue) {
        //         hidePostName(thisValue);
        //     }, 2000, this);
        // }

        if (this.querySelector('.video-container')) return; // Cegah duplikasi video

        const videoUrl = this.getAttribute('data-wt-video');
        if (videoUrl.includes('/games-thumb')) {
            const videoContainer = document.createElement('div');
            videoContainer.className = "game-item-video";

            const videoElement = document.createElement('video');
            videoElement.src = videoUrl;
            videoElement.autoplay = true;
            videoElement.muted = true;
            videoElement.loop = true;
            videoElement.playsInline = true;
            videoElement.preload = "metadata"; // Hanya pre-load metadata, bukan seluruh video
            videoElement.playbackRate = 2.0;

            videoContainer.appendChild(videoElement);
            this.appendChild(videoContainer);

            if (this.querySelector('.gameicon')) {
                const gameIcon = this.querySelector('.gameicon');
                videoContainer.style.width = `${gameIcon.offsetWidth - 2}px`;
                videoContainer.style.height = `${gameIcon.offsetHeight - 2}px`;
                videoContainer.style.top = "1px";
                videoContainer.style.left = "50%";
                videoContainer.style.transform = "translateX(-50%)";
            }

            $(this).children('.post-name').attr("style", "display: inline;z-index: 10;color: white;");
            setTimeout(function (thisValue) {
                hidePostName(thisValue);
            }, 2000, this);
        }
    });

    function hidePostName(element) {
        $(element).children('.post-name').attr("style", "display: none;");
    }

    $(document).on('mouseleave', '.game-item', function () {
        $(this).children('.game-item-video').remove();
        $(this).children('.post-name').attr("style", "");
    });

});
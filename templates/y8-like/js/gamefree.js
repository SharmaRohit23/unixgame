$(function () {

    var popupHideDelay;
    $(".submenu").mouseenter(function (e) {
        var self = $(this);
        var a = self.find("a:first-child");
        var s = self.find(".menupopup");
        s.removeClass("fn-hide");
        a.addClass("active");
        clearTimeout(popupHideDelay);
    }).mouseleave(function () {
        var self = $(this);
        var a = self.find("a:first-child");
        var s = self.find(".menupopup");
        popupHideDelay = setTimeout(function () {
            s.addClass("fn-hide");
            a.removeClass("active");
        }, 10);
    });
    $(".menupopup").mouseenter(function () {
        clearTimeout(popupHideDelay);
    }).mouseleave(function () {
        var self = this;
        popupHideDelay = setTimeout(function () {
            $(self).addClass("fn-hide");
        }, 10);
    });
    $(".menu li").mouseover(function () {
        $(this).find(".tooltip").removeClass("fn-hide");
    })
    $(".menu li").mouseout(function () {
        $(this).find(".tooltip").addClass("fn-hide");
    })
    $('.menu-btn.new-games').on('click', function () {
        $('.new-games-pop-up').toggleClass('fn-hide');
        event.stopPropagation();
    });

    $(document).on('click', function () {
        $('.new-games-pop-up').addClass('fn-hide');
    });

    $('.new-games-pop-up').on('click', function (event) {
        event.stopPropagation(); // Mencegah event bubbling agar klik di dalam pop-up tidak menutup pop-up
    });

    // Show the new games pop-up when the menu icon is clicked
    $('.menu-mobile i:contains("menu")').click(function () {
        // hide search form
        $('.search-form').css('display', 'none');
        $('.right-btn-mobile .search-btn').css('display', 'block');

        // Show the pop-up
        $('.new-games-pop-up-mobile').removeClass('fn-hide');
        // Hide the menu icon and show the close icon
        $(this).addClass('fn-hide');
        $('.menu-mobile i:contains("close")').removeClass('fn-hide');
    });

    // Hide the pop-up when the close icon is clicked
    $('.menu-mobile i:contains("close")').click(function () {
        // Hide the pop-up
        $('.new-games-pop-up-mobile').addClass('fn-hide');
        // Show the menu icon again and hide the close icon
        $(this).addClass('fn-hide');
        $('.menu-mobile i:contains("menu")').removeClass('fn-hide');
    });

    $(window).on('scroll', function () {
        if (!$('.new-games-pop-up-mobile').hasClass('fn-hide')) {
            // Jika pop-up tidak di-hide, ubah posisinya menjadi static
            $('.new-games-pop-up-mobile').addClass('static-position');
        } else {
            // Jika pop-up di-hide, kembalikan ke posisi fixed
            $('.new-games-pop-up-mobile').removeClass('static-position');
        }
    });

    // Hide the pop-up when clicking outside of the pop-up area
    $(document).click(function (event) {
        var target = $(event.target);

        // Check if the clicked target is not part of the menu or pop-up area
        if (!target.closest('.menu-mobile, .new-games-pop-up-mobile').length) {
            // Hide the pop-up and reset icons
            $('.new-games-pop-up-mobile').addClass('fn-hide');
            $('.menu-mobile i:contains("close")').addClass('fn-hide');
            $('.menu-mobile i:contains("menu")').removeClass('fn-hide');
        }
    });

    // Prevent the menu or pop-up from closing when clicking inside them
    $('.menu-mobile, .new-games-pop-up-mobile').click(function (event) {
        event.stopPropagation();
    });

    // Function to handle search button behavior based on window width
    function handleSearchFunctionality() {
        if ($(window).width() <= 600) {
            // Show the search form when the search button is clicked and hide the search button itself
            $('.right-btn-mobile .search-btn').off('click').on('click', function () {
                // hide new games pop-up
                $('.new-games-pop-up-mobile').addClass('fn-hide');
                $('.menu-mobile i:contains("close")').addClass('fn-hide');
                $('.menu-mobile i:contains("menu")').removeClass('fn-hide');

                // Show the search form
                $('.search-form').css('display', 'block');

                // Hide the search button
                $(this).css('display', 'none');
            });

            // Hide the search form and show the search button again only if the search form is displayed
            $(document).off('click').on('click', function (event) {
                var target = $(event.target);

                // Check if the clicked target is not part of the search area or search button
                if (!target.closest('.search-form, .search-btn').length) {
                    // Check if the search form is currently displayed as block
                    if ($('.search-form').css('display') === 'block') {
                        // Hide the search form
                        $('.search-form').css('display', 'none');

                        // Show the search button again
                        $('.right-btn-mobile .search-btn').css('display', 'block');
                    }
                }
            });

            // Prevent the search form from hiding when clicking inside it
            $('.search-form').off('click').on('click', function (event) {
                event.stopPropagation();
            });
        } else {
            // Remove the custom click events for larger screens
            $('.right-btn-mobile .search-btn').off('click');
            $(document).off('click');
            $('.search-form').off('click');
        }
    }

    // Call the function on document ready and when window is resized
    handleSearchFunctionality();
    $(window).resize(function () {
        handleSearchFunctionality();
    });
})


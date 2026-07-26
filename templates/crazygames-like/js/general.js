// 
function __upGame_rx8(id) {
    $.ajax({
        url: Ajaxrequest() + '?t=gameplayed',
        type: 'POST',
        data: "gid=" + id
    });
}

/* FULLSCREEN FUNC */
function initFullScreen(fscreenToThis) {
    if (BigScreen.enabled) {
        BigScreen.request($(fscreenToThis)[0]);
    } else {
        alert("This browser doesn't support full screen");
    }
}

function __sGame() {
    $('.gmDisplay').show();
    $('._Ad-game').remove();
}

var __AdRNum = 6; // seconds to remove ads
function __AdRemoveCount() {
    if (__AdRNum != 0) {
        __AdRNum -= 1
        $('.rAdNum').text(__AdRNum);
    } else {
        $('.__r-Ad-1').css('display', 'none');
        $('.__r-Ad-2').css('display', 'inherit');
        $('._removeAd').attr('onclick', '__sGame()');
        $('._removeAd').attr('disabled', false);
        return false;
    }
    window.setTimeout(function () { __AdRemoveCount() }, 1000);
}

function __adCountD() {
    if (__AdNum != 0) {
        __AdNum -= 1
        $('.Adnum').text(__AdNum);
    } else {
        __sGame();
        return false;
    }
    window.setTimeout(function () { __adCountD() }, 1000);
}

function __sendReport(gid) {
    swal({
        title: "",
        text: "¿Tell us, what is your problem?",
        imageUrl: siteUrl + "/templates/modern/image/icon-color/worker.png",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Write the problem here in detail..."
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("You need to write something!");
            return false
        }

        $.ajax({
            url: Ajaxrequest() + '?t=send_report',
            type: 'POST',
            data: "gid=" + gid + "&report=" + inputValue,
            success: function (data) {
                if (data.status == 200) {
                    swal("", data.success_message, "success");
                } else {
                    swal("", data.error_message, "error");
                }
            }
        });
    });

}

$(function () {
    /* SEARCH AREA */
    $('#search-data-form').ajaxForm({
        url: Ajaxrequest() + '?t=search',
        type: 'POST',
        success: function (data) {
            startLoadbar();
            Loadlink(data.redirect_url);
            stopLoadbar();
        },
        error: function () {
            console.log('Connection failed!');
        }
    });

    /* FULLSCREEN BUTTON */
    $(document).on('click', '.initFullScreen', function () {
        initFullScreen($(this).attr('data-fullscreen-item'));
    });

    $(document).on('click', '#report-btn', function () {
        var gid_sR2 = $(this).attr('data-report');
        __sendReport(gid_sR2);
    });

    /* SHARE BUTTONS */
    $(document).on('click', '#share-btn', function (e) {
        e.preventDefault();
        var Dragon__socialURl_r2 = $(this).attr('data-share-url');
        window.open(
            '' + Dragon__socialURl_r2 + '',
            'Share',
            'toolbar=0, status=0, width=650, height=450'
        );
    });

    /* OVERLAY TOGGLE */
    $(document).on('click', '.overlay-toggle', function (e) {
        e.preventDefault();
        var data_target = $(this).attr('data-target');
        $(data_target).toggleClass('overlay-open');
        $('body').toggleClass('state-overlay-open');
        $(data_target).attr('data-status', function (_, attr) {
            return attr == 'closed' ? 'opened' : 'closed';
        });
    });

    $(document).on('click', '.overlay-wrapper', function (e) {
        if (e.target == this) {
            $(this).toggleClass('overlay-open');
            $('body').toggleClass('state-overlay-open');
            $(this).attr('data-status', function (_, attr) {
                return attr == 'closed' ? 'opened' : 'closed';
            });
        }
    });

});

(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o), m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
(function () {
    ga('create', 'UA-154497915-1', 'auto');
    ga('send', 'pageview');
})();

(function (a, b, c) {
    var d = a.getElementsByTagName(b)[0];
    a.getElementById(c) || (a = a.createElement(b), a.id = c, a.src = "https://api.gamemonetize.com/cms_api.js?" + new Date().valueOf(), d.parentNode.insertBefore(a, d))
})(document, "script", "gamemonetize-cms");


document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('Search-InArea');
    const searchResults = document.getElementById('search-results');
    const sidebar = document.getElementById('sidebar');
    const clearSearch = document.getElementById('clear-search');

    const searchInputTablet = document.getElementById('Search-InArea-tablet');
    const searchResultsTablet = document.getElementById('search-results-tablet');

    const searchInputDesktop = document.getElementById('Search-InArea-desktop');
    const searchResultsDesktop = document.getElementById('search-results-desktop');

    function debounce(func, delay) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    function fetchSearchResults(query, resultsElement, clearElement) {
        fetch(`/search-handler/${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');

                const gameLinks = doc.querySelectorAll('a[href*="/game/"]');

                const gameList = Array.from(gameLinks)
                    .map(a => `
                    <a href="${a.href}" class="flex items-center text-[15px] text-white w-full py-2 hover:bg-[#373952]">
                        ${a.innerHTML}
                    </a>
                `).join('');

                const viewAllResultsLink = `
                <a href='/search/${encodeURIComponent(query)}' class='block mx-4 mt-5 text-center text-[15px] text-white' aria-label='View all results'>View all results</a>
            `;

                resultsElement.innerHTML = gameList + viewAllResultsLink;
                resultsElement.classList.remove('hidden');
                if (window.innerWidth >= 1024) document.getElementById('search-result-desktop-bg').classList.remove('hidden');
                clearElement.classList.remove('hidden');
                if (sidebar && window.innerWidth < 1024) sidebar.style.display = 'none';
            })
            .catch(error => console.error('Error fetching search results:', error));
    }

    const debouncedSearch = debounce((query) => fetchSearchResults(query, searchResults, clearSearch), 300);
    const debouncedSearchTablet = debounce((query) => fetchSearchResults(query, searchResultsTablet, clearSearch), 300);
    const debouncedSearchDesktop = debounce((query) => fetchSearchResults(query, searchResultsDesktop, clearSearch), 300);

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            debouncedSearch(query);
        } else {
            searchResults.classList.add('hidden');
            clearSearch.classList.add('hidden');
            searchResults.innerHTML = '';
            if (sidebar) sidebar.style.display = 'block';
        }
    });

    searchInputTablet.addEventListener('input', function () {
        const query = searchInputTablet.value.trim();
        if (query.length > 2) {
            debouncedSearchTablet(query);
        } else {
            searchResultsTablet.classList.add('hidden');
            clearSearch.classList.add('hidden');
            searchResultsTablet.innerHTML = '';
            if (sidebar) sidebar.style.display = 'block';
        }
    });

    searchInputDesktop.addEventListener('input', function () {
        const query = searchInputDesktop.value.trim();
        if (query.length > 2) {
            debouncedSearchDesktop(query);
        } else {
            searchResultsDesktop.classList.add('hidden');
            searchResultsDesktop.innerHTML = '';
            if (window.innerWidth >= 1024) document.getElementById('search-result-desktop-bg').classList.add('hidden');
        }
    });

    clearSearch.addEventListener('click', function () {
        searchInput.value = '';
        searchResults.classList.add('hidden');
        clearSearch.classList.add('hidden');
        searchResults.innerHTML = '';
        if (sidebar) sidebar.style.display = 'block';
    });

    clearSearch.addEventListener('click', function () {
        searchInputTablet.value = '';
        searchResultsTablet.classList.add('hidden');
        clearSearch.classList.add('hidden');
        searchResultsTablet.innerHTML = '';
        if (sidebar) sidebar.style.display = 'block';
    });

    $('#back-button').click(function () {
        if (window.innerWidth < 768) {
            $('#sidebar-menu').addClass('hidden');
            $('#sidebar-menu').removeClass('flex');
        } else if (window.innerWidth < 1024) {
            $('#sidebar-menu').addClass('md:-left-full');
        }
    })

    $('#mobile-search-button').click(function () {
        if (window.innerWidth < 768) {
            $('#sidebar-menu').removeClass('hidden');
            $('#sidebar-menu').addClass('flex');
            $('#Search-InArea').focus();
        }
    })

    $('#tablet-search-button').click(function () {
        $('#sidebar-menu').removeClass('md:-left-full');
    })

    $('#desktop-menu-button').click(function () {
        if ($('#sidebar-menu').hasClass('lg:left-0')) {
            $('#sidebar-menu').removeClass('lg:left-0');
            document.querySelector('#desktop-menu-button svg').classList.add('scale-x-[-1]');
            document.querySelector('div.px-4.pt-20.pb-5').classList.remove('lg:pl-20')
        } else {
            $('#sidebar-menu').addClass('lg:left-0');
            document.querySelector('#desktop-menu-button svg').classList.remove('scale-x-[-1]');
            document.querySelector('div.px-4.pt-20.pb-5').classList.add('lg:pl-20');
        }
    });

    $(document).on('click', '.splide-arrow-right', function () {
        const container = this.closest('.mb-6').querySelector('.splide-items-container');
        container.scrollBy({ left: 272, behavior: 'smooth' });
    });

    // Pastikan video hanya ditambahkan sekali
    if (/Mobi|Android/i.test(navigator.userAgent) && window.location.pathname === '/') {
        let activeCarouselIndex = 0;
        let currentCarouselPlayer = null;
        let newGamePlayers = {};

        function createVideoPlayer(container, videoUrl) {
            if (!container || !videoUrl) return;
            container.innerHTML = `<video src="${videoUrl}" class="absolute scale-[1.2] object-cover object-center w-full h-full" autoplay muted loop playsinline></video>`;
        }

        function observeNewGameVideos(entries) {
            entries.forEach(entry => {
                const element = entry.target;
                const imgTag = element.querySelector('img');
                if (!imgTag) return;

                const gameId = imgTag.src.split('/')[3];

                if (entry.isIntersecting) {
                    if (!newGamePlayers[gameId]) {
                        const videoUrl = element.getAttribute('data-wt-video');
                        if (videoUrl && videoUrl.includes('.mp4')) {
                            const videoContainer = document.createElement('div');
                            videoContainer.className = "absolute inset-0 z-10 object-cover object-center overflow-hidden video-container rounded-2xl";
                            element.appendChild(videoContainer);
                            newGamePlayers[gameId] = createVideoPlayer(videoContainer, videoUrl);
                        }
                    }
                } else {
                    if (newGamePlayers[gameId]) {
                        delete newGamePlayers[gameId];
                    }
                    element.querySelector('.video-container')?.remove();
                }
            });
        }

        const newGameObserver = new IntersectionObserver(observeNewGameVideos, {
            root: null,
            rootMargin: "0px",
            threshold: 0.5
        });

        document.querySelectorAll('.new-games-list').forEach((element, index) => {
            if (window.innerWidth < 768) {
                if ((index + 1) % 5 === 0) {
                    newGameObserver.observe(element);
                }
            } else if (window.innerWidth < 1024) {
                if ([5, 6, 11, 12, 17, 18, 23, 24].includes(index + 1)) {
                    newGameObserver.observe(element);
                }
            }
        });

        function observeCarousel(entries) {
            entries.forEach(entry => {
                const carousel = entry.target;
                if (!carousel) return;
                const items = carousel.querySelectorAll('.home-top-games-list');

                if (entry.isIntersecting) {
                    restartCarouselVideo(items);
                } else {
                    stopCarouselVideos(items);
                }
            });
        }

        function restartCarouselVideo(items) {
            const newIndex = Math.round(carousel.scrollLeft / items[0].offsetWidth);
            activeCarouselIndex = newIndex;
            updateCarouselVideos(items);
        }

        function updateCarouselVideos(items, dotsContainer) {
            items.forEach((item, i) => {
                const imgTag = item.querySelector('img');
                if (!imgTag) return;
                const existingVideoContainer = item.querySelector('.video-container');

                if (!dotsContainer) return;

                dotsContainer.children[i].classList.toggle('opacity-50', i !== activeCarouselIndex);

                if (i === activeCarouselIndex) {
                    if (!existingVideoContainer) {
                        const videoUrl = item.getAttribute('data-wt-video');
                        if (videoUrl && videoUrl.includes('.mp4')) {
                            const videoContainer = document.createElement('div');
                            videoContainer.className = "absolute inset-0 z-10 object-cover object-center overflow-hidden video-container rounded-2xl";
                            item.appendChild(videoContainer);
                            currentCarouselPlayer = createVideoPlayer(videoContainer, videoUrl);
                        }
                    }
                } else {
                    item.querySelector('.video-container')?.remove();
                }
            });
        }

        function stopCarouselVideos(items) {
            if (currentCarouselPlayer) {
                currentCarouselPlayer = null;
            }
            items.forEach(item => item.querySelector('.video-container')?.remove());
        }

        const carousel = document.querySelector('.home-top-games-list-carousel');
        if (carousel) {
            const carouselObserver = new IntersectionObserver(observeCarousel, {
                root: null,
                rootMargin: "0px",
                threshold: 0.5
            });
            carouselObserver.observe(carousel);

            const items = carousel.querySelectorAll('.home-top-games-list');
            const dotsContainer = document.createElement('div');
            dotsContainer.id = 'carousel-dots';
            dotsContainer.classList.add('flex', 'justify-center', 'mt-1');
            carousel.parentNode.insertBefore(dotsContainer, carousel.nextSibling);

            items.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.classList.add('size-[7px]', 'rounded-full', 'opacity-50', 'bg-white', 'cursor-pointer', 'mx-2');
                if (index === 0) dot.classList.remove('opacity-50');
                dot.addEventListener('click', () => {
                    carousel.scrollTo({ left: index * items[0].offsetWidth, behavior: 'smooth' });
                });
                dotsContainer.appendChild(dot);
            });

            window.addEventListener("load", () => {
                const firstItem = items[0];
                const imgTag = firstItem.querySelector('img');
                if (imgTag) {
                    const videoUrl = firstItem.getAttribute('data-wt-video');
                    if (videoUrl && videoUrl.includes('.mp4')) {
                        const videoContainer = document.createElement('div');
                        videoContainer.className = "absolute inset-0 z-10 object-cover object-center overflow-hidden video-container rounded-2xl";
                        firstItem.appendChild(videoContainer);
                        currentCarouselPlayer = createVideoPlayer(videoContainer, videoUrl);
                    }
                }
            });

            carousel.addEventListener('scroll', () => {
                const newIndex = Math.round(carousel.scrollLeft / items[0].offsetWidth);
                if (newIndex !== activeCarouselIndex) {
                    activeCarouselIndex = newIndex;
                    updateCarouselVideos(items, dotsContainer);
                }
            });

            window.addEventListener("scroll", () => {
                const rect = carousel.getBoundingClientRect();
                if (rect.top >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)) {
                    restartCarouselVideo(items);
                }
            });
        }
    }

    // SHOW MORE BUTTON
    $(document).on('click', '.show-more-button', function () {
        const parentDiv = $(this).closest('.flex');
        const descriptionDiv = parentDiv.find('.truncated-description');

        if (descriptionDiv.hasClass('truncate')) {
            descriptionDiv.removeClass('truncate w-8/12');
            parentDiv.removeClass('items-center');
            parentDiv.addClass('flex-col items-start');
            $(this).removeClass('ml-2');
            $(this).text('Show less');
        } else {
            descriptionDiv.addClass('truncate w-8/12');
            parentDiv.addClass('items-center');
            parentDiv.removeClass('flex-col items-start');
            $(this).addClass('ml-2');
            $(this).text('Show more');
        }
    });

    // Ensure "Show more" button is visible if the description is truncated
    $('.truncated-description').each(function () {
        if (this.scrollWidth > this.clientWidth) {
            $(this).siblings('.show-more-button').removeClass('hidden');
        } else {
            $(this).siblings('.show-more-button').addClass('hidden');
        }
    });

    if (window.location.pathname === '/' && window.innerWidth >= 1024) {

        $(document).on('click', '.modal-footer-open', function () {
            $('.modal-footer').removeClass('hidden').addClass('flex');
        });

        $(document).on('click', '.modal-close, .modal-footer', function (e) {
            if ($(e.target).is('.modal-close, .modal-footer')) {
                $('.modal-footer').removeClass('flex').addClass('hidden');
            }
        });

        $(document).on('click', '.modal-close', function (e) {
            $('.modal-footer').removeClass('flex').addClass('hidden');
        });

        const container = document.querySelector('.home-top-games-list-carousel');
        const gamelist = $('.home-top-games-list-carousel a');

        $(document).on('click', '#top-home-desktop-arrow-right', function () {
            for (let index = 0; index < gamelist.length; index++) {
                if (gamelist[index].getBoundingClientRect().x + gamelist[index].getBoundingClientRect().width > container.clientWidth) {
                    container.scrollTo({ left: gamelist[index].offsetLeft - 48, behavior: 'smooth' });
                    break;
                }
            }
        });

        $(document).on('click', '#top-home-desktop-arrow-left', function () {
            let veryLeftGameListIndex = 0;
            for (let index = gamelist.length - 1; index >= 0; index--) {
                veryLeftGameListIndex = index;
                if (gamelist[index].getBoundingClientRect().x < -container.clientWidth) {
                    break;
                }
            }
            container.scrollTo({ left: veryLeftGameListIndex === 0 ? -container.clientWidth : gamelist[veryLeftGameListIndex].offsetLeft - 48, behavior: 'smooth' });
        });

        const updateArrowsVisibility = () => {
            const container = document.querySelector('.home-top-games-list-carousel');
            const leftArrow = document.getElementById('top-home-desktop-arrow-left');
            const rightArrow = document.getElementById('top-home-desktop-arrow-right');

            if (container.scrollLeft === 0) {
                leftArrow.classList.remove('group-hover:flex');
            } else {
                leftArrow.classList.add('group-hover:flex');
            }

            if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                rightArrow.classList.remove('group-hover:flex');
            } else {
                rightArrow.classList.add('group-hover:flex');
            }
        };

        document.querySelector('.home-top-games-list-carousel').addEventListener('scroll', updateArrowsVisibility);
        window.addEventListener('resize', updateArrowsVisibility);
        updateArrowsVisibility();


        $(document).on('click', '.splide-arrow-right', function () {
            const container = $(this).parent().find('.splide-items-container')[0];
            const gamelist = $(this).parent().find('.splide-items-container a');
            for (let index = 0; index < gamelist.length; index++) {
                if (gamelist[index].getBoundingClientRect().x + gamelist[index].getBoundingClientRect().width > container.clientWidth) {
                    container.scrollTo({ left: gamelist[index].offsetLeft - 48, behavior: 'smooth' });
                    break;
                }
            }
        });

        $(document).on('click', '.splide-arrow-left', function () {
            const container = $(this).parent().find('.splide-items-container')[0];
            const gamelist = $(this).parent().find('.splide-items-container a');
            let veryLeftGameListIndex = 0;
            for (let index = gamelist.length - 1; index >= 0; index--) {
                veryLeftGameListIndex = index;
                if (gamelist[index].getBoundingClientRect().x < -container.clientWidth) {
                    break;
                }
            }
            container.scrollTo({ left: gamelist[veryLeftGameListIndex].getBoundingClientRect().offsetLeft - 48, behavior: 'smooth' });
        });

        const updateArrowsSplideVisibility = () => {
            const container = document.querySelectorAll('.splide-items-container');

            container.forEach((c) => {
                const leftArrow = c.parentElement.querySelector('.splide-arrow-left');
                const rightArrow = c.parentElement.querySelector('.splide-arrow-right');

                if (c.scrollLeft === 0) {
                    leftArrow.classList.remove('group-hover:flex');
                } else {
                    leftArrow.classList.add('group-hover:flex');
                }

                if (c.scrollLeft + c.clientWidth + 2 >= c.scrollWidth) {
                    rightArrow.classList.remove('group-hover:flex');
                } else {
                    rightArrow.classList.add('group-hover:flex');
                }
            });
        };

        document.querySelectorAll('.splide-items-container').forEach((c) => {
            c.addEventListener('scroll', updateArrowsSplideVisibility);
        });
        window.addEventListener('resize', updateArrowsSplideVisibility);
        updateArrowsSplideVisibility();

        $(document).on('click', '.categories-list-container-carousel-arrow-right', function () {
            const container = $(this).parent().find('.categories-list-container-carousel')[0];
            const gamelist = $(this).parent().find('.categories-list-container-carousel div');
            for (let index = 0; index < gamelist.length; index++) {
                if (gamelist[index].getBoundingClientRect().x - container.getBoundingClientRect().x + gamelist[index].clientWidth > container.clientWidth) {
                    console.log(gamelist[index])
                    container.scrollTo({ left: gamelist[index].offsetLeft - 48, behavior: 'smooth' });
                    break;
                }
            }
        });

        $(document).on('click', '.categories-list-container-carousel-arrow-left', function () {
            const container = $(this).parent().find('.categories-list-container-carousel')[0];
            const gamelist = $(this).parent().find('.categories-list-container-carousel div');
            let veryLeftGameListIndex = 0;
            for (let index = gamelist.length - 1; index >= 0; index--) {
                veryLeftGameListIndex = index;
                if (gamelist[index].getBoundingClientRect().x < -container.clientWidth) {
                    break;
                }
            }

            if (veryLeftGameListIndex === 0) {
                container.scrollBy({ left: -container.scrollLeft, behavior: 'smooth' });
                return;
            }

            container.scrollTo({ left: gamelist[veryLeftGameListIndex].offsetLeft - 48, behavior: 'smooth' });
        });

        const updateArrowsCategoriesListVisibility = () => {
            const container = document.querySelector('.categories-list-container-carousel');
            const leftArrow = document.querySelector('.categories-list-container-carousel-arrow-left');
            const rightArrow = document.querySelector('.categories-list-container-carousel-arrow-right');

            if (container.scrollLeft === 0) {
                leftArrow.classList.remove('group-hover:flex');
            } else {
                leftArrow.classList.add('group-hover:flex');
            }

            if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                rightArrow.classList.remove('group-hover:flex');
            } else {
                rightArrow.classList.add('group-hover:flex');
            }
        };

        document.querySelector('.categories-list-container-carousel').addEventListener('scroll', updateArrowsCategoriesListVisibility);
        window.addEventListener('resize', updateArrowsCategoriesListVisibility);
        updateArrowsCategoriesListVisibility();
    }
});

 /* === START CLEAN HOVER VIDEO FIX FOR LOCAL + GAMEMONETIZE MP4 WITH IMAGE LOADING === */
(function () {
    let activeHoverCard = null;

    function getClosestCard(target) {
        if (!target || !target.closest) {
            return null;
        }

        return target.closest('[data-wt-video], [data-video]');
    }

    function getVideoUrl(card) {
        if (!card) {
            return '';
        }

        const dataVideo = card.getAttribute('data-video') || '';
        const dataWtVideo = card.getAttribute('data-wt-video') || '';

        if (dataVideo.indexOf('.mp4') !== -1) {
            return dataVideo;
        }

        if (dataWtVideo.indexOf('.mp4') !== -1) {
            return dataWtVideo;
        }

        return '';
    }

    function getPosterImage(card) {
        const img = card.querySelector('img');

        if (img && img.src) {
            return img.src;
        }

        return '';
    }

    function removeHoverVideo(card) {
        if (!card) {
            return;
        }

        const videoContainer = card.querySelector('.hover-video-container');
        if (videoContainer) {
            videoContainer.remove();
        }

        const nameDiv = card.querySelector('.hover-video-name');
        if (nameDiv) {
            nameDiv.remove();
        }
    }

    function addHoverVideo(card) {
        if (!card || card.querySelector('.hover-video-container')) {
            return;
        }

        const videoUrl = getVideoUrl(card);

        if (!videoUrl) {
            return;
        }

        const currentPosition = window.getComputedStyle(card).position;

        if (currentPosition === 'static') {
            card.style.position = 'relative';
        }

        card.style.overflow = 'hidden';

        const posterImage = getPosterImage(card);

        const videoContainer = document.createElement('div');
        videoContainer.className = 'hover-video-container';
        videoContainer.style.position = 'absolute';
        videoContainer.style.inset = '0';
        videoContainer.style.zIndex = '10';
        videoContainer.style.overflow = 'hidden';
        videoContainer.style.borderRadius = '16px';
        videoContainer.style.pointerEvents = 'none';
        videoContainer.style.backgroundColor = '#111';

        if (posterImage) {
            videoContainer.style.backgroundImage = 'url("' + posterImage + '")';
            videoContainer.style.backgroundSize = 'cover';
            videoContainer.style.backgroundPosition = 'center';
        }

        const loadingLayer = document.createElement('div');
        loadingLayer.className = 'hover-video-loading';
        loadingLayer.style.position = 'absolute';
        loadingLayer.style.inset = '0';
        loadingLayer.style.zIndex = '1';
        loadingLayer.style.background = 'linear-gradient(180deg, rgba(0,0,0,.15), rgba(0,0,0,.35))';
        loadingLayer.style.display = 'flex';
        loadingLayer.style.alignItems = 'center';
        loadingLayer.style.justifyContent = 'center';
        loadingLayer.style.color = '#fff';
        loadingLayer.style.fontSize = '13px';
        loadingLayer.style.fontWeight = '700';
        loadingLayer.style.letterSpacing = '.3px';
        loadingLayer.textContent = 'Loading preview...';

        const video = document.createElement('video');
        video.src = videoUrl;
        video.muted = true;
        video.autoplay = true;
        video.loop = true;
        video.playsInline = true;
        video.preload = 'auto';
        video.poster = posterImage;
        video.style.position = 'absolute';
        video.style.inset = '0';
        video.style.zIndex = '2';
        video.style.width = '100%';
        video.style.height = '100%';
        video.style.objectFit = 'cover';
        video.style.transform = 'scale(1.2)';
        video.style.display = 'block';
        video.style.opacity = '0';
        video.style.transition = 'opacity .18s ease';
        video.playbackRate = 2.0;

        function showVideo() {
            video.playbackRate = 2.0;
            video.style.opacity = '1';

            if (loadingLayer.parentNode) {
                loadingLayer.remove();
            }

            const playPromise = video.play();

            if (playPromise && typeof playPromise.catch === 'function') {
                playPromise.catch(function () {});
            }
        }

        video.addEventListener('loadeddata', showVideo);
        video.addEventListener('canplay', showVideo);

        video.addEventListener('error', function () {
            removeHoverVideo(card);
        });

        videoContainer.appendChild(loadingLayer);
        videoContainer.appendChild(video);
        card.appendChild(videoContainer);

        /*
         * Force play after append. Some browsers need this extra kick.
         */
        setTimeout(function () {
            if (card.querySelector('.hover-video-container')) {
                const playPromise = video.play();

                if (playPromise && typeof playPromise.catch === 'function') {
                    playPromise.catch(function () {});
                }
            }
        }, 80);

        const gameName = card.getAttribute('aria-label') || card.getAttribute('title') || '';

        if (gameName && window.innerWidth >= 1024 && !card.querySelector('.hover-video-name')) {
            const nameDiv = document.createElement('div');
            nameDiv.className = 'hover-video-name';
            nameDiv.style.position = 'absolute';
            nameDiv.style.left = '0';
            nameDiv.style.right = '0';
            nameDiv.style.bottom = '0';
            nameDiv.style.zIndex = '11';
            nameDiv.style.padding = '35px 10px 10px';
            nameDiv.style.color = '#fff';
            nameDiv.style.fontSize = '14px';
            nameDiv.style.fontWeight = '700';
            nameDiv.style.whiteSpace = 'nowrap';
            nameDiv.style.overflow = 'hidden';
            nameDiv.style.textOverflow = 'ellipsis';
            nameDiv.style.pointerEvents = 'none';
            nameDiv.style.background = 'linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,.75) 100%)';
            nameDiv.textContent = gameName;

            card.appendChild(nameDiv);
        }
    }

    document.addEventListener('mouseover', function (event) {
        const card = getClosestCard(event.target);

        if (!card) {
            return;
        }

        if (activeHoverCard === card) {
            return;
        }

        if (activeHoverCard) {
            removeHoverVideo(activeHoverCard);
        }

        activeHoverCard = card;
        addHoverVideo(card);
    });

    document.addEventListener('mouseout', function (event) {
        const card = getClosestCard(event.target);

        if (!card) {
            return;
        }

        if (event.relatedTarget && card.contains(event.relatedTarget)) {
            return;
        }

        removeHoverVideo(card);

        if (activeHoverCard === card) {
            activeHoverCard = null;
        }
    });
})();
 /* === END CLEAN HOVER VIDEO FIX FOR LOCAL + GAMEMONETIZE MP4 WITH IMAGE LOADING === */
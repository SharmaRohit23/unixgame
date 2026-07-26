
<div id="special-page-header-desc">{{HEADER_DESC}}</div>
<div class="ad728list">
    {{ADS_TOP}}
</div>
{{GAMES_PLAYED}}

<div id="content" class="space-y-6">
    <div class="hidden">{{ADS_300}}</div>
    <div class="relative group">
        <div class="flex w-full h-[267px] overflow-x-auto no-scrollbar home-top-games-list-carousel gap-2">
            {{HOME_TOP_GAMES_LIST}}
            {{NEW_GAMES_LIST}}
        </div>
        <div id="top-home-desktop-arrow-right" class="absolute top-0 right-0 z-20 items-center justify-center hidden w-12 h-full pl-2 text-2xl text-white bg-black cursor-pointer bg-opacity-80">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </div>
        <div id="top-home-desktop-arrow-left" class="absolute top-0 left-0 z-20 items-center justify-center hidden w-12 h-full pl-2 text-2xl text-white bg-black cursor-pointer bg-opacity-80">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </div>
    </div>
    {{ALL_SPLIDE_CONTAINERS}}
</div>

<div class="flex space-x-2">
    <div class="p-5 text-white bg-[#212233] lg:text-sm rounded-2xl lg:w-[464px] shrink-0">
        <div class="mb-4 text-2xl font-extrabold">{{SITE_NAME}}</div>
        <div class="space-y-4 text-gray-300 h-[100px] overflow-hidden footer-description">
            {{FOOTER_DESCRIPTION}}
        </div>
        <div class="mt-4 font-bold cursor-pointer modal-footer-open text-violet-400">Learn more</div>
    </div>
    <div class="relative flex-1 group max-w-[calc(100%-472px)]">
        <div class="h-full max-w-full space-x-2 overflow-x-scroll no-scrollbar whitespace-nowrap categories-list-container-carousel">
            {{CATEGORIES_LIST_HOME}}
        </div>
        <div class="absolute top-0 right-0 z-20 items-center justify-center hidden w-12 h-full pl-2 text-2xl text-white bg-black cursor-pointer categories-list-container-carousel-arrow-right bg-opacity-80">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </div>
        <div class="absolute top-0 left-0 z-20 items-center justify-center hidden w-12 h-full pl-2 text-2xl text-white bg-black cursor-pointer categories-list-container-carousel-arrow-left bg-opacity-80">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </div>
    </div>
</div>

<div id="more-splide" class="mt-6 space-y-6">
</div>

<div class="w-screen bg-black modal-footer h-svh bg-opacity-60 fixed inset-0 z-[99999999999] items-center justify-center hidden">
    <div class="px-5 pt-2 my-8 text-white relative bg-gray-800 rounded-2xl w-[90%] max-w-[600px]">
        <div class="relative ml-auto text-lg text-right text-white cursor-pointer size-8 modal-close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div class="h-[548px] overflow-y-auto">
            <div class="mb-4 text-2xl font-extrabold">{{SITE_NAME}}</div>
            <div class="space-y-4 text-gray-300 footer-description">{{FOOTER_DESCRIPTION}}</div>
        </div>
    </div>
</div>

<div class="flex justify-center my-8 space-x-2">
    <a href="/random" class="flex items-center justify-center w-48 h-12 text-base font-bold text-white border border-white rounded-full">
        <img src="/templates/crazygames-like/image/icon-color/dice.webp" alt="Random Game Dice Image" class="mr-2 size-4">
        Random Game
    </a>
    <div href="/random" class="flex items-center justify-center w-48 h-12 text-base font-bold text-white rounded-full bg-violet-600" onclick="window.scrollTo(0, 0)">
        <i class="mr-2 fa fa-arrow-up" aria-hidden="true"></i>
        Back to top
    </div>
</div>

<script>
    $(document).ready(function () {
        let loadedCategories = 4; // Jumlah kategori yang telah dimuat
        let numPerLoad = 3;  // Jumlah kategori yang akan dimuat per scroll
        let isLoading = false; // Cegah multiple request
        let noMoreData = false; // Jika tidak ada data lagi, hentikan request

        // Cek apakah ini halaman Home dan perangkat Desktop
        if (window.location.pathname === '/') {
            function loadMoreCategories() {
                if (isLoading || noMoreData) return; // Jika sedang memuat atau sudah habis, hentikan
                isLoading = true;
                
                $.ajax({
                    url: "ajax_loadmoresliders.php",
                    type: "GET",
                    data: {
                        LoadedGamesNum: loadedCategories,
                        num: numPerLoad
                    },
                    beforeSend: function () {
                        $("#loadingIndicator").show();
                    },
                    success: function (data) {
                        if (data.trim() === "NoData") {
                            noMoreData = true; // Hentikan infinite scroll jika tidak ada data lagi
                        } else {
                            $("#more-splide").append(data);
                            loadedCategories += numPerLoad;
                        }
                        $("#loadingIndicator").hide();
                        isLoading = false;
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
                    },
                    error: function () {
                        alert("Failed to load more categories.");
                        $("#loadingIndicator").hide();
                        isLoading = false;
                    }
                });
            }

            // Cek jika user sudah hampir mencapai bagian bawah halaman
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 300) {
                    loadMoreCategories();
                }
            });
        }
    });
</script>
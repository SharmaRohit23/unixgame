<div id="header" class="fix-top">
    <div class="relative flex items-center justify-between px-5 py-2 mx-auto lg:bg-[#1F1F30]">
        <div class="flex items-center">
            <div id="tablet-search-button" class="hidden mr-2 md:block lg:hidden">
                <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true" class="fill-white size-6">
                    <path xmlns="http://www.w3.org/2000/svg" fill="white" fill-rule="evenodd" clip-rule="evenodd" d="M2 5C2 4.44772 2.44772 4 3 4H15C15.5523 4 16 4.44772 16 5C16 5.55228 15.5523 6 15 6H3C2.44772 6 2 5.55228 2 5ZM2 12C2 11.4477 2.44772 11 3 11L21 11C21.5523 11 22 11.4477 22 12C22 12.5523 21.5523 13 21 13L3 13C2.44772 13 2 12.5523 2 12ZM2 19C2 18.4477 2.44772 18 3 18L21 18C21.5523 18 22 18.4477 22 19C22 19.5523 21.5523 20 21 20L3 20C2.44772 20 2 19.5523 2 19Z"></path>
                </svg>
            </div>
            <div id="desktop-menu-button" class="hidden w-12 cursor-pointer lg:block">
                <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true" class="fill-white size-6"><path xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" d="M19 4C19.5523 4 20 3.55229 20 3C20 2.44772 19.5523 2 19 2L3 2C2.44772 2 2 2.44772 2 3C2 3.55228 2.44772 4 3 4L19 4ZM20.47 7.95628L15.3568 11.152C14.7301 11.5437 14.7301 12.4564 15.3568 12.848L20.47 16.0438C21.136 16.4601 22 15.9812 22 15.1958V8.80427C22 8.01884 21.136 7.54 20.47 7.95628ZM11 13C11.5523 13 12 12.5523 12 12C12 11.4477 11.5523 11 11 11L3 11C2.44771 11 2 11.4477 2 12C2 12.5523 2.44771 13 3 13L11 13ZM20 21C20 21.5523 19.5523 22 19 22L3 22C2.44771 22 2 21.5523 2 21C2 20.4477 2.44771 20 3 20L19 20C19.5523 20 20 20.4477 20 21Z"></path></svg>
            </div>
            <a href="{{CONFIG_SITE_URL}}/" class="logo hide-text">Play Best Free Online Games</a>
        </div>

        <div id="mobile-search-button" class="md:hidden">
            <svg viewBox="0 0 22 22" focusable="false" aria-hidden="true" class="fill-white size-5"><path fill="#fff" fill-rule="evenodd" clip-rule="evenodd" d="M10.5502 4.33335C7.25947 4.33335 4.59184 7.00099 4.59184 10.2917C4.59184 13.5824 7.25947 16.25 10.5502 16.25C13.8409 16.25 16.5085 13.5824 16.5085 10.2917C16.5085 7.00099 13.8409 4.33335 10.5502 4.33335ZM2.42517 10.2917C2.42517 5.80437 6.06286 2.16669 10.5502 2.16669C15.0375 2.16669 18.6752 5.80437 18.6752 10.2917C18.6752 12.1448 18.0548 13.853 17.0105 15.2199L23.7745 21.984C24.1976 22.4071 24.1976 23.093 23.7745 23.5161C23.3515 23.9391 22.6655 23.9391 22.2425 23.5161L15.4784 16.752C14.1114 17.7963 12.4033 18.4167 10.5502 18.4167C6.06286 18.4167 2.42517 14.779 2.42517 10.2917ZM20.8418 6.50002C20.2435 6.50002 19.7585 6.98505 19.7585 7.58335C19.7585 8.18166 20.2435 8.66669 20.8418 8.66669L23.0085 8.66669C23.6068 8.66669 24.0918 8.18166 24.0918 7.58335C24.0918 6.98505 23.6068 6.50002 23.0085 6.50002L20.8418 6.50002ZM17.5918 3.25002C17.5918 2.65171 18.0769 2.16669 18.6752 2.16669H23.0085C23.6068 2.16669 24.0918 2.65171 24.0918 3.25002C24.0918 3.84833 23.6068 4.33335 23.0085 4.33335L18.6752 4.33335C18.0769 4.33335 17.5918 3.84833 17.5918 3.25002ZM21.9252 10.8334C21.3269 10.8334 20.8418 11.3184 20.8418 11.9167C20.8418 12.515 21.3269 13 21.9252 13H23.0085C23.6068 13 24.0918 12.515 24.0918 11.9167C24.0918 11.3184 23.6068 10.8334 23.0085 10.8334H21.9252Z"></path></svg>
        </div>

        <div class="relative w-1/2 shrink-0 bg-[#373952] h-10 rounded-[17px] hidden md:flex lg:hidden items-center pl-12 pr-4 ml-4">
            <input type="text" class="w-full text-base text-white bg-transparent outline-none" id="Search-InArea-tablet" name="search_parameter" placeholder="Search" autocomplete="off" aria-label="search-input">
            <i class="fa fa-search text-[#babbcc] absolute top-1/2 left-4 transform -translate-y-1/2 text-lg"></i>
            <i id="clear-search" class="fa fa-times-circle text-[#babbcc] text-lg hidden" aria-hidden="true"></i>
        </div>

        <div id="search-results-tablet" class="absolute bg-[#0C0D14] w-screen left-0 hidden h-svh max-h-[calc(100svh-80px)] py-4 space-y-2 overflow-y-auto top-[70px]"></div>

        <div class="relative w-[460px] shrink-0 bg-[#373952] h-10 rounded-[17px] hidden lg:flex items-center pr-12 pl-4 ml-4">
            <input type="text" class="w-full text-base text-white bg-transparent outline-none" id="Search-InArea-desktop" name="search_parameter" placeholder="Search" autocomplete="off" aria-label="search-input">
            <i class="w-[18px] fa fa-search text-[#babbcc] absolute top-1/2 right-4 transform -translate-y-1/2 text-lg"></i>
            <div id="search-results-desktop" class="absolute bg-[#1F1F30] w-[460px] rounded-2xl left-0 h-[400px] hidden py-4 overflow-y-auto top-[70px]"></div>
        </div>

        <div class="w-[144px] hidden lg:block"></div>
    </div>
</div>

<div id="search-result-desktop-bg" class="fixed top-0 left-0 z-30 hidden w-full h-full bg-black bg-opacity-50"></div>

<div id="sidebar-menu" class="w-full h-svh fixed top-0 left-0 z-[999999999999999] bg-[#0C0D14] flex-col hidden md:-left-full md:flex transition-all duration-300 md:w-auto md:pr-5 lg:left-0 lg:z-20 lg:w-[62px] lg:pr-0 group lg:hover:w-auto lg:border-r lg:border-[#2d2e3b] lg:overflow-x-hidden min-[1920px]:w-[240px] min-[1920px]:hover:w-[240px]">
    <div class="flex items-center p-2 bg-[#0C0D14] shrink-0">
        <div id="back-button" class="mx-2 size-5 md:size-6 shrink-0 md:my-4">
            <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true" class="md:hidden">
                <path fill="#fff" fill-rule="evenodd" clip-rule="evenodd" d="M8.33 18.74c.41.37 1.04.34 1.41-.07.37-.41.34-1.04-.07-1.41L4.95 13H21a1 1 0 0 0 0-2H4.95l4.72-4.26a1 1 0 1 0-1.34-1.49L2.79 10.26a2 2 0 0 0 0 2.98l5.54 5.5Z"></path>
            </svg>
            <svg fill="#fff" viewBox="0 0 24 24" focusable="false" aria-hidden="true" class="hidden md:block">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29289 4.29289C4.68342 3.90237 5.31658 3.90237 5.70711 4.29289L12 10.5858L18.2929 4.29289C18.6834 3.90237 19.3166 3.90237 19.7071 4.29289C20.0976 4.68342 20.0976 5.31658 19.7071 5.70711L13.4142 12L19.7071 18.2929C20.0976 18.6834 20.0976 19.3166 19.7071 19.7071C19.3166 20.0976 18.6834 20.0976 18.2929 19.7071L12 13.4142L5.70711 19.7071C5.31658 20.0976 4.68342 20.0976 4.29289 19.7071C3.90237 19.3166 3.90237 18.6834 4.29289 18.2929L10.5858 12L4.29289 5.70711C3.90237 5.31658 3.90237 4.68342 4.29289 4.29289Z"></path>
            </svg>
        </div>

        <div class="relative flex-1 shrink-0 bg-[#373952] h-[34px] rounded-[17px] flex items-center pl-12 pr-4 md:hidden">
            <input type="text" class="w-full text-base text-white bg-transparent outline-none" id="Search-InArea" name="search_parameter" placeholder="Search" autocomplete="off" aria-label="search-input">
            <i class="fa fa-search text-[#babbcc] absolute top-1/2 left-4 transform -translate-y-1/2 text-lg"></i>
            <i id="clear-search" class="fa fa-times-circle text-[#babbcc] text-lg hidden" aria-hidden="true"></i>
        </div>
    </div>

    <div id="search-results" class="flex-1 hidden w-full max-h-full my-4 space-y-2 overflow-y-auto"></div>

    <div id="sidebar" class="flex-1 w-full max-h-full overflow-y-hidden min-[1920px]:overflow-y-auto lg:group-hover:overflow-y-auto lg:pt-4 lg:overflow-x-hidden lg:group-hover:pr-5 lg:pb-6 min-[1920px]:group-hover:pr-0 min-[1920px]:pr-5">

        <a href="{{CONFIG_SITE_URL}}/" class="border-violet-500 border-l-4 text-violet-400 flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-house sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Home</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/new-games" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-star sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">New Games</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/best-games" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-ranking-star sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Best Games</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/featured-games" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-wand-magic-sparkles sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Featured Games</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/played-games" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-circle-play sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Played Games</div>
        </a>

        <div class="w-full h-px my-4 bg-slate-100 bg-opacity-10"></div>

        {{CATEGORIES_LIST_2}}

        <a href="{{CONFIG_SITE_URL}}/categories" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-bars sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">More Categories</div>
        </a>

        <div class="w-full h-px my-4 bg-slate-100 bg-opacity-10"></div>

        {{TAGS_LIST}}

        <a href="{{CONFIG_SITE_URL}}/tags" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-tags sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">More Tags</div>
        </a>

        <div class="w-full h-px my-4 bg-slate-100 bg-opacity-10"></div>

        <a href="{{CONFIG_SITE_URL}}/blogs" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-brands fa-blogger sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Blog</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/contact" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-phone sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Contact</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/terms" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-file-contract sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Terms</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/about" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-circle-info sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">About</div>
        </a>

        <a href="{{CONFIG_SITE_URL}}/privacy" class="border-transparent border-l-4 text-white flex items-center font-semibold no-underline h-[34px] hover:text-opacity-65 hover:[&>div]:pl-2 [&>div]:mr-2 hover:[&>div]:mr-0 text-[15px]">
            <span class="sidebar-admin-icon-wrap">
                <i class="fa-solid fa-lock sidebar-admin-icon"></i>
            </span>
            <div class="relative transition-all duration-300">Privacy</div>
        </a>

        <div class="w-full py-8 text-sm text-center text-white lg:hidden">
            GameMonetize.com ©2025
        </div>
    </div>
</div>
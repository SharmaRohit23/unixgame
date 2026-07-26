
<div id="special-page-header-desc">{{HEADER_DESC}}</div>
<div class="ad728list">
    {{ADS_TOP}}
</div>
{{GAMES_PLAYED}}

<div id="content" class="space-y-6">
    <div class="hidden">{{ADS_300}}</div>
    <div class="flex space-x-2 overflow-x-auto home-top-games-list-carousel">
        {{HOME_TOP_GAMES_LIST}}
    </div>
    <div class="grid grid-cols-2 gap-4 md:grid-cols-4 home-games-list">
        {{NEW_GAMES_LIST}}
    </div>
    {{ALL_SPLIDE_CONTAINERS}}
</div>

<div class="p-5 my-8 text-white bg-[#212233] rounded-2xl">
    <div class="mb-4 text-2xl font-extrabold">{{SITE_NAME}}</div>
    <div class="space-y-4 text-gray-300 [&>*:nth-child(n+4)]:hidden footer-description">
        {{FOOTER_DESCRIPTION}}
    </div>
    <div class="mt-4 font-bold cursor-pointer modal-footer-open text-violet-400">Learn more</div>
</div>

<div class="w-screen bg-black modal-footer h-svh bg-opacity-60 fixed inset-0 z-[99999999999] items-center justify-center hidden">
    <div class="px-5 pt-2 my-8 text-white relative bg-gray-800 rounded-2xl w-[90%] max-w-[600px]">
        <div class="relative w-8 ml-auto text-lg text-right text-white modal-close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div class="h-[548px] overflow-y-auto">
            <div class="mb-4 text-2xl font-extrabold">{{SITE_NAME}}</div>
            <div class="space-y-4 text-gray-300 footer-description">{{FOOTER_DESCRIPTION}}</div>
        </div>
    </div>
</div>

<div class="mb-8 space-y-2">
    <a href="/random" class="flex items-center justify-center h-12 text-base font-bold text-white border border-white rounded-full">
        <img src="/templates/crazygames-like/image/icon-color/dice.webp" alt="Random Game Dice Image" class="mr-2 size-4">
        Random Game
    </a>
    <div href="/random" class="flex items-center justify-center h-12 text-base font-bold text-white rounded-full bg-violet-600" onclick="window.scrollTo(0, 0)">
        <i class="mr-2 fa fa-arrow-up" aria-hidden="true"></i>
        Back to top
    </div>
</div>
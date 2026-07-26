
<div class="flex items-center mt-2 mb-4 space-x-2 text-white">
	<img src="{{CATEGORY_THUMB}}" alt="{{CATEGORY_NAME}} image" class="object-cover rounded-lg size-8">
	<h1 class="mt-2 text-2xl font-extrabold text-white">{{CATEGORY_NAME}}</h1>
</div>
<div class="flex items-center mt-1 text-sm">
	<div class="w-8/12 text-white truncate text-opacity-60 truncated-description">{{HEADER_DESC}}</div>
	<div class="ml-2 cursor-pointer text-violet-500 show-more-button">Show more</div>
</div>
<div class="ad728list">
    {{ADS_TOP}}
</div>

<div id="content">
    {{ADS_300}}
    <div id="game-list-container" class="grid grid-cols-2 gap-4 md:grid-cols-5 lg:grid-cols-7 2xl:grid-cols-8 min-[1920px]:grid-cols-9 min-[2560px]:grid-cols-11">
        {{CATEGORY_GAMES_LIST}}
    </div>
</div>

<div class="p-5 my-8 text-white bg-gray-800 rounded-2xl footer-description">
    {{FOOTER_DESCRIPTION_MODIFIED}}
</div>
{{FOOTER_CONTENT}}
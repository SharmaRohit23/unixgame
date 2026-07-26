<div class='flex items-stretch mb-6'>
    <a href="/played-games" class="flex mr-2 hover:bg-transparent hover:ring-1 ring-inset ring-violet-600 gap-4 shrink-0 items-center px-4 bg-[#212233] rounded-lg w-[120px]">
        <div class="text-sm font-extrabold leading-tight text-white">Recently <br /> Played</div>
        <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true" class="size-4 fill-violet-500" style="color: rgb(164, 142, 255);"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.25759 2.33006C7.62758 1.92004 8.25992 1.88759 8.66994 2.25758L16.9814 9.75758C18.3395 10.9831 18.3395 13.0169 16.9814 14.2424L8.66994 21.7424C8.25992 22.1124 7.62758 22.08 7.25759 21.6699C6.88759 21.2599 6.92005 20.6276 7.33007 20.2576L15.6415 12.7576C16.1195 12.3263 16.1195 11.6737 15.6415 11.2424L7.33007 3.74242C6.92005 3.37242 6.88759 2.74009 7.25759 2.33006Z"></path></svg>
    </a>
    <div class="flex-1 max-w-[calc(100%-120px)]">
        <div class="relative group">
            <div class="flex max-w-full space-x-2 overflow-x-auto no-scrollbar splide-items-container">
                {{SPLIDE_ITEMS}}
            </div>
            <div class="absolute top-0 right-0 z-20 items-center justify-center hidden w-12 h-full pl-2 text-2xl text-white bg-black cursor-pointer splide-arrow-right bg-opacity-80">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </div>
            <div class="absolute top-0 left-0 z-20 items-center justify-center hidden w-12 h-full pl-2 text-2xl text-white bg-black cursor-pointer splide-arrow-left bg-opacity-80">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</div>
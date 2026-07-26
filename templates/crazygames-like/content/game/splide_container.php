<div class='mb-6'>
    <div class="flex justify-between mb-2">
        <div class="flex items-center text-sm font-bold text-white">
            {{SPLIDE_HEADER_TITLE}}
            <a href="{{SPLIDE_HEADER_URL}}" class='ml-4 text-xs text-violet-500'>View more</a>
        </div>
        <div class="cursor-pointer splide-arrow-right lg:hidden">
            <svg class="size-5 fill-white" viewBox="0 0 24 24" focusable="false" aria-hidden="true" class="GameCarousel_doubleArrow__BGrRW double-arrow css-6qu7l6"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.25757 2.33007C3.62757 1.92005 4.2599 1.88759 4.66993 2.25759L12.9814 9.75759C14.3395 10.9831 14.3395 13.0169 12.9814 14.2424L4.66993 21.7424C4.2599 22.1124 3.62757 22.08 3.25757 21.6699C2.88758 21.2599 2.92003 20.6276 3.33006 20.2576L11.6415 12.7576C12.1195 12.3263 12.1195 11.6737 11.6415 11.2424L3.33006 3.74243C2.92003 3.37243 2.88758 2.7401 3.25757 2.33007Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M11.2576 2.33007C11.6276 1.92005 12.2599 1.88759 12.6699 2.25759L20.9814 9.75759C22.3395 10.9831 22.3395 13.0169 20.9814 14.2424L12.6699 21.7424C12.2599 22.1124 11.6276 22.08 11.2576 21.6699C10.8876 21.2599 10.92 20.6276 11.3301 20.2576L19.6415 12.7576C20.1195 12.3263 20.1195 11.6737 19.6415 11.2424L11.3301 3.74243C10.92 3.37243 10.8876 2.7401 11.2576 2.33007Z"></path></svg>
        </div>
    </div>
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
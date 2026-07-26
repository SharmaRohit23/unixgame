<div class="splide-container">
    <div class="splide-header">
        <p>{{SPLIDE_HEADER_TITLE}}</p> <a href="{{SPLIDE_HEADER_URL}}">More {{SPLIDE_HEADER_TITLE}}</a>
    </div>
    <div class="splide splide--slide splide--ltr splide--draggable is-active is-initialized" id="splide_{{SPLIDE_HEADER_ID}}">
        <div class="splide__arrows"><button class="splide__arrow splide__arrow--prev" type="button" aria-controls="splide_{{SPLIDE_HEADER_ID}}-track" disabled="" aria-label="Previous slide" style="opacity: 0;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                    <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                </svg></button><button class="splide__arrow splide__arrow--next" type="button" aria-controls="splide_{{SPLIDE_HEADER_ID}}-track" aria-label="Next slide" style="opacity: 0;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                    <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                </svg></button></div>
        <div class="splide__track" id="splide_{{SPLIDE_HEADER_ID}}-track" style="padding-left: 0px; padding-right: 0px;">
            <ul class="splide__list gameList" id="splide_{{SPLIDE_HEADER_ID}}-list" style="transform: translateX(0px);" data-slider_id="" data-slider_special_type="">
                {{SPLIDE_ITEMS}}
            </ul>
        </div>
    </div>
</div>
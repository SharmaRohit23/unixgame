{{EDIT_BLOG_BUTTON}}
<style>
.splide-container {
	position: relative;
	background: #373952;
	border-radius: 12px;
}
.splide {
	position: relative;
	overflow: visible;
}
.splide__track {
	overflow: hidden;
	position: relative;
	border-radius: 8px;
    padding: 16px 0;
}
.splide__list {
	display: flex;
	margin: 0;
	padding: 0;
	list-style: none;
	transition: transform 0.4s ease;
	align-items: stretch;
}
.splide__slide {
	flex: 0 0 auto;
	margin-right: 15px;
	width: 100px;
	display: block !important;
	visibility: visible !important;
}
.splide__slide:last-child {
	margin-right: 0;
}
.game-item {
	display: block;
	text-decoration: none;
	border-radius: 12px;
	overflow: hidden;
	transition: all 0.3s ease;
	background: #ffffff;
	box-shadow: 0 4px 12px rgba(0,0,0,0.1);
	height: 100%;
    position: relative;
}
.game-item:hover {
	transform: translateY(-4px) scale(1.02);
	box-shadow: 0 8px 25px rgba(0,0,0,0.15);
	text-decoration: none;
}
.game-item img {
	width: 100%;
	height: 75px;
	object-fit: cover;
	display: block;
	border-bottom: 2px solid #ecf0f1;
}
.post-name {
	padding: 8px;
	font-size: 10px;
	font-weight: 600;
	margin: 0;
	text-align: center;
    position: absolute;
    color: white;
    left: 0;
    bottom: 0;
	line-height: 1.4;
    width: 100%;
    height: 100%;
	display: flex;
	align-items: flex-end;
	justify-content: center;
	text-overflow: ellipsis;
	overflow: hidden;
    display: none;
    background: #000000;
    background: linear-gradient(0deg,rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
}
.game-item:hover .post-name {
    display: flex;
}
.splide__arrows {
	display: block !important;
	position: relative;
	z-index: 10;
}
.splide__arrow {
	position: absolute !important;
	top: 50% !important;
	transform: translateY(-50%) !important;
	background: rgba(255,255,255,0.95) !important;
	border: 2px solid #9b59b6 !important;
	border-radius: 50% !important;
	width: 45px !important;
	height: 45px !important;
	cursor: pointer !important;
	display: flex !important;
	align-items: center !important;
	justify-content: center !important;
	box-shadow: 0 4px 15px rgba(155, 89, 182, 0.3) !important;
	transition: all 0.3s ease !important;
	z-index: 100 !important;
	visibility: visible !important;
	opacity: 1 !important;
}
.splide__arrow:hover {
	background: #9b59b6 !important;
	transform: translateY(-50%) scale(1.1) !important;
	box-shadow: 0 6px 20px rgba(155, 89, 182, 0.4) !important;
}
.splide__arrow:hover svg {
	fill: white !important;
}
.splide__arrow--prev {
	left: -25px !important;
}
.splide__arrow--next {
	right: -25px !important;
}
.splide__arrow svg {
	width: 22px !important;
	height: 22px !important;
	fill: #9b59b6 !important;
	transition: fill 0.3s ease !important;
}
.splide__arrow--prev svg {
	transform: rotate(180deg) !important;
}
.splide__arrow:disabled {
	opacity: 0.4 !important;
	cursor: not-allowed !important;
	background: #bdc3c7 !important;
	border-color: #bdc3c7 !important;
}
.splide__arrow:disabled svg {
	fill: #7f8c8d !important;
}
.splide__arrow:disabled:hover {
	transform: translateY(-50%) !important;
	background: #bdc3c7 !important;
}
@media (max-width: 768px) {
	.splide-container {
		margin: 15px 0;
		padding: 15px;
	}
	.splide__slide {
		width: 150px;
		margin-right: 12px;
	}
	.game-item img {
		height: 110px;
	}
	.post-name {
		font-size: 12px;
		height: 45px;
		padding: 10px;
	}
	.splide__arrow {
		width: 40px !important;
		height: 40px !important;
	}
	.splide__arrow svg {
		width: 18px !important;
		height: 18px !important;
	}
	.splide__arrow--prev {
		left: -20px !important;
	}
	.splide__arrow--next {
		right: -20px !important;
	}
}
@media (max-width: 480px) {
	.splide__slide {
		width: 130px;
		margin-right: 10px;
	}
	.game-item img {
		height: 95px;
	}
	.post-name {
		font-size: 11px;
		height: 40px;
		padding: 8px;
	}
}
</style>
<script language="javascript">var PageType ="{{NEW_GAME_PAGE}}"; var ids ="{{NEW_GAME_IDS}}";</script>
<script>
// Enhanced Splide-like slider functionality for CrazyGames-like template
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing CrazyGames-like slider...');
    
    setTimeout(() => {
        const slider = document.getElementById('splide_games_slider');
        if (!slider) {
            console.log('CrazyGames-like Slider not found');
            return;
        }

        const track = slider.querySelector('.splide__track');
        const list = slider.querySelector('.splide__list');
        const slides = slider.querySelectorAll('.splide__slide');
        const prevBtn = slider.querySelector('.splide__arrow--prev');
        const nextBtn = slider.querySelector('.splide__arrow--next');
        
        if (!track || !list || !slides.length || !prevBtn || !nextBtn) {
            console.log('Missing required CrazyGames-like slider elements');
            return;
        }

        // Force arrow visibility
        prevBtn.style.display = 'flex';
        prevBtn.style.visibility = 'visible';
        prevBtn.style.opacity = '1';
        nextBtn.style.display = 'flex';
        nextBtn.style.visibility = 'visible';
        nextBtn.style.opacity = '1';

        let currentIndex = 0;
        let slideWidth = 0;
        let visibleSlides = 0;
        let maxIndex = 0;

        function calculateDimensions() {
            const containerWidth = track.offsetWidth;
            const firstSlide = slides[0];
            if (!firstSlide) return;
            
            const slideStyles = window.getComputedStyle(firstSlide);
            const slideMarginRight = parseInt(slideStyles.marginRight) || 15;
            slideWidth = firstSlide.offsetWidth + slideMarginRight;
            
            visibleSlides = Math.floor(containerWidth / slideWidth);
            maxIndex = Math.max(0, slides.length - visibleSlides);
            
            slides.forEach((slide, index) => {
                slide.style.display = 'block';
                slide.style.visibility = 'visible';
                slide.style.opacity = '1';
            });
            
            updateButtons();
        }

        function updateButtons() {
            const prevDisabled = currentIndex <= 0;
            const nextDisabled = currentIndex >= maxIndex;
            
            prevBtn.disabled = prevDisabled;
            nextBtn.disabled = nextDisabled;
            
            prevBtn.style.opacity = prevDisabled ? '0.4' : '1';
            prevBtn.style.cursor = prevDisabled ? 'not-allowed' : 'pointer';
            nextBtn.style.opacity = nextDisabled ? '0.4' : '1';
            nextBtn.style.cursor = nextDisabled ? 'not-allowed' : 'pointer';
        }

        function slide(direction) {
            if (direction === 'next' && currentIndex < maxIndex) {
                currentIndex++;
            } else if (direction === 'prev' && currentIndex > 0) {
                currentIndex--;
            }
            
            const translateX = -(currentIndex * slideWidth);
            list.style.transform = `translateX(${translateX}px)`;
            updateButtons();
        }

        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (!prevBtn.disabled) {
                slide('prev');
            }
        });

        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (!nextBtn.disabled) {
                slide('next');
            }
        });

        window.addEventListener('resize', function() {
            setTimeout(() => {
                calculateDimensions();
                if (currentIndex > maxIndex) {
                    currentIndex = maxIndex;
                    const translateX = -(currentIndex * slideWidth);
                    list.style.transform = `translateX(${translateX}px)`;
                }
            }, 100);
        });

        // Touch support
        let startX = 0;
        let endX = 0;
        let isDragging = false;

        track.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            isDragging = true;
        }, { passive: true });

        track.addEventListener('touchend', function(e) {
            if (!isDragging) return;
            endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;
            
            if (Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    slide('next');
                } else {
                    slide('prev');
                }
            }
            
            isDragging = false;
        }, { passive: true });

        calculateDimensions();
        console.log('CrazyGames-like Slider initialization complete');
        
    }, 500);
});
</script>

<div class="w-full bg-[#212233] p-10 my-5 text-white max-w-screen-lg mx-auto relative">
    {{SPLIDE_CONTAINER}}
    <h1 class="font-bold blog-post-title">{{BLOG_TITLE}}</h1>
    <div class="blog-post-date">Posted on {{BLOG_DATE_CREATED}}</div>
    <hr style="margin: 10px;">
    <img src="{{BLOG_IMAGE_URL}}" class="blog-post-image" alt="{{BLOG_TITLE image}}">
    <div class="mt-4 footer-description">{{BLOG_POST}}</div>
    <div class="blog-post-bottom"></div>
</div>

{{FOOTER_CONTENT}}
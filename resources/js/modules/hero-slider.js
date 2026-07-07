import Swiper from 'swiper';
import { Autoplay, EffectFade, Keyboard, Navigation, Pagination, A11y } from 'swiper/modules';

/**
 * Cinematic hero slideshow. Reads autoplay/transition settings from
 * data attributes so the CMS controls them without a rebuild.
 */
export function initHeroSlider() {
    const el = document.querySelector('.hero-swiper');
    if (!el) return;

    const autoplayDelay = parseInt(el.dataset.autoplayDelay ?? '6000', 10);
    const speed = parseInt(el.dataset.transitionDuration ?? '900', 10);
    const autoplayEnabled = el.dataset.autoplay !== '0';
    const slideCount = el.querySelectorAll('.swiper-slide').length;

    new Swiper(el, {
        modules: [Autoplay, EffectFade, Keyboard, Navigation, Pagination, A11y],
        effect: 'fade',
        fadeEffect: { crossFade: true },
        speed,
        loop: slideCount > 1,
        autoplay: autoplayEnabled && slideCount > 1
            ? { delay: autoplayDelay, disableOnInteraction: false, pauseOnMouseEnter: true }
            : false,
        keyboard: { enabled: true },
        navigation: {
            nextEl: '.hero-swiper-next',
            prevEl: '.hero-swiper-prev',
        },
        pagination: {
            el: '.hero-swiper-pagination',
            clickable: true,
        },
        a11y: {
            prevSlideMessage: 'Previous product',
            nextSlideMessage: 'Next product',
        },
    });
}

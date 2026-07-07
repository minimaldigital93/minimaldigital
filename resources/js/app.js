import './bootstrap';

import Alpine from 'alpinejs';

import { initTheme } from './modules/theme';
import { initHeroSlider } from './modules/hero-slider';
import { initScrollAnimations } from './modules/animations';
import { initAdmin } from './modules/admin';

window.Alpine = Alpine;

initTheme(Alpine);
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    initHeroSlider();
    initScrollAnimations();
    initAdmin();
});

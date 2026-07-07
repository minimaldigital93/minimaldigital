import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/**
 * GPU-friendly scroll reveals. Elements opt in with .reveal;
 * siblings inside a [data-reveal-group] stagger automatically.
 */
export function initScrollAnimations() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('.reveal').forEach((el) => el.classList.add('revealed'));
        return;
    }

    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        const items = group.querySelectorAll('.reveal');
        if (!items.length) return;

        gsap.to(items, {
            opacity: 1,
            y: 0,
            duration: 0.9,
            ease: 'power3.out',
            stagger: 0.12,
            scrollTrigger: { trigger: group, start: 'top 82%' },
            onComplete: () => items.forEach((el) => el.classList.add('revealed')),
        });
    });

    document.querySelectorAll('.reveal:not([data-reveal-group] .reveal)').forEach((el) => {
        gsap.to(el, {
            opacity: 1,
            y: 0,
            duration: 0.9,
            ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' },
            onComplete: () => el.classList.add('revealed'),
        });
    });

    // Animated counters for stat tiles.
    document.querySelectorAll('[data-count]').forEach((el) => {
        const target = parseFloat(el.dataset.count);
        if (Number.isNaN(target)) return;

        const suffix = el.dataset.countSuffix ?? '';
        const counter = { value: 0 };

        gsap.to(counter, {
            value: target,
            duration: 1.6,
            ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 88%' },
            onUpdate: () => {
                el.textContent = Math.round(counter.value).toLocaleString() + suffix;
            },
        });
    });

    // Gentle parallax on decorated elements.
    document.querySelectorAll('[data-parallax]').forEach((el) => {
        const strength = parseFloat(el.dataset.parallax || '40');
        gsap.fromTo(el, { y: -strength }, {
            y: strength,
            ease: 'none',
            scrollTrigger: {
                trigger: el.parentElement,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.6,
            },
        });
    });
}

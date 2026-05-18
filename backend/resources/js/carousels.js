/**
 * Carousel initialisation — Glide.js, loaded lazily per element.
 *
 * Required attributes on the carousel root element:
 *   data-glide                — selector marker
 *   data-glide-per-view       — items visible on desktop (default: 3)
 *   data-glide-slide-count    — total real slides (for hiding controls when all fit)
 */

const carousels = [...document.querySelectorAll('[data-glide]')];

if (carousels.length > 0) {
    const isRtl = document.documentElement.dir === 'rtl';

    /**
     * Initialise one Glide instance.
     * The dynamic import is module-cached: the bundle loads only once
     * even when multiple carousels initialise in quick succession.
     */
    async function initGlide(el) {
        const { default: Glide } = await import('@glidejs/glide');

        const perView    = parseInt(el.dataset.glidePerView   ?? '3', 10);
        const slideCount = parseInt(el.dataset.glideSlideCount ?? '0', 10);

        const glide = new Glide(el, {
            type:      'carousel',
            perView,
            gap:       16,
            direction: isRtl ? 'rtl' : 'ltr',
            breakpoints: {
                1023: { perView: Math.min(2, perView) },
                639:  { perView: 1 },
            },
        });

        // Hide controls when all slides fit in the current viewport at once.
        glide.on('mount.after', () => {
            let activePerView = perView;
            if (window.innerWidth <= 1023) activePerView = Math.min(2, perView);
            if (window.innerWidth <= 639)  activePerView = 1;

            if (slideCount <= activePerView) {
                el.querySelector('[data-glide-el="controls"]')?.classList.add('!hidden');
            }
        });

        glide.mount();
    }

    /**
     * Observe each carousel and initialise Glide as it approaches the viewport.
     * rootMargin: 300px ensures the library loads before the user sees the element,
     * eliminating any layout shift on scroll.
     */
    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                obs.unobserve(entry.target);
                initGlide(entry.target);
            });
        },
        { rootMargin: '300px 0px' },
    );

    carousels.forEach(el => observer.observe(el));
}

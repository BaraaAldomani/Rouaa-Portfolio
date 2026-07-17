/**
 * "Sky & Glass" motion — calm, unobtrusive, GPU-friendly.
 *   • scroll-reveal + stagger via IntersectionObserver
 *   • animated stat counters
 *   • gentle orb parallax on scroll
 *   • accessible mobile nav
 * Everything degrades gracefully and honours prefers-reduced-motion.
 */

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ── Scroll reveal + stagger ─────────────────────────────────────── */
function initReveals() {
    const revealables = document.querySelectorAll('.reveal, .reveal-start');

    // Assign stagger delays to children of [data-stagger] containers.
    document.querySelectorAll('[data-stagger]').forEach((group) => {
        const step = parseFloat(group.dataset.stagger) || 0.08;
        group.querySelectorAll(':scope > .reveal, :scope > .reveal-start').forEach((el, i) => {
            el.style.setProperty('--d', `${i * step}s`);
        });
    });

    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealables.forEach((el) => el.classList.add('in'));
        return;
    }

    const io = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in');
                    obs.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
    );

    revealables.forEach((el) => io.observe(el));
}

/* ── Animated count-up for stats ─────────────────────────────────── */
function animateCount(el) {
    const target = parseInt(el.dataset.count, 10) || 0;
    const suffix = el.dataset.suffix || '';
    const prefix = el.dataset.prefix || '';
    if (reduceMotion) {
        el.textContent = `${prefix}${target}${suffix}`;
        return;
    }

    const duration = 1400;
    const start = performance.now();
    function tick(now) {
        const p = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
        const value = Math.round(eased * target);
        el.textContent = `${prefix}${value.toLocaleString()}${suffix}`;
        if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
}

function initCounters() {
    const counters = document.querySelectorAll('[data-count]');
    if (!counters.length) return;

    if (!('IntersectionObserver' in window)) {
        counters.forEach(animateCount);
        return;
    }

    const io = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    obs.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.6 },
    );
    counters.forEach((el) => io.observe(el));
}

/* ── Gentle orb parallax ─────────────────────────────────────────── */
function initParallax() {
    if (reduceMotion) return;
    const orbs = document.querySelectorAll('.orb[data-speed]');
    if (!orbs.length) return;

    let ticking = false;
    function update() {
        const y = window.scrollY;
        orbs.forEach((orb) => {
            const speed = parseFloat(orb.dataset.speed) || 0.1;
            orb.style.translate = `0 ${y * speed}px`;
        });
        ticking = false;
    }
    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        },
        { passive: true },
    );
}

/* ── Accessible mobile navigation ────────────────────────────────── */
function initMobileNav() {
    const toggle = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');
    if (!toggle || !menu) return;

    const close = () => {
        menu.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
    };

    toggle.addEventListener('click', () => {
        const open = menu.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('nav-open', open);
    });

    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', close));
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });
}

/* ── Elevate nav on scroll ───────────────────────────────────────── */
function initNavElevation() {
    const nav = document.querySelector('[data-site-nav]');
    if (!nav) return;
    const onScroll = () => nav.classList.toggle('is-scrolled', window.scrollY > 12);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function init() {
    initReveals();
    initCounters();
    initParallax();
    initMobileNav();
    initNavElevation();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

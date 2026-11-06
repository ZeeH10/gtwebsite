// Mobile menu
const toggle = document.querySelector('[data-menu-toggle]');
const menu = document.getElementById('mobile-nav');
if (toggle && menu) {
    const set = (open) => {
        menu.hidden = !open;
        toggle.setAttribute('aria-expanded', String(open));
        toggle.querySelector('[data-open]').classList.toggle('hidden', open);
        toggle.querySelector('[data-close]').classList.toggle('hidden', !open);
    };
    toggle.addEventListener('click', () => set(menu.hidden));
    menu.addEventListener('click', (e) => e.target.closest('a') && set(false));
    document.addEventListener('keydown', (e) => e.key === 'Escape' && !menu.hidden && (set(false), toggle.focus()));
}

// Gentle scroll reveal (skipped entirely for reduced-motion users)
if ('IntersectionObserver' in window && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.classList.add('js-reveal');
    const io = new IntersectionObserver((entries) => entries.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
    }), { rootMargin: '0px 0px -10% 0px' });
    document.querySelectorAll('[data-reveal]').forEach((el) => io.observe(el));
}

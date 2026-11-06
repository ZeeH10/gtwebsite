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

// PWA: install on phones + offline page (see public/sw.js)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js'));
}

// Click-to-load embeds (map, videos): nothing third-party loads until the visitor asks (POPIA / cookies)
document.querySelectorAll('[data-embed]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const iframe = document.createElement('iframe');
        iframe.src = btn.dataset.embed;
        iframe.title = btn.dataset.title || '';
        iframe.className = btn.className.replace(/\bgroup\b/, '') + ' border-0';
        iframe.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
        iframe.allowFullscreen = true;
        btn.replaceWith(iframe);
    });
});

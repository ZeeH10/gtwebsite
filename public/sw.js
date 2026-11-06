// Service worker: makes the site installable and shows an offline page without a connection.
// Bump VERSION when the offline page or cached files should be refreshed.
const VERSION = 'gt-v1';
const OFFLINE_URL = '/offline';

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(VERSION)
            .then((cache) => cache.addAll([OFFLINE_URL, '/images/icon-192.png']))
            .then(() => self.skipWaiting()),
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(keys.filter((k) => k !== VERSION).map((k) => caches.delete(k))))
            .then(() => self.clients.claim()),
    );
});

self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    // Never touch form posts, the admin area, Livewire, or other sites (maps/videos).
    if (request.method !== 'GET' || url.origin !== self.location.origin
        || url.pathname.startsWith('/admin') || url.pathname.startsWith('/livewire')) {
        return;
    }

    // Pages: always try the network first (fresh content), fall back to the offline page.
    if (request.mode === 'navigate') {
        event.respondWith(fetch(request).catch(() => caches.match(OFFLINE_URL)));
        return;
    }

    // Built CSS/JS, fonts and images: serve from cache once fetched (file names are versioned by the build).
    if (/^\/(build|fonts|images)\//.test(url.pathname)) {
        event.respondWith(
            caches.match(request).then((hit) => hit || fetch(request).then((response) => {
                if (response.ok) {
                    const copy = response.clone();
                    caches.open(VERSION).then((cache) => cache.put(request, copy));
                }
                return response;
            })),
        );
    }
});

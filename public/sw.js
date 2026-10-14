// Pancasuman Web - Image & Static Asset Cache Service Worker
const CACHE_NAME = 'pancasuman-media-v1';

self.addEventListener('install', (event) => {
    // Activate worker immediately without waiting
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    // Clean up old cache versions if any
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Only intercept GET requests
    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    // Identify if the request is an image or static asset
    const isImageDestination = request.destination === 'image';
    const isImagePath = url.pathname.includes('/storage/') ||
                        url.pathname.includes('/images/') ||
                        url.pathname.includes('/build/assets/') ||
                        /\.(webp|jpg|jpeg|png|gif|svg|ico|avif)(\?.*)?$/i.test(url.pathname);
    const isFont = url.hostname.includes('fonts.gstatic.com') ||
                   /\.(woff2?|ttf|eot|otf)(\?.*)?$/i.test(url.pathname);

    if (isImageDestination || isImagePath || isFont) {
        event.respondWith(
            caches.open(CACHE_NAME).then(async (cache) => {
                // 1. Try to serve from cache first
                const cachedResponse = await cache.match(request);
                if (cachedResponse) {
                    return cachedResponse;
                }

                // 2. Fetch from network and store in cache
                try {
                    const networkResponse = await fetch(request);
                    if (networkResponse && networkResponse.status === 200) {
                        // Store cloned response in cache for instant reloads
                        cache.put(request, networkResponse.clone());
                    }
                    return networkResponse;
                } catch (error) {
                    // In case offline and not found
                    return cachedResponse || Response.error();
                }
            })
        );
    }
});

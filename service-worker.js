const staticCacheName = 'site-static-v3';
const assets = [
    '/',
    'index.php',
    'css/main.min.css',
    'serviceprovider/assets/css/bootstrap.min.css',
    'https://kit.fontawesome.com/ab8cb4ecd9.js',
    // Add other CSS/JS files here
];

// install event
self.addEventListener('install', evt => {
    // console.log('service worker installed');
    self.skipWaiting(); // Force waiting service worker to become active
    evt.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            console.log('caching shell assets');
            return cache.addAll(assets);
        })
    );
});

// activate event
self.addEventListener('activate', evt => {
    // console.log('service worker activated');
    evt.waitUntil(
        caches.keys().then(keys => {
            // console.log(keys);
            return Promise.all(keys
                .filter(key => key !== staticCacheName)
                .map(key => caches.delete(key))
            );
        })
    );
});

// fetch event
self.addEventListener('fetch', evt => {
    // console.log('fetch event', evt);
    evt.respondWith(
        caches.match(evt.request).then(cacheRes => {
            return cacheRes || fetch(evt.request);
        })
    );
});

const CACHE_NAME = 'lsem-cache-v1';
const urlsToCache = [
    '/css/bootstrap.css',
    '/css/libs/colors-2.2.0.min.css',
    // '/css/css.css',
    '/css/fonts/glyphicons-halflings-regular.woff2',

    '/uploads/banner.png',
    '/uploads/logo.png',

    '/img/logos/facebook.png',
    '/img/logos/youtube.png',
    '/img/logos/linkedin.png',
    '/img/logos/pinterest.png',
    '/img/logos/twitter.png',
    '/img/logos/google_plus.png',

    // '/app.js',
    '/js/libs/jquery-3.2.1.min.js',
    '/js/libs/bootstrap-3.3.7.min.js',
    '/js/libs/tinymce/tinymce.min.js',
    '/js/libs/fontawesome-all.min.js',
    '/js/libs/bootbox-4.4.0.min.js',
    '/js/libs/pikaday-1.6.1.min.js',

    '/favicon.ico',

    'https://fonts.gstatic.com/s/lato/v11/PLygLKRVCQnA5fhu3qk5fQ.woff2',
    'https://fonts.gstatic.com/s/lato/v11/H2DMvhDLycM56KNuAtbJYA.woff2',
    'https://fonts.gstatic.com/s/lato/v11/1YwB1sO8YE1Lyjf12WNiUA.woff2',
];

self.addEventListener('install', function (event) {
    // Perform install steps
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function (cache) {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            }),
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request)
            .then(function (response) {
                    // Cache hit - return response
                    if (response) {
                        return response;
                    }
                    return fetch(event.request);
                },
            ),
    );
});
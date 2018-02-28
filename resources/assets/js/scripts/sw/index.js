export default function installServiceWorker() {
    window.addEventListener('load', function () {
        navigator
            .serviceWorker
            .register('/js/sw/index.js')
            .then((registration) => {
                console.log('ok', registration.scope);
            }, (err) => {
                console.log('ServiceWorker registration failed: ', err);
            });
    });
}
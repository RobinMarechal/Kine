export default function installServiceWorker() {
    window.addEventListener('load', function () {
        navigator
            .serviceWorker
            .register('/js/sw/index.js', {
                useCache: true,
            })
            .then(() => {
            }, () => {
            });
    });
}
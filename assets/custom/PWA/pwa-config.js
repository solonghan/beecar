if ('serviceWorker' in navigator) {
    console.log('Will service worker register?');
    navigator.serviceWorker.register('../assets/custom/PWA/service-worker.js')
    .then(function (reg) {
        console.log('yes it did');
    })
    .catch(function (err) {
        console.log("No it didn't. This happened:", err);
    })
}
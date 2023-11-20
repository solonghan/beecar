if('serviceWorker' in navigator) {
    // console.log('支援sw');
    navigator.serviceWorker.register('/assets/custom/PWA/service-worker.js', { scope: '/'})
    .then(registration => {
        // console.log('Signage Lab PWA: ServiceWorker registration successful with scope: ', registration.scope);
        // console.log('成功', registration);
        console.log('1');
    }).catch(() => {
        console.log('unable to get permission to notify');
    })
}
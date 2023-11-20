self.addEventListener("install", (evt) => {
	console.log("service worker has been installed");
});

self.addEventListener("activate", (evt) => {
	console.log("service worker has been activated");
});

self.addEventListener("fetch", (evt) => {});

self.addEventListener("notificationclick", function (event) {
	 event.notification.close();
	 // 檢查是否有 notification 屬性
    if (event.notification) {
        // 正確處理 notification
        var url = event.notification.data.url;

        event.waitUntil(
            clients.openWindow(url)
        );
    } else {
        console.error('Notification object is undefined or null.');
    }
	
});
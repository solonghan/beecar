let firebaseToken = "";
var firebaseConfig = {
	apiKey: "AIzaSyBzmqSHEELjkV89NyRRmEGRrENSzoxcvo4",
	authDomain: "beecar-d083b.firebaseapp.com",
	projectId: "beecar-d083b",
	storageBucket: "beecar-d083b.appspot.com",
	messagingSenderId: "358417318257",
	appId: "1:358417318257:web:673d5dd53415300708f6d0",
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();
if ("serviceWorker" in navigator) {
	// console.log('支援sw');
	navigator.serviceWorker
		.register("../assets/custom/firebase/sw.js")
		.then((registration) => {
			messaging.useServiceWorker(registration);
			messaging
				.requestPermission()
				.then(() => {
					get_token();
				})
				.catch(() => {
					console.log("unable to get permission to notify");
				});
		});
} else {
	console.log("不支援sw");
}

function get_token() {
	messaging
		.getToken({
			vapidKey:
				"BHt3eqpf75L70_qzLPHV95zrfGcw5TjOBJ4POp3Zym6QWObuMtWIBWexZCEWXfbT-rQsVNqgQ8ZveG89GJrq-Uk",
		})
		.then((currentToken) => {
			if (currentToken) {
				console.log(currentToken);
				firebaseToken = currentToken;
			} else {
				console.log(
					"No registration token available. Request permission to generate one."
				);
			}
		})
		.catch((err) => {
			console.log(err);
		});
}

messaging.onMessage((payload) => {
	console.log(payload);
	const data = payload.gcm.notification.type;
	if (data == "my_trip") {
		getDriverList();
	}
});

<!DOCTYPE html>
<html lang="en">

<head>
	<base href="<?= base_url() ?>">
	<meta charset="UTF-8">
	<title>firebase測試</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>

	<script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-messaging.js"></script>

</head>

<body>
	<script>
		let firebaseToken;
		// const firebaseConfig = {
		// 	apiKey: "AIzaSyAeMarfBWY3sAIQIR9iZwcTIvilypHvP7U",
		// 	authDomain: "strength-chat.firebaseapp.com",
		// 	projectId: "strength-chat",
		// 	storageBucket: "strength-chat.appspot.com",
		// 	messagingSenderId: "280722166045",
		// 	appId: "1:280722166045:web:b817de99c4530faf49d1f4",
		// 	measurementId: "G-D5P679BTZY"
		// };
		var firebaseConfig = {
			apiKey: "AIzaSyBzmqSHEELjkV89NyRRmEGRrENSzoxcvo4",
			authDomain: "beecar-d083b.firebaseapp.com",
			projectId: "beecar-d083b",
			storageBucket: "beecar-d083b.appspot.com",
			messagingSenderId: "358417318257",
			appId: "1:358417318257:web:673d5dd53415300708f6d0"
		};
		
		// Initialize
		// Initialize Firebase
		firebase.initializeApp(firebaseConfig);
		const messaging = firebase.messaging();
		if ('serviceWorker' in navigator) {
			// get_token()
			navigator.serviceWorker.register('<?= base_url() ?>assets/sw.js')
				.then(registration => {
					messaging.useServiceWorker(registration);
					messaging.requestPermission().then(() => {
							get_token()
							// console.log('允許通知');
						})
						.catch(() => {
							console.log('unable to get permission to notify');
						})
					// console.log('成功', registration);
				})
		} else {
			console.log('不支援sw');
		}
		messaging.onTokenRefresh((permission) => {
			get_token()
		})

		function get_token() {
			messaging.getToken({
				vapidKey: "BHt3eqpf75L70_qzLPHV95zrfGcw5TjOBJ4POp3Zym6QWObuMtWIBWexZCEWXfbT-rQsVNqgQ8ZveG89GJrq-Uk"
			}).then((currentToken) => {
				if (currentToken) {
					console.log(currentToken);
					firebaseToken = currentToken;
				} else {
					console.log('No registration token available. Request permission to generate one.');
				}
			}).catch((err) => {
				console.log(err);
			})
		}
	</script>



</body>

</html>
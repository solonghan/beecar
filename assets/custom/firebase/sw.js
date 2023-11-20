// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts("https://www.gstatic.com/firebasejs/8.8.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.8.1/firebase-messaging.js");

firebase.initializeApp({
	apiKey: "AIzaSyBzmqSHEELjkV89NyRRmEGRrENSzoxcvo4",
	authDomain: "beecar-d083b.firebaseapp.com",
	projectId: "beecar-d083b",
	storageBucket: "beecar-d083b.appspot.com",
	messagingSenderId: "358417318257",
	appId: "1:358417318257:web:673d5dd53415300708f6d0",
});
// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

// Firebase config — API key is public by design (client-side SDK).
// Mitigation: restrict this key by HTTP referrer in Google Cloud Console:
// APIs & Services → Credentials → API Key → Application restrictions → HTTP referrers
// Recommended: enable Firebase App Check for additional request verification.
var firebaseConfig = {
	apiKey: "AIzaSyC1325gTkxUBicZ1wtWarAX4T01Aoh8uAo",
	authDomain: "hoki-beli-illusions.firebaseapp.com",
	projectId: "hoki-beli-illusions",
	storageBucket: "hoki-beli-illusions.firebasestorage.app",
	messagingSenderId: "225645808904",
	appId: "1:225645808904:web:3763958bc65a9f2c4c30bd",
};

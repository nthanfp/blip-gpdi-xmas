// Firebase config — API key is public by design (client-side SDK).
// Mitigation: restrict this key by HTTP referrer in Google Cloud Console:
// APIs & Services → Credentials → API Key → Application restrictions → HTTP referrers
// Recommended: enable Firebase App Check for additional request verification.
var firebaseConfig = {
	apiKey: "AIzaSyA8LSxVwwjLhaFmRv4CeoMt2iwYPxNCNVE",
	authDomain: "itg-test-notification.firebaseapp.com",
	projectId: "itg-test-notification",
	storageBucket: "itg-test-notification.firebasestorage.app",
	messagingSenderId: "754272586958",
	appId: "1:754272586958:web:f986507b59fdfdb2cfd49f",
};

importScripts("./firebase-config.js");

try {
	importScripts(
		"https://www.gstatic.com/firebasejs/10.13.0/firebase-app-compat.js",
	);
	importScripts(
		"https://www.gstatic.com/firebasejs/10.13.0/firebase-messaging-compat.js",
	);
} catch (e) {
	console.error("Firebase CDN unavailable, FCM disabled:", e);
}

// ===== Firebase Cloud Messaging =====
if (typeof firebase !== "undefined") {
	firebase.initializeApp(firebaseConfig);
	var messaging = firebase.messaging();

	messaging.onBackgroundMessage(function (payload) {
		var data = payload.data || {};
		var notif = payload.notification || {};
		var title = notif.title || data.title || "IG Admin";
		var body = notif.body || data.body || "";

		if ("setAppBadge" in self.navigator) {
			self.navigator.setAppBadge().catch(function (err) {
				console.log("Badge error:", err);
			});
		}

		var showPromise = self.registration
			.showNotification(title, {
				body: body,
				icon: "./assets/icons/itg_logo.png",
				badge: "./assets/icons/android-chrome-192x192.png",
				data: { click_url: data.click_url || "./index.php/activities/redeem" },
			})
			.then(function () {
				return self.clients.matchAll({ type: "window" });
			})
			.then(function (clients) {
				clients.forEach(function (client) {
					client.postMessage({ type: "UPDATE_BADGE" });
				});
			});

		return showPromise;
	});

	self.addEventListener("notificationclick", function (event) {
		event.notification.close();

		if ("clearAppBadge" in self.navigator) {
			self.navigator.clearAppBadge();
		}

		var url =
			event.notification.data && event.notification.data.click_url
				? event.notification.data.click_url
				: "./index.php/activities/redeem";
		event.waitUntil(clients.openWindow(url));
	});
}

// ===== PWA Caching =====
var CACHE = "ig-v1";
var BASE = self.location.pathname.replace(/firebase-messaging-sw\.js$/, "");

self.addEventListener("install", function (e) {
	e.waitUntil(self.skipWaiting());
});

self.addEventListener("activate", function (e) {
	e.waitUntil(
		Promise.all([
			self.clients.claim(),
			caches.keys().then(function (k) {
				return Promise.all(
					k
						.filter(function (x) {
							return x !== CACHE;
						})
						.map(function (x) {
							return caches.delete(x);
						}),
				);
			}),
		]),
	);
});

self.addEventListener("fetch", function (e) {
    var u = new URL(e.request.url);
    if (u.origin !== location.origin) return;

    if (e.request.method !== "GET") {
        e.respondWith(fetch(e.request));
        return;
    }

    if (/\.(css|js|woff2?|png|jpg|ico|svg|ttf|eot)$/i.test(u.pathname)) {
        if (/firebase-config\.js$/i.test(u.pathname)) {
            e.respondWith(fetch(e.request));
            return;
        }
        e.respondWith(cacheFirst(e.request));
        return;
    }

    if (u.pathname.indexOf("/index.php/activities") !== -1) {
        e.respondWith(networkFirst(e.request));
    }
});

function cacheFirst(req) {
	return caches.match(req).then(function (hit) {
		return hit || fetchAndCache(req);
	});
}

function networkFirst(req) {
	return fetchAndCache(req).catch(function () {
		return caches.match(req).then(function (fallback) {
			return fallback || new Response("You're offline", { status: 503 });
		});
	});
}

function fetchAndCache(req) {
	return fetch(req).then(function (res) {
		if (!res.ok || res.type !== "basic") return res;
		var cloned = res.clone();
		return caches
			.open(CACHE)
			.then(function (cache) {
				return cache.put(req, cloned);
			})
			.then(function () {
				return res;
			});
	});
}

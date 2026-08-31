/** Again import google libraries */
importScripts("https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js");

/** Your web app's Firebase configuration 
 * Copy from Login 
 *      Firebase Console -> Select Projects From Top Naviagation 
 *      -> Left Side bar -> Project Overview -> Project Settings
 *      -> General -> Scroll Down and Choose CDN for all the details
*/

const config = {
  apiKey: "AIzaSyDb5ZArbK-w34RQpGaQ-8SnatvTsIpjPdg",
  authDomain: "kornotification.firebaseapp.com",
  projectId: "kornotification",
  storageBucket: "kornotification.firebasestorage.app",
  messagingSenderId: "690246647585",
  appId: "1:690246647585:web:4d81365406f7ae28e5c860"
};

firebase.initializeApp(config);

// Retrieve an instance of Firebase Data Messaging so that it can handle background messages.
const messaging = firebase.messaging();
/** BACKGROUND MESSAGE HANDLER */


self.addEventListener("notificationclick", function(event) {

    event.notification.close();

    // 👇 data mathi URL levu
    const url = event.notification.data?.click_action || "/";

    event.waitUntil(
        clients.matchAll({ type: "window", includeUncontrolled: true })
            .then(function(clientList) {

                // jo already tab open hoy to focus karo
                for (let i = 0; i < clientList.length; i++) {
                    let client = clientList[i];
                    if (client.url === url && 'focus' in client) {
                        return client.focus();
                    }
                }

                // nahi hoy to new tab open karo
                if (clients.openWindow) {
                    return clients.openWindow(url);
                }
            })
    );
});


self.addEventListener("push", function(event) {

    let data = {};
    try {
        data = event.data.json();
    } catch (e) {
        data = {
            title: "Notification",
            body: "You have a new message"
        };
    }

    const title = data.title || data.data?.title;
    const options = {
        body: data.body || data.data?.body,
        icon: data.notification?.image || data.data?.icon || "/icon.png",
        data: {
            click_action: data.data?.click_action
        }
    };

    // ✅ Show notification
    event.waitUntil(
        self.registration.showNotification(title, options)
    );

});
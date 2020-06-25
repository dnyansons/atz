importScripts('https://www.gstatic.com/firebasejs/6.0.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.0.2/firebase-messaging.js');
// Initialize Firebase
  var config = {
    apiKey: "AIzaSyB2N3Z-muoFs_jjjUU--QGuq9eeE7JK5hE",
          authDomain: "atzcart-1555070479316.firebaseapp.com",
          databaseURL: "https://atzcart-1555070479316.firebaseio.com",
          projectId: "atzcart-1555070479316",
          storageBucket: "atzcart-1555070479316.appspot.com",
          messagingSenderId: "281653898466",
          appId: "1:281653898466:web:a496c0b63350caf3"
  };
  firebase.initializeApp(config);
var messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  //console.log('[firebase-messaging-sw.js] Received background message ', payload); 
  // Customize notification here
  var received = JSON.stringify(payload, null, 2);
  var obj = JSON.parse(received);
  var notificationTitle = obj.data.title;
  var notificationOptions = {
    body: obj.data.body,
    icon: 'https://atzcart.com/firebaseicon.png'
  };

  return self.registration.showNotification(notificationTitle,notificationOptions);
});
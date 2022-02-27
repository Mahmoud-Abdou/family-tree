require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.channel("News").listen(".news-app", e => {
    // console.log(e);
});

Echo.channel(`News`)
    .listen('SendNewsNotification', (e) => {
        // console.log(e);
        // alert("SDA");
    });

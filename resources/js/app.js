import './echo';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
const userId = document
    .querySelector('meta[name="user-id"]')
    ?.getAttribute('content');

if (userId) {

    window.Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {

            console.log(notification);

            alert(notification.title + "\n" + notification.message);

        });

}

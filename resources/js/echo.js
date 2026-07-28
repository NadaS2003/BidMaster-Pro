// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
//
// window.Pusher = Pusher;
//
// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//
//     wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
//     wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
//     wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
//
//     forceTLS: false,
//
//     enabledTransports: ['ws', 'wss'],
// });

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: 80,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
});

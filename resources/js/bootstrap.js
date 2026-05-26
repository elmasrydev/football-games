import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const broadcaster = import.meta.env.VITE_PUSHER_APP_KEY ? 'pusher' : 'reverb';

window.Echo = new Echo({
    broadcaster: broadcaster,
    key: broadcaster === 'pusher' 
        ? import.meta.env.VITE_PUSHER_APP_KEY 
        : import.meta.env.VITE_REVERB_APP_KEY,
    cluster: broadcaster === 'pusher' 
        ? (import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1') 
        : undefined,
    wsHost: broadcaster === 'pusher' 
        ? undefined 
        : import.meta.env.VITE_REVERB_HOST,
    wsPort: broadcaster === 'pusher' 
        ? undefined 
        : (import.meta.env.VITE_REVERB_PORT ?? 80),
    wssPort: broadcaster === 'pusher' 
        ? undefined 
        : (import.meta.env.VITE_REVERB_PORT ?? 443),
    forceTLS: broadcaster === 'pusher' 
        ? true 
        : (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

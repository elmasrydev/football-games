import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const config = window.Laravel || {};
const broadcaster = config.broadcaster || (import.meta.env.VITE_PUSHER_APP_KEY ? 'pusher' : 'reverb');

window.Echo = new Echo({
    broadcaster: broadcaster,
    key: broadcaster === 'pusher' 
        ? (config.pusherKey || import.meta.env.VITE_PUSHER_APP_KEY) 
        : (config.reverbKey || import.meta.env.VITE_REVERB_APP_KEY),
    cluster: broadcaster === 'pusher' 
        ? (config.pusherCluster || import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1') 
        : undefined,
    wsHost: broadcaster === 'pusher' 
        ? undefined 
        : (config.reverbHost || import.meta.env.VITE_REVERB_HOST),
    wsPort: broadcaster === 'pusher' 
        ? undefined 
        : (config.reverbPort || import.meta.env.VITE_REVERB_PORT || 80),
    wssPort: broadcaster === 'pusher' 
        ? undefined 
        : (config.reverbPort || import.meta.env.VITE_REVERB_PORT || 443),
    forceTLS: broadcaster === 'pusher' 
        ? true 
        : (config.reverbScheme || import.meta.env.VITE_REVERB_SCHEME || 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

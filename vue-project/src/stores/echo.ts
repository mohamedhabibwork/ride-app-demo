import {defineStore} from "pinia";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

export const useEchoStore = defineStore('echo', () => {
    const echo : Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: 'mt1',
        wsHost: window.location.hostname,
        wsPort: 6001,
        forceTLS: false,
        disableStats: true,
        // @ts-ignore
        authEndpoint: `${(import.meta.env.VITE_API_URL).replace('/api')}/broadcasting/auth`,
        enabledTransports: ['ws', 'wss'],
    });
    return {
        echo
    }
});
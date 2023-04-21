/// <reference types="vite/client" />
/// <reference types="vue/macros-global" />
/// <reference types="pinia" />
/// <reference types="vue-router" />

interface ImportMetaEnv {
    readonly BASE_URL: string,
    readonly VITE_API_URL: string,
    readonly VITE_GOOGLE_MAPS_API_KEY: string,
    readonly VITE_PUSHER_APP_KEY: string,
    readonly VITE_PUSHER_HOST: string,
    readonly VITE_PUSHER_PORT: string,
    readonly VITE_PUSHER_SCHEME: string,
    readonly VITE_PUSHER_APP_CLUSTER: string,
}
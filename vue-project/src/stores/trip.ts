import {defineStore} from 'pinia'
import {ref} from "vue";

export const useTripStore = defineStore('trip', () => {
    const id = ref(null);
    const user_id = ref(null);

    const origin = ref({
        lat: null,
        lng: null,
    });

    const destination = ref({
        lat: null,
        lng: null,
    });

    const destination_name = ref('');
    const reset = () => {
        id.value = null;
        user_id.value = null;
        origin.value = {
            lat: null,
            lng: null,
        };
        destination.value = {
            lat: null,
            lng: null,
        };
        destination_name.value = '';
    };
    const  is_started = ref(null);
    const  is_accepted = ref(null);
    const  is_arrived = ref(null);
    const  is_complete = ref(null);
    const  is_cancelled = ref(null);
    return {
        id,
        user_id,
        origin,
        destination,
        destination_name,
        reset,
        is_started,
        is_accepted,
        is_arrived,
        is_complete,
        is_cancelled,
    }
});
<script setup>

import Loader from "@/components/Loader.vue";
import {useEchoStore} from "@/stores/echo";
import {onMounted, ref} from "vue";
import {useTripStore} from "@/stores/trip";
import {initMap} from "@/helpers/maps";
import {acceptTrip, getTrip} from "@/services/trip";
import {useLocationStore} from "@/stores/location";
import {useRouter} from "vue-router";

const EchoStore = useEchoStore();
const TripStore = useTripStore();
const LocationStore = useLocationStore();
const refMap = ref(null);
const title = ref('Waiting for a ride request...');
const router = useRouter();

onMounted(function () {
    LocationStore.updateCurrentLocation();
    EchoStore.echo.channel('drivers')
        .listen('Trip\\TripCreatedEvent', (e) => {
            if (e?.trip !== null) {
                TripStore.$patch(e.trip)
            }

            title.value = 'Trip Requested';

            if (TripStore?.id !== null && TripStore?.id !== undefined) {
                setTimeout(() => {
                    const {map} = initMap({
                        id: 'maps',
                        origin: TripStore?.origin,
                        destination: TripStore?.destination,
                        refMap,
                    });

                    new google.maps.Marker({
                        position: LocationStore.currentLocation.geometry,
                        map,
                        title: "My Location",
                    });
                }, 3000);

            }
        });
});
const handleAcceptTrip = async () => {

    await LocationStore.updateCurrentLocation();
    acceptTrip(TripStore.id, {
        driver_location: LocationStore.currentLocation.geometry
    }).then((res) => {
        LocationStore.$patch({
            destination: {
                name: 'passenger',
                geometry: res.data.origin,
            }
        });
        router.push({
            name: 'driving',
            query: {
                id: TripStore.id
            },
            params: {
                id: TripStore.id
            }
        });
    });
}
const handleDeclineTrip = () => {
    TripStore.reset();
    title.value = 'Waiting for a ride request...';
}
</script>

<template>
    <div class="text-center">
        <h2 class="text-3xl font-semibold p-3" v-text="title"></h2>
        <div v-if="!TripStore.id" class=" flex justify-center mt-8">
            <Loader/>
        </div>
        <div v-else>
            <div class="card p-5 w-1/2 mx-auto">
                <div id="maps" ref="refMap" class="w-full min-h-[500px]"></div>
                <div>
                    <div class="flex justify-between pt-5">
                        <div class="flex flex-col">
                            <button @click="handleAcceptTrip" class="btn btn-success">
                                Accept
                            </button>
                        </div>
                        <div class="flex flex-col">
                            <button @click="handleDeclineTrip" class="btn btn-red">
                                Decline
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
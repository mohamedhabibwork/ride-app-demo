<script setup>
import {onMounted, ref} from "vue";
import {getTrip} from "@/services/trip";
import {useRouter} from "vue-router";
import {useEchoStore} from "@/stores/echo";
import {initMap} from "@/helpers/maps";

const trip = ref(null);
const router = useRouter();
const tripId = router?.currentRoute?.value?.params?.id || router?.currentRoute?.value?.query?.id || 0;
const EchoStore = useEchoStore();


EchoStore.echo.channel(`trips.${tripId}`)
    .listen('Trip\\TripCreatedEvent', (e) => {
        console.log({
            'TripCreatedEvent': e
        })
        trip.value = e.trip;
        updateMarker(trip.value.driver_location, 'Driver Location');
        title.value = 'Trip Requested';

    }).listen('Trip\\TripAcceptEvent', (e) => {
    console.log({
        'accepted': e
    })
    trip.value = e.trip;
    updateMarker(trip.value.driver_location, 'Driver Location');
    title.value = 'Trip Accepted';
}).listen('Trip\\TripDriverArrivedEvent', (e) => {
    console.log({
        'arrive': e
    })
    trip.value = e.trip;
    updateMarker(trip.value.driver_location, 'Driver Location');
    title.value = 'Driver Arrived';
}).listen('Trip\\TripStartedEvent', (e) => {
    console.log({
        'start': e
    })
    trip.value = e.trip;
    updateMarker(trip.value.driver_location, 'Driver Location');
    title.value = 'Trip Started';
}).listen('Trip\\TripLocationUpdatedEvent', (e) => {
    console.log({
        'location': e
    })
    trip.value = e.trip;
    updateMarker(trip.value.driver_location, 'Driver Location');
    title.value = 'Trip Location Updated';
}).listen('Trip\\TripEndedEvent', (e) => {
    console.log({
        'complete': e
    })
    trip.value = e.trip;
    updateMarker(trip.value.driver_location, 'Driver Location');
    title.value = 'Trip Ended';
});

const refMap = ref(null);
const markerRef = ref(null);
const title = ref('Waiting for a ride driver...');
const updateMarker = (location = null, title = 'location') => {
    if (markerRef?.value){
        markerRef?.value?.setMap(null);
    }
    markerRef.value = new google.maps.Marker({
        position: location ?? trip.value.driver_location,
        map: refMap.value,
        title: title,
    });
}
onMounted(async function () {
    trip.value = (await getTrip(tripId)).data;
    initMap({
        id: 'maps',
        origin: trip.value.origin,
        destination: trip.value.destination,
        refMap,
    });
    updateMarker(trip.value.driver_location, 'Driver Location');
})
</script>

<template>
    <div class="text-center w-full">
        <h2 class="font-semibold text-3xl p-3" v-text="title"   ></h2>
        <div class="card w-3/4 mx-auto p-5 h-full">
            <div>
                <div id="maps" ref="refMap" class="w-full min-h-[500px]"/>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
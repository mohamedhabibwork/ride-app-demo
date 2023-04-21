<template>
    <div class="text-center">
        <h1 class="text-3xl font-semibold mb-4"> Here's your trip</h1>
        <div class="card w-1/2 mx-auto p-5 ">
            <div>
                <div class="overflow-hidden sm:rounded-md max-w-md mx-auto">
                    <div class="p5">
                        <div id="maps" ref="refMap" class="w-full min-h-[500px]"></div>
<!--                        <GoogleMap-->
<!--                                map-id="maps"-->
<!--                                :ref="gMap"-->
<!--                                :api-key="apiKey"-->
<!--                                style="width: 100%; height: 500px"-->
<!--                                :center="center" :zoom="11">-->
<!--&lt;!&ndash;                            <Marker :options="markerOptions"/>&ndash;&gt;-->
<!--&lt;!&ndash;                            <Marker :options="myMarkerOptions"/>&ndash;&gt;-->
<!--&lt;!&ndash;                            <Polyline :options="flightPath"/>&ndash;&gt;-->
<!--                        </GoogleMap>-->
                    </div>
                    <div class="p-3">
                        <p class="text-2xl">Going to <strong v-text="locationStore.destination.name"></strong></p>
                    </div>

                    <div class="flex-row w-full">
                        <p class="text-indigo-400 text-3xl" v-text="locationStore.destination?.distance + ' KM'"></p>
                    </div>
                    <div class="p-3 flex justify-end">
                        <button class="btn btn-dark-gray" @click="handleConfirmRide">
                            Let's Go
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useLocationStore} from "@/stores/location";
import {onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import {createTrip} from "@/services/trip";
import {initMap} from "@/helpers/maps";

const router = useRouter();
const locationStore = useLocationStore();
const handleConfirmRide = () => {
    createTrip({
        origin: locationStore.currentLocation.geometry,
        destination: locationStore.destination.geometry,
        destination_name: locationStore.destination.name,
        distance: locationStore.destination.distance,
        user_location: locationStore.currentLocation.geometry,
    }).then((res) => {
        router.push({
            name: 'trip',
            params: {
                id: res.data.id
            },
            query: {
                id: res.data.id
            },
        });
    });
}
 const refMap = ref(null);
onMounted(async function () {
    if (locationStore.destination.name === '') {
        router.push({
            name: 'location'
        });
    }

    await locationStore.calculateDistance();
    if (isNaN(locationStore.currentLocation.geometry.lat)) {
        router.push({
            name: 'location'
        });
    }

    initMap({
        id: 'maps',
        origin: locationStore.currentLocation.geometry,
        destination: locationStore.destination.geometry,
        refMap: refMap
    });
})
</script>
<script setup>
import {onMounted, onUnmounted, ref} from "vue";
import {useRouter} from "vue-router";
import {useTripStore} from "@/stores/trip";
import {useLocationStore} from "@/stores/location";
import {initMap} from "@/helpers/maps";
import {arriveTrip, completeTrip, getTrip, startTrip, updateTripLocation} from "@/services/trip";

const router = useRouter();
const TripStore = useTripStore();
const LocationStore = useLocationStore();

const refMap = ref(null);
const intervalRef = ref(null);
onUnmounted(() => {
    clearInterval(intervalRef.value);
    intervalRef.value = null;
});
onMounted(async function () {
    await LocationStore.updateCurrentLocation();
    if (TripStore.id === null) {
        TripStore.$patch(
            (await getTrip(
                router?.currentRoute?.value?.query?.id ?? router?.currentRoute?.value?.params?.id
            )).data
        );
    }
    if (LocationStore.destination === null || LocationStore.destination.name === '') {
        LocationStore.$patch({
            destination: {
                name: 'passenger',
                geometry: TripStore?.origin,
            }
        });
    }
    console.log('mounted', TripStore?.id);
    const {map} = initMap({
        id: 'maps',
        origin: TripStore?.origin,
        destination: TripStore?.destination,
        refMap,
    });
    var marker = new google.maps.Marker({
        position: LocationStore.currentLocation.geometry,
        map,
        title: "My Location",

        label: {
            text: "♥", // codepoint from https://fonts.google.com/icons
            fontFamily: "Material Icons",
            color: "#ffffff",
            fontSize: "18px",
        },
    });

    if (TripStore.is_complete || TripStore.is_cancelled) {
        return;
    }
    intervalRef.value = setInterval(async () => {
        await LocationStore.updateCurrentLocation();
        marker.setMap(null);
        marker = new google.maps.Marker({
            position: LocationStore.currentLocation.geometry,
            map,
            title: "My Location",
            label: {
                text: "♥", // codepoint from https://fonts.google.com/icons
                fontFamily: "Material Icons",
                color: "#ffffff",
                fontSize: "18px",
            },
        });

        await updateTripLocation(TripStore.id, {
            driver_location: LocationStore.currentLocation.geometry
        });
    }, 10000);
});
const start_code = ref('');
const start_code_error = ref('');
const handleArrived = () => {
    arriveTrip(TripStore.id)
        .then((res) => {
            TripStore.$patch(res.data);
        });
}
const handleStartTrip = () => {
    if (start_code.value.length !== 6) {
        start_code_error.value = 'Start code must be 6 digits';
        return;
    }
    startTrip(TripStore.id, {
        start_code: start_code.value
    })
        .then((res) => {
            TripStore.$patch(res.data);
        }).catch((err) => {
        console.log(err.response.data)
        start_code_error.value = err?.response?.data?.message || '';
    });
}
const handleCompleteTrip = () => {
    completeTrip(TripStore.id)
        .then((res) => {
            TripStore.$patch(res.data);
        });
    clearInterval(intervalRef.value);
    intervalRef.value = null;
}
</script>

<template>
    <div class="text-center">
        <div>
            <h1 class="text-3xl font-semibold mb-4">Driving To Passenger</h1>
        </div>
        <div class="flex justify-center">
            <div class="card w-3/4 p-5">
                <div id="maps" ref="refMap" class="w-full h-[500px]"></div>
                <div class="p-5">
                    <div class="flex justify-between">
                        <div class="flex flex-col">
                            <!--                          <span class="text-lg font-semibold">Passenger</span>-->
                            <!--                          <span class="text-sm text-gray-500">+1 123 456 7890</span>-->
                        </div>
                        <div class="flex flex-col" v-if="!TripStore.is_cancelled">
                            <div v-if="!TripStore.is_arrived">
                                <button @click="handleArrived" class="btn btn-primary btn-lg btn-block">
                                    Arrived
                                </button>
                            </div>
                            <div v-else-if="!TripStore.is_started">
                                <input class="input" v-model="start_code"
                                       :class="{'input-error':start_code_error.length > 0}" min="100000" max="999999"
                                       required/>
                                <span class="text-red-500 text-sm">{{ start_code_error }}</span>
                                <button @click="handleStartTrip" class="btn btn-success btn-lg btn-block mt-2">
                                    Start Trip
                                </button>
                            </div>
                            <div v-else-if="!TripStore.is_complete">
                                <button @click="handleCompleteTrip" class="btn btn-success btn-lg btn-block">
                                    Trip Complete
                                </button>
                            </div>
                            <div v-else>
                                <button class="btn btn-dark-gray btn-lg btn-block" disabled>
                                    Trip Finished
                                </button>
                            </div>
                        </div>
                        <div v-else>
                            <div class="flex flex-col">
                                <span class="text-lg font-semibold">Trip Cancelled</span>
                                <span class="text-sm text-gray-500">Reason:</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
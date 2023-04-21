<script setup>
import Places from "@/components/Places.vue";
import {ref} from "vue";
import {useLocationStore} from "@/stores/location";
import {useRouter} from "vue-router";

const locationStore = useLocationStore();
const router = useRouter();
const location = ref({
    lat: null,
    lng: null,
    address: null,
    name: null,
    location_id: null,
    route: {},
});


const handleSubmit = async (e) => {
    if (location.value.name === '') {
        alert('Please select a location');
        return;
    }
    const distance = Math.round(parseFloat(location.value?.route?.distance?.value) / 1000);
    locationStore.$patch({
        destination: {
            name: location.value.name,
            address: location.value.address,
            geometry: {
                lat: location.value.lat, lng: location.value.lng
            },
            distance: isNaN(distance) ? null : distance,
        }
    });
    await locationStore.updateCurrentLocation();
    router.push({
        name: 'map'
    });
}
</script>

<template>
    <div class="">

        <h1 class="text-5xl text-center py-8">
            Where Are We going ?
        </h1>
        <div class="card pb-5 mx-auto w-3/4  overflow-x-hidden justify-items-center justify-between bg-gray-300">
            <form @submit.prevent="handleSubmit" class="w-full">
                <div class="overflow-hidden sm:rounded-md flex justify-center text-center justify-items-center w-full mx-auto ">
                    <div class="px-4 sm:p-6 sm:rounded-lg ">
                        <div class="flex-row w-full">
                            <Places :get-current-location="false"
                                    @selected-area="(n)=> location = n"/>
                        </div>
                        <div class="flex-row w-full">
                            <p class="text-green-400" v-text="location?.route?.start_address"></p>
                            <p class="text-red-400" v-text="location?.route?.end_address"></p>
                            <p class="text-indigo-400 text-3xl" v-text="location?.route?.distance?.text"></p>
                            <p class="text-orange-400 text-3xl" v-text="location?.route?.duration?.text"></p>
                        </div>
                    </div>
                </div>
                <div class="text-center pt-8 flex justify-items-center justify-center w-full">
                    <button class="btn btn-dark-gray">Submit</button>
                </div>
            </form>

        </div>
    </div>
</template>


<style scoped>

</style>
<script setup>
import {useRouter} from "vue-router";
import {getDriver} from "@/services/auth";

const router = useRouter();
const  handleFindARide = () => {
    router.push({
        name: 'location'
    });
}
const  handleStartDriving = () => {
    getDriver().then((res) => {
        if (res.data.driver) {
            router.push({
                name: 'standby'
            });
        } else {
            router.push({
                name: 'driver'
            });
        }
    }).catch((err) => {
        console.log(err);
    });
}
</script>

<template>
    <div>
        <div class="card mx-auto w-3/6 pb-8" >
            <h2 class="text-5xl text-center py-8">Let's Get Stared</h2>
            <div class="w-full flex justify-around justify-items-center">
                <button
                    @click="handleStartDriving"
                    class="flex btn btn-dark-gray">Start Driving</button>
                <button
                    @click="handleFindARide"
                    class="flex btn btn-dark-gray"
                >Find A Ride</button>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
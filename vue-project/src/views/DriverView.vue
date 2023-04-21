<script setup>
import {ref} from "vue";
import {vMaska} from "maska";
import {createDriver} from "@/services/driver";
import {useRouter} from "vue-router";
const router = useRouter();
const driver = ref({
    year: null,
    make: null,
    model: null,
    color: null,
    license_plate: null,
})

const handleSaveDriver = () => {
    createDriver(driver.value).then((res) => {
        router.push({
            name: 'standby'
        });
    }).catch((err) => {
        console.log(err);
    });
}
</script>

<template>
    <form @submit.prevent="handleSaveDriver" class="card w-3/4 mx-auto p-5">
        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="year" class="block text-sm font-medium leading-6 text-gray-900">Year</label>
                        <div class="mt-2">
                            <input type="text" v-maska data-maska="20##" placeholder="2015" min="2010" max="2024"
                                   name="year" required v-model="driver.year" id="year" autocomplete="year"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="make" class="block text-sm font-medium leading-6 text-gray-900">Make</label>
                        <div class="mt-2">
                            <input type="text" name="make" required v-model="driver.make" id="make"
                                   autocomplete="family-name"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="model" class="block text-sm font-medium leading-6 text-gray-900">Model</label>
                        <div class="mt-2">
                            <input type="text" name="model" required v-model="driver.model" id="model"
                                   autocomplete="family-name"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="color" class="block text-sm font-medium leading-6 text-gray-900">Color</label>
                        <div class="mt-2">
                            <input type="color" name="color" required v-model="driver.color" id="color"
                                   autocomplete="family-name"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="license_plate" class="block text-sm font-medium leading-6 text-gray-900">License
                            Plate</label>
                        <div class="mt-2">
                            <input type="text" name="license_plate" required v-model="driver.license_plate"
                                   id="license_plate" autocomplete="family-name"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div>
    </form>
</template>


<style scoped>

</style>
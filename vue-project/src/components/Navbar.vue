<script setup>
import {RouterLink, useRouter} from "vue-router";
import {logout} from "@/services/auth";
import {useAuthStore} from "@/stores/auth";
const authStore =  useAuthStore();


const handleLogout = () => {
    logout().then((res) => {
        authStore.logoutUser();
        router.push({
            name: 'home'
        });
    }).catch((err) => {
        console.log(err);
    });
}
const router = useRouter();

</script>
<template>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <RouterLink v-show="authStore.isAuthenticated" to="/" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'home','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'home'}" class="block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Dashboard</RouterLink>
                            <RouterLink v-show="authStore.isAuthenticated" to="/location" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'location','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'location'}" class=" rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Location</RouterLink>
                            <RouterLink v-show="authStore.isAuthenticated" to="/landing" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'landing','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'landing'}" class="block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Landing</RouterLink>
                            <RouterLink v-show="authStore.isAuthenticated && authStore?.user?.driver" to="/standby" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'standby','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'standby'}" class="block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">StandBy</RouterLink>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block" v-show="authStore.isAuthenticated">
                    <div class="ml-4 flex items-center md:ml-6">
                        <button  @click.prevent="handleLogout" class="block btn btn-red">Sign out</button>
                    </div>
                </div>
                <div class="hidden md:block"  v-show="!authStore.isAuthenticated">
                    <div class="ml-4 flex items-center md:ml-6">
                        <RouterLink to="/login" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Login</RouterLink>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Menu open: "hidden", Menu closed: "block" -->
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Menu open: "block", Menu closed: "hidden" -->
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                <RouterLink v-show="authStore.isAuthenticated" to="/" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'home','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'home'}" class="block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Dashboard</RouterLink>
                <RouterLink v-show="authStore.isAuthenticated" to="/location" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'location','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'location'}" class="block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Location</RouterLink>
                <RouterLink v-show="authStore.isAuthenticated" to="/landing" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'landing','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'landing'}" class="block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Landing</RouterLink>
                <RouterLink v-show="authStore.isAuthenticated && authStore?.user?.driver" to="/standby" :class="{'bg-gray-900 text-white': $router.currentRoute.value.name === 'standby','text-gray-300 hover:bg-gray-700 hover:text-white' : $router.currentRoute.value.name !== 'standby'}" class="block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">StandBy</RouterLink>
                <RouterLink v-show="!authStore.isAuthenticated" to="/login" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Login</RouterLink>

                <!--                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Team</a>-->
            </div>
            <div class="border-t border-gray-700 pb-3 pt-4 " v-show="authStore.isAuthenticated">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white" v-text="`${authStore?.user?.first_name} ${authStore?.user?.last_name}`"></div>
                        <div class="text-sm font-medium leading-none text-gray-400" v-text="authStore?.user?.email"></div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <button @click.prevent="handleLogout" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign out</button>
                </div>
            </div>
        </div>
    </nav>
</template>



<style scoped>

</style>
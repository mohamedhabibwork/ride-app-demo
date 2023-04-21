<template>
    <div class="h-full">
        <div class="h-full bg-gray-100">
            <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm" v-show="!waitingOnVerification">
                    <form class="space-y-6" @submit.prevent="handleLogin">
                        <div>
                            <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone Number</label>
                            <div class="mt-2">
                                <input id="phone" name="phone" v-model.lazy="loginForm.phone"
                                       v-maska data-maska="01#########" type="tel"
                                       autocomplete="phone" required
                                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="text-sm">
                                    <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input id="password" name="password"  v-model.lazy="loginForm.password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                        </div>
                    </form>

<!--                    <p class="mt-10 text-center text-sm text-gray-500">-->
<!--                        Not a member?-->
<!--                        <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Start a 14 day free trial</a>-->
<!--                    </p>-->
                </div>
                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm" v-show="!!waitingOnVerification">
                    <form class="space-y-6" @submit.prevent="handleVerification">
                        <div>
                            <label for="login_code" class="block text-sm font-medium leading-6 text-gray-900">Login Code</label>
                            <div class="mt-2">
                                <input id="login_code"
                                       name="login_code"
                                       v-model.lazy="loginForm.login_code"
                                       v-maska data-maska="######"
                                       type="text" autocomplete="login_code"
                                       required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-indigo">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { vMaska } from 'maska'
import { reactive, ref, onMounted, computed } from 'vue'
import {useRouter} from "vue-router";
import {login, loginVerification} from "@/services/auth";
const router = useRouter()

const loginForm = reactive({
    phone: '',
    password: '',
    login_code: '',
})

const waitingOnVerification = ref(false)

onMounted(() => {
    if (localStorage.getItem('token')) {
        router.push({
            name: 'landing'
        })
    }
    waitingOnVerification.value = false;
})
const getFormattedCredentials = () => {
    return {
        phone: loginForm.phone.replaceAll(' ', '').replace('(', '').replace(')', '').replace('-', ''),
        login_code: loginForm.login_code,
        password: loginForm.password
    }
}
const handleLogin = () => {
    const {phone, password} = getFormattedCredentials()
    login(phone, password)
        .then((response) => {
            waitingOnVerification.value = true
            // console.log(response.data)
        })
        .catch((error) => {
            console.log(error)
        })
}
const handleVerification = () => {
    const {phone,login_code} = getFormattedCredentials()

    loginVerification(phone, login_code)
        .then((response) => {
            const { token , user } = response.data;
            localStorage.setItem('user', user)
            localStorage.setItem('token', token)
            router.push({
                name: 'landing'
            })
        })
        .catch((error) => {
            console.log(error)
        })
}

</script>

<style scoped>

</style>
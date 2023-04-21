import {defineStore} from "pinia";
import {ref} from "vue";

export const useAuthStore = defineStore('auth', () => {
    const isAuthenticated =  ref(localStorage.getItem('token') !== null);
    const user = ref(localStorage.getItem('user') !== null ? JSON.parse(localStorage.getItem('user') || '{}') : null);

    const setUser = (newUser: any) => {
        localStorage.setItem('user', JSON.stringify(newUser));
        user.value = newUser
        isAuthenticated.value = true;
    }
    const logoutUser = () => {
        isAuthenticated.value = false;
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        user.value = null;
    };
    return {
        isAuthenticated,
        user,
        setUser,
        logoutUser
    }

})
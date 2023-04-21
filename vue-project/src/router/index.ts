import {createRouter, createWebHistory} from 'vue-router'
import {getCurrentUser} from "@/services/auth";
import {useAuthStore} from "@/stores/auth";

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "HomeView" */ '../views/HomeView.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/',
        name: 'login',
        component: () => import(/* webpackChunkName: "LoginView" */ "../views/LoginView.vue"),
    },
    {
        path: '/landing',
        name: 'landing',
        component: () => import(/* webpackChunkName: "LandingView" */ "../views/LandingView.vue"),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/location',
        name: 'location',
        component: () => import(/* webpackChunkName: "LocationView" */ "../views/LocationView.vue"),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/map',
        name: 'map',
        component: () => import(/* webpackChunkName: "MapView" */ "../views/MapView.vue"),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/trip/:id',
        name: 'trip',
        component: () => import(/* webpackChunkName: "TripView" */ "../views/TripView.vue"),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/standby',
        name: 'standby',
        component: () => import(/* webpackChunkName: "StandbyView" */ "../views/StandbyView.vue"),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/driver',
        name: 'driver',
        component: () => import(/* webpackChunkName: "DriverView" */ "../views/DriverView.vue"),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/driving',
        name: 'driving',
        component: () => import(/* webpackChunkName: "DrivingView" */ "../views/DrivingView.vue"),
        meta: {
            requiresAuth: true
        }
    }
];


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes
})
router.beforeEach((to, from) => {

    if (to.name === 'login') {
        return true
    }

    if (to?.meta?.requiresAuth && !localStorage.getItem('token')) {
        return {
            name: 'login'
        }
    }

    checkTokenAuthenticity()
})

const checkTokenAuthenticity = () => {
    const {logoutUser,setUser,} = useAuthStore();

    getCurrentUser()
        .then((response: any): void => {
            setUser(response.data.user);
        })
        .catch(() => {
            logoutUser();
            router.push({
                name: 'login'
            })
        });
}

export default router

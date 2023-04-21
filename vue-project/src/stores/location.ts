import {defineStore} from "pinia";
import {reactive} from "vue";
import {getUserLocation} from "@/helpers/location";

export const useLocationStore = defineStore('location', () => {

    const destination = reactive({
        name: '',
        address: '',
        distance: null,
        geometry: {
            lat: null,
            lng: null,
        },
    })
    const currentLocation = reactive({
        geometry: {
            lat: null,
            lng: null,
        }
    })

    const calculateDistance = async () => {
        // @ts-ignore
        const directionsService = new google.maps.DirectionsService();
        // @ts-ignore
        const origin = new google.maps.LatLng(currentLocation.geometry.lat, currentLocation.geometry.lng);
        // @ts-ignore

        const destinationTo = new google.maps.LatLng(destination.geometry.lat, destination.geometry.lng);
        const request = {
            origin: origin,
            destination: destinationTo,
            // @ts-ignore
            travelMode: google.maps.TravelMode.DRIVING
        };
        await directionsService.route(request, function (response: any, status: any) {
            // @ts-ignore
            if (status == google.maps.DirectionsStatus.OK) {
                const {
                    distance,
                    // duration,
                    // end_address,
                    // start_address,
                    // start_location,
                    // end_location
                } = response.routes[0].legs[0];

                destination.name = response?.routes[0]?.summary;
                // @ts-ignore
                destination.distance = parseFloat(distance.value) / 1000;
                console.log({response})
            }
        });
    }
    const updateCurrentLocation = async () => {
        const newLocation = await getUserLocation();
        currentLocation.geometry = {
            // @ts-ignore
            lat: newLocation.coords.latitude,
            // @ts-ignore
            lng: newLocation.coords.longitude
        }
    }
    return {
        destination,
        currentLocation,
        calculateDistance,
        updateCurrentLocation,
    };

});
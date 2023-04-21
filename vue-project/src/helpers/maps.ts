// This file is used to calculate the route between the origin and destination
// and display it on the map.
import {ref} from "vue";

export const
    calculateAndDisplayRoute = (directionsService: any, directionsRenderer: any, {
        origin,
        destination
    }: any) => {
        directionsService
            .route({
                origin: origin,
                destination: destination,
                avoidTolls: false,
                avoidHighways: false,
                // @ts-ignore
                travelMode: google.maps.TravelMode.DRIVING
            })
            .then((response: any) => {
                directionsRenderer.setDirections(response);
            })
            .catch((e: any) => window.alert("Directions request failed due to " + status));
    }
export const initMap = ({
                            id = 'maps',
                            origin,
                            destination,
                            refMap = null,
                            zoom = 10,
                        }: any) => {

    let mapEl = (refMap?.value ? refMap?.value : document.getElementById(id)) as HTMLElement ;

    if (!mapEl) {
        console.error('Map element not found');
        return;
    }

    // @ts-ignore
    const directionsService = new google.maps.DirectionsService();
    // @ts-ignore
    const directionsRenderer = new google.maps.DirectionsRenderer();
    // @ts-ignore
    const map = new google.maps.Map(document.getElementById(id), {
        zoom: zoom,
        center: destination,
    });

    directionsRenderer.setMap(map);

    if (origin?.lat && origin?.lng && destination?.lat && destination?.lng) {
        calculateAndDisplayRoute(directionsService, directionsRenderer, {
            origin,
            destination
        });
    }

    return {
        mapEl,
        map,
        directionsService,
        directionsRenderer,
    };
}
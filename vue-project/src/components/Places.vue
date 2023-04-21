<script>
import {defineComponent} from "vue";
import {getUserLocation} from "@/helpers/location";

export default defineComponent({
    name: "Places",
    props: {
        placeholder: {
            type: String,
            default: 'Enter a location'
        },
        id: {
            type: String,
            default: `places-search-${Math.floor(Math.random() * 100)}`
        },
        getCurrentLocation:{
            type: Boolean,
            default: true
        },
        startLocation:{
            type: Object,
            default: null
        }
    },
    data() {
        return {
            location: '',
            places: [],
            selected: {},
            service: null,
            apiKey: import.meta.env.VITE_GOOGLE_MAPS_API_KEY || 'AIzaSyCAqdwRPpTtDGc6lWZKlSO0EPgkAKRo-8o',
            currentLocation:{
                lat: null,
                lng: null,
            }
        }
    },
    metaInfo: function () {
        return {
            script: [
                {
                    src: `https://maps.googleapis.com/maps/api/js?key=${this.apiKey}&libraries=places`,
                    async: true,
                    defer: true
                }
            ]
        }
    },
    methods: {
        MapsInit: function () {
            this.service = new google.maps.places.AutocompleteService()
        },
        search: async function () {
            try {
                const results = await this.service.getPlacePredictions({
                    input: this.location,
                    // types: ['(regions)'],
                    // componentRestrictions: {
                    //     country: 'eg'
                    // }
                })
                this.places = results.predictions
            } catch (error) {
                console.log(error)
            }
        },
        getLatLong: async function (location) {
            try {
                self = this
                const geocoder = new google.maps.Geocoder()

                geocoder.geocode({
                    'placeId': location
                }, async (results, status) => {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const destinationObj = {
                            lat: await results[0].geometry.location.lat(),
                            lng: await results[0].geometry.location.lng(),
                            name: results[0].formatted_address,
                        };
                        console.log(results[0],results)
                        if (this.getCurrentLocation){
                            const directionsService = new google.maps.DirectionsService();
                            const origin = new google.maps.LatLng(this.currentLocation.lat, this.currentLocation.lng);

                            const destination = new google.maps.LatLng(destinationObj.lat, destinationObj.lng);
                            const request = {
                                origin: origin,
                                destination: destination,
                                travelMode: google.maps.TravelMode.DRIVING
                            };
                            await directionsService.route(request, function (response, status) {
                                if (status == google.maps.DirectionsStatus.OK) {
                                    const { distance, duration,end_address , start_address , start_location, end_location } = response.routes[0].legs[0];

                                    destinationObj.name = response?.routes[0]?.summary;
                                    destinationObj.route = { distance, duration,end_address , start_address , start_location:{
                                        lng:start_location.lng(),
                                        lat:start_location.lat()
                                        }, end_location:{
                                            lng:end_location.lng(),
                                            lat:end_location.lat()
                                        } };
                                    console.log({response})
                                }
                            });
                        }
                        const data = {
                            address: results[0].formatted_address,
                            location_id: results[0].place_id,
                            ...destinationObj
                        };
                        self.$emit('selectedArea', data)
                    }
                })
            } catch (error) {
                console.log(location)
                console.log(`Error getting LatLon coords: ${error}`)
            }
        },
        selectPlace: function (place) {
            this.location = place.description
            this.selected.description = place.description
            this.selected.location_id = place.place_id
            this.getLatLong(place.place_id)
            this.places = []
        },
        clearForm: function () {
            this.location = ''
            this.selected = {}
            this.places = []
            this.$emit('selectedArea', {})
        }
    },
    watch: {
        location: function () {
            if (this.service === null) {
                this.MapsInit()
            }
            if (this.location.length === 0) {
                this.clearForm()
            }
        },
    },
    created() {
        if (this.getCurrentLocation){
            if (this.startLocation === null){
                getUserLocation().then((location) => {
                    this.currentLocation = {
                        lat:location.coords.latitude,
                        lng:location.coords.longitude
                    }
                    this.$emit('currentLocation', this.currentLocation)
                })
            }else{
                this.currentLocation = this.startLocation
                this.$emit('currentLocation', this.currentLocation)
            }
        }
    }
})
</script>

<template>
    <div>
        <slot>
            <input
                    type="text"
                    :placeholder="placeholder || 'Search'"
                    class="input input-lg"
                    v-model="location"
                    @keyup="search"
                    :aria-expanded="places.length > 0 ? true : false"
                    aria-controls="places-dropdown"
            />
        </slot>
        <div class="">
            <ul v-if="places.length > 0" class=" z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3">
                <li class="text-gray-900 relative cursor-default w-full select-none py-2 pl-3 pr-9" v-for="place in places" :key="place.place_id" @click="selectPlace(place)" role="option">
                    <div class="flex items-center">
                        <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                        <span class="font-normal ml-3 block truncate" v-text="place.description"></span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- <input
            type="text"
            list="places"
            :placeholder="placeholder || 'Search'"
            class="form-control"
            v-model="location"
            @keyup="search"
        />
        <datalist id="places" class="places-dropdown">
            <option class="place" v-for="place in places" :key="place.place_id" @click="selectPlace(place)">{{ place.description }}</option>
        </datalist> -->
    </div>
</template>


<style scoped>

</style>
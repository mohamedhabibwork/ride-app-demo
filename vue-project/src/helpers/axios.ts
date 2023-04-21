// @ts-ignore
import axios from "axios";

// @ts-ignore
export default ():axios.AxiosInstance => axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api/',
    headers: {
        'Accept': 'application/json',
        'Accept-Language': 'en-US',
        'Authorization': 'Bearer ' + localStorage.getItem('token') || sessionStorage.getItem('token')
    }
});


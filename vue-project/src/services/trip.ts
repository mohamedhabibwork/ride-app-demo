import axios from "@/helpers/axios";

export const createTrip = (data: any) => {
    return axios().post("/trips", data);
}

export const getTrips = () => {
    return axios().get("/trips");
}

export const getTrip = (id: number) => {
    return axios().get(`/trips/${id}`);
}

export const updateTrip = (id: number, data: any) => {
    return axios().put(`/trips/${id}`, data);
}

export const deleteTrip = (id: number, data: any = {}) => {
    return axios().delete(`/trips/${id}`, data);
}

export const acceptTrip = (id: number, data: any = {}) => {
    return axios().post(`/trips/${id}/accept`, data);
}

export const arriveTrip = (id: number, data: any = {}) => {
    return axios().post(`/trips/${id}/arrive`, data);
}

export const rejectTrip = (id: number, data: any = {}) => {
    return axios().post(`/trips/${id}/reject`, data);
}

export const cancelTrip = (id: number, data: any = {}) => {
    return axios().post(`/trips/${id}/cancel`, data);
}

export const completeTrip = (id: number, data: any = {}) => {
    return axios().post(`/trips/${id}/complete`, data);
}
export const startTrip = (id: number, data: any = {}) => {
    return axios().post(`/trips/${id}/start`, data);
}

export const updateTripLocation = (id: number, data: any) => {
    return axios().post(`/trips/${id}/location`, data);
}
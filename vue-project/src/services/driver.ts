import axios from "@/helpers/axios";

export const getDrivers = () => {
    return axios().get('/drivers');
}

export const getDriver = (id: string) => {
    return axios().get(`/drivers/${id}`);
}

export const createDriver = (data: any) => {
    return axios().post('/drivers', data);
}

export const updateDriver = (id: string, data: any) => {
    return axios().put(`/drivers/${id}`, data);
}

export const deleteDriver = (id: string) => {
    return axios().delete(`/drivers/${id}`);
}
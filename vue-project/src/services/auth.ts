import axios from "@/helpers/axios";

export const login = (phone: string, password: string) => {
    return axios().post(
        "/login",
        {password, phone}
    );
}

export const loginVerification = (phone: string, login_code: string) => {
    return axios().post(
        "/login-verification",
        {login_code, phone}
    );
}

export const register = (name: string, email: string, password: string, phone: string) => {
    return axios().post(
        "/register",
        {email, password, phone}
    );
}

export const logout = () => {
    return axios().post("/logout");
}
export const getDriver = () => {
    return axios().get("/driver");
}

export const getCurrentUser = () => {
    return axios().get("/user");
}

export const existsPhone = (phone: string) => {
    return axios().post(`/exists-phone`, {
        phone
    });
}


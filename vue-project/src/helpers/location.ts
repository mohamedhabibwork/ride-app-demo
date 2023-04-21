export const getUserLocation = async () => {
    return new Promise((res, rej) => {
        navigator.geolocation.getCurrentPosition(res, rej)
    })
}
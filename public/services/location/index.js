function getCurrentDeviceLocation(successCallback) {
    return navigator.geolocation.getCurrentPosition((position) => {
        const latLng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        }
        successCallback(latLng)
    }, () => {
    }, {maximumAge: 60000, timeout: 5000, enableHighAccuracy: true});
}



const initializeMap = (id, initialCoords) => {

    const map = L.map(id).setView(initialCoords, 13);

    L.tileLayer(
        "https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=ltrALA6k9d2bkEeRn8Fn",
        {
            attribution:
                '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>'
        }
    ).addTo(map);

    return map;
}

const addMarker = (map, position, icon) =>{
    if ( !icon){
        return L.marker([position.lat,position.lng]).addTo(map);

    }

    const markerIcon = L.icon({
        iconUrl: `/icons/svgs/solid/${icon}.svg`,
        shadowUrl: `/icons/svgs/solid/${icon}.svg`,
        iconSize: [20, 20],
    });

    return L.marker([position.lat,position.lng], {icon: markerIcon}).addTo(map);
}

const setMarkerLocation = (marker,newPosition) => {
    marker.setLatLng(newPosition)
}


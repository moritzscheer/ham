
var map = L.map('map', { zoomControl: false }).setView([48.1500327, 11.5753989], 6);

var myAPIKey = "3e6cf917f419488cbeec8ac503210f17";
var mapURL = L.Browser.retina
    ? `https://maps.geoapify.com/v1/tile/{mapStyle}/{z}/{x}/{y}.png?apiKey={apiKey}`
    : `https://maps.geoapify.com/v1/tile/{mapStyle}/{z}/{x}/{y}@2x.png?apiKey={apiKey}`;

// Add map tiles layer. Set 20 as the maximal zoom and provide map data attribution.
L.tileLayer(mapURL, {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    apiKey: myAPIKey,
    mapStyle: "osm-bright", // More map styles on https://apidocs.geoapify.com/docs/maps/map-tiles/
    maxZoom: 20
}).addTo(map);

var marker = null;








const control = L.control.range({
    position: 'topright',
    min: 5,
    max: 100,
    value: 5,
    step: 1,
    orient: 'horizontal',
});

// Get a user location roughly
fetch(`https://api.geoapify.com/v1/ipinfo?apiKey=${myAPIKey}`).then(result => result.json()).then(result => {
    map.setView([result.location.latitude, result.location.longitude], 8);
});

var suggestionMarkers = [];
const suggestionsMarkerIcon = L.icon({
    iconUrl: `https://api.geoapify.com/v1/icon/?type=awesome&shadowColor=%23fafafa&color=%23fff351&size=small&scaleFactor=2&apiKey=${myAPIKey}` /* get an API Key on https://myprojects.geoapify.com */,
    iconSize: [25, 37], // size of the icon
    iconAnchor: [12.5, 34], // the point on the icon which will correspond to the marker's location, substruct the shadow
    popupAnchor: [0, -36] // the point from which the popup should open relative to the iconAnchor
});

const resultMarkerIcon = L.icon({
    iconUrl: `https://api.geoapify.com/v1/icon/?type=awesome&shadowColor=%23fafafa&color=%2336d867&scaleFactor=2&apiKey=${myAPIKey}` /* get an API Key on https://myprojects.geoapify.com */,
    iconSize: [31, 46],
    iconAnchor: [15.5, 42],
    popupAnchor: [0, -45]
});

// Add Geoapify Address Search control
// Get your own API Key on https://myprojects.geoapify.com
const addressSearchControl = L.control.addressSearch(myAPIKey, {
    position: 'topleft',
    mapViewBias: true,
    className: 'custom-address-field',
    resultCallback: (address) => {
        if (marker) {
            marker.remove();
        }

        if (!address) {
            return;
        }

        marker = L.marker([address.lat, address.lon]).addTo(map);
        if (address.bbox && address.bbox.lat1 !== address.bbox.lat2 && address.bbox.lon1 !== address.bbox.lon2) {
            map.fitBounds([[address.bbox.lat1, address.bbox.lon1], [address.bbox.lat2, address.bbox.lon2]], { padding: [100, 100] })
        } else {
            map.setView([address.lat, address.lon], 15);
        }
    },
    suggestionsCallback: (suggestions) => {
        console.log(suggestions);
    }
});
map.addControl(addressSearchControl);
map.addControl(control);

L.control.zoom({ position: 'bottomright' }).addTo(map);
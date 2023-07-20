
/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              variable initialisation                                               */
/* ------------------------------------------------------------------------------------------------------------------ */

var map = L.map('map', { zoomControl: false }).setView([48.1500327, 11.5753989], 6);

var myAPIKey = "3e6cf917f419488cbeec8ac503210f17";

var marker = null;

var radius = 1000;

var longitude = null;

var latitude = null;

var step = 1;

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                      build map                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */

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

L.control.zoom({ position: 'bottomright' }).addTo(map);

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                 get user location                                                  */
/* ------------------------------------------------------------------------------------------------------------------ */

// Get a user location roughly
fetch(`https://api.geoapify.com/v1/ipinfo?apiKey=${myAPIKey}`).then(result => result.json()).then(result => {
    map.setView([result.location.latitude, result.location.longitude], 8);
});

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                    range field                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */
// Range slider
const slider = L.control.range({
    position: 'topright',
    min: 1,
    max: 100,
    value: 1,
    step: step,
    orient: 'horizontal',
});


slider.on('input change', function(e) {
    if (e.value <= 10000) {
        step = 1;
        slider.options.step = step;
    } else if (e.value <= 50000) {
        step = 2;
        slider.options.step = step;
    } else {
        step = 5;
        slider.options.step = step;
    }

    document.getElementById("range_text").innerHTML = e.value / 1000 * 2 + " Km Diameter";

    if(map.hasLayer(circle)) {
        map.removeLayer(circle);
        radius = e.value;
        circle = L.circle({lat: latitude, lng: longitude}, {
            color: 'steelblue',
            radius: radius,
            fillColor: 'steelblue',
            opacity: 0.5
        }).addTo(map)
    } else {
        radius = e.value;
    }
    map.fitBounds(circle.getBounds());

    // ajax request
    var message = '{"list": ' + list + ', "radius":' + radius + "}";
    var xhttp;

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("item_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "../php/controller/item_controller.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("range_update=" + encodeURIComponent(message));});

map.addControl(slider);

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                    input field                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */

var circle = null;

// Geoapify Address Search control
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

        longitude = address.lon;
        latitude = address.lat;

        marker = L.marker([latitude, longitude]).addTo(map);


        if (circle != undefined) {
            map.removeLayer(circle);
        };

        circle = L.circle({lat: latitude, lng: longitude}, {
            color: 'steelblue',
            radius: radius,
            fillColor: 'steelblue',
            opacity: 0.5
        }).addTo(this.map)

        if (address.bbox && address.bbox.lat1 !== address.bbox.lat2 && address.bbox.lon1 !== address.bbox.lon2) {
            map.fitBounds(circle.getBounds())
        } else {
            map.setView([address.lat, address.lon], 15);
        }

        // ajax request
        var message = '{"list": ' + JSON.stringify(list) + ', "lat":' + latitude + ', "lon":' + longitude + ', "radius":' + radius + "}";
        var xhttp;

        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("item_list").innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "../php/controller/item_controller.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("new_marker=" + encodeURIComponent(message));
        },
    suggestionsCallback: (suggestions) => {
        console.log(suggestions);
    }
});
map.addControl(addressSearchControl);





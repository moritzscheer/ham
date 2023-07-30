
/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              variable initialisation                                               */
/* ------------------------------------------------------------------------------------------------------------------ */

var map = L.map('map', { zoomControl: false }).setView([48.1500327, 11.5753989], 6);

var myAPIKey = "3e6cf917f419488cbeec8ac503210f17";

var circle = null;

var step = 1;

var markers = [];

var userLocation = [];

var eventLocations = [];

var closeToMe = [];

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

initMap();

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                 get user location                                                  */
/* ------------------------------------------------------------------------------------------------------------------ */

async function initMap() {
    userLocation = await getUserCoordinates();

    await createNewCircle();

    getEventCoordinates();
}

/**
 * gets the coordination from the logged-in-user
 */
async function getUserCoordinates() {
    var location = null;

    if (userAddress === undefined) {
        // source: https://stackdiary.com/tutorials/how-to-get-a-clients-ip-address-using-javascript/
        await fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {

                // Get a user location roughly
                fetch('https://api.geoapify.com/v1/ipinfo?ip=' + data.ip + '&apiKey=' + myAPIKey)
                    .then(result => result.json())
                    .then(async result => {
                        location = [result.location.latitude, result.location.longitude];
                    });
            });
    } else {
        await fetch('https://api.geoapify.com/v1/geocode/search?'+
            'street='+encodeURI(userAddress.street_name)+
            '&housenumber='+encodeURI(userAddress.house_number)+
            '&postcode='+encodeURI(userAddress.postal_code)+
            '&city='+encodeURI(userAddress.city)+
            '&format=json&apiKey=3e6cf917f419488cbeec8ac503210f17')
            .then(response => response.json())
            .then(data => {
                location = [data.results[0].lat, data.results[0].lon];
            });
    }
    return location;
}

/**
 * gets the coordinates of the events
 * @returns {Promise<void>}
 */
async function getEventCoordinates() {
    if (events != undefined) {
        for (let i = 0; i < events.length; i++) {
            await fetch('https://api.geoapify.com/v1/geocode/search?'+
                'street='+encodeURI(events[i].street_name)+
                '&housenumber='+encodeURI(events[i].house_number)+
                '&postcode='+encodeURI(events[i].postal_code)+
                '&city='+encodeURI(events[i].city)+
                '&format=json&apiKey=3e6cf917f419488cbeec8ac503210f17')
                .then(response => response.json())
                .then(data => {
                    latitude = data.results[0].lat;
                    longitude = data.results[0].lon;

                    eventLocations.push([latitude, longitude]);

                    // calculate distance to user
                    distance = calcDistance(userLocation[0], userLocation[1], latitude, longitude, "K");

                    // set the distance
                    events[i].distance = distance;

                    marker = new L.Marker([latitude, longitude]);
                    markers[i] = marker;

                    if (distance < radius / 1000) {
                        // sets a marker if it is in radius
                        marker.addTo(map);

                        closeToMe.push(events[i])
                    }
                });
        }
        sendAjaxRequestToUpdateList();
    }
}

/**
 * https://stackoverflow.com/questions/18883601/function-to-calculate-distance-between-two-coordinates
 * @param lat1
 * @param lon1
 * @param lat2
 * @param lon2
 * @param unit
 * @returns {number}
 */
function calcDistance(lat1, lon1, lat2, lon2, unit) {
    if ((lat1 == lat2) && (lon1 == lon2)) {
        return 0;
    }
    else {
        var radlat1 = Math.PI * lat1/180;
        var radlat2 = Math.PI * lat2/180;
        var theta = lon1-lon2;
        var radtheta = Math.PI * theta/180;
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        if (dist > 1) {
            dist = 1;
        }
        dist = Math.acos(dist);
        dist = dist * 180/Math.PI;
        dist = dist * 60 * 1.1515;
        if (unit=="K") { dist = dist * 1.609344 }
        if (unit=="N") { dist = dist * 0.8684 }
        return dist;
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                    range field                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */

// Range slider
const slider = L.control.range({
    position: 'topright',
    min: 1,
    max: 50,
    value: radius,
    step: step,
    orient: 'horizontal',
});

slider.on('input change', function(e) {
    if (radius <= 5) {
        step = 1;
    } else if (radius <= 10) {
        step = 3;
    } else {
        step = 5;
    }

    // updates ui text
    document.getElementById("range_text").innerHTML = e.value / 1000 + " Km Radius";

    // updates radius
    radius = e.value;

    createNewCircle();

    // resets marker and closeToMe array
    closeToMe = [];

    // if there are any events
    if (events != undefined) {
        for (let i = 0; i < events.length; i++) {
            marker = markers[i];
            map.removeLayer(marker);
            if (events[i].distance < radius / 1000) {
                marker.addTo(map);

                closeToMe.push(events[i])
            }
        }
        sendAjaxRequestToUpdateList();
    }
});

map.addControl(slider);



/**
 * creates a new circle and deletes old ones
 */
function createNewCircle() {
    if (circle != undefined) {
        map.removeLayer(circle);
    }

    // creates circle around user location
    circle = L.circle({lat: userLocation[0], lng: userLocation[1]}, {
        color: 'steelblue',
        radius: radius,
        fillColor: 'steelblue',
        opacity: 0.5
    }).addTo(this.map)

    // sets view to circle size
    map.fitBounds(circle.getBounds());
}

/**
 * sends an ajax request to the client to update the event list
 */
function sendAjaxRequestToUpdateList() {
    // ajax request
    var message = '{"list": ' + JSON.stringify(closeToMe) + ', "radius":' + radius + '}';
    var xhttp;

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("item_list").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "../php/controller/item_controller.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("range_update=" + encodeURIComponent(message));
}


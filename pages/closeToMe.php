<?php
    global $error_message;
    include_once "../php/includes/head/head.php"
?>
<head>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>
</head>
<body>
<?php include_once "../php/includes/navigation/header/header.php" ?>

<h1> Close to Me </h1>

<?php

$range = (isset($_POST["range"]) &&
    is_string($_POST["range"])) ? $_POST["range"] : "";
$range = htmlspecialchars($range);
echo $range;
?>

<div class="closeToMe-Grid" onclick="resolveEventGeoPositions()">
    <form method="post" class="closeToMe-Filter">
        <input type="text" name="search" placeholder="search" class="closeToMe-Search">
        <label class="closeToMe-Radius-Box">Radius
            <input type="range" min="10" max="200" id="range-radius" name="range" step="1" value="0"
                   class="closeToMe-Radius">
        </label>
    </form>

    <!-- Map -->
    <div id="map"</div>
    <!-- List of Items (Bands or Events) -->
    <p id="error-message"><?php echo $error_message ?></p>
    <?php echo $_SESSION["itemDetail"] ?>
    <section id="item_list">
        <?php echo $_SESSION["itemList"] ?>
    </section>

</div>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>

</body>
</html>
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script>
        var mapConfig = {
            url: 'https://{s}.tile.osm.org/{z}/{x}/{y}.png',
            bounds: [],
            markerObjects: [],
            zoom: 10,
        };
        var initialCoords = {lat: 51.1638175, lng: 10.4478313};

        var mapMarker = [];

        // Creating a map object
        var map = L.map('map').setView(initialCoords, mapConfig.zoom);

        // Creating a Layer object
        L.tileLayer(mapConfig.url, {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);
        var marker = L.marker(initialCoords);
        mapMarker.push(marker);
        marker.addTo(map)

        console.log(map)


        function sendRequest(search) {
            var xmlhttp = new XMLHttpRequest();
            search = search.value;

            xmlhttp.open("GET", "../php/itemList.php?submitSearchJavaScript="+search, true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-formurlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("item_list").innerHTML = this.responseText;
                    console.log(this);
                }
            }
            xmlhttp.send();
        }

        async function resolveEventGeoPositions() {
            var address = {
                street: 'hallo 12',
                postalcode: 24421,
                city: 'stadt'

            }
            var request = new XMLHttpRequest();
            request.open('GET', 'https://nominatim.openstreetmap.org/search.php?format=jsonv2&street=Am hooge Weg');
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    var mapCoords = {lat: response[0].lat, lng: response[0].lon};
                    var marker = L.marker(mapCoords);
                    marker.addTo(map)
                }
            }
            request.send();
        }

</script>


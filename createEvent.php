<?php include_once "php/head.php" ?>

<body>

<?php include_once "php/header.php" ?>

<div>
    <h1> Veranstaltung erstellen </h1>
    <div>
        <label id="name">Bild</label> <br>
        <input type="File" id="image" accept=".jpg,.png,.pdf"><br>
        <img src="images/event.jpg" alt="eventImage" height="200" width="200">
        <br>
        <form method="createEvent" action="event.php">
            <label id="name">Name:</label>
            <input type="text" name="name" value="Neueröffnung Hornbach Bau- und Gartenmarkt Leipzig"><br>

            <h3>Adresse</h3>

            <label id="street">Straße:</label>
            <input type="text" name="street" value="Steinweg"><br>

            <label id="houseNr">Hausnummer:</label>
            <input type="text" name="houseNr" value="2"><br>

            <label id="postalCode">PLZ:</label>
            <input type="number" maxlength="5" minlength="5" name="postalCode" value="42275"><br>

            <label id="city">Ort:</label>
            <input type="text" name="city" value="Wuppertal"><br> <br>

            <label id="date">Datum:</label>
            <input type="date" name="date" value="2023-04-12"><br>

            <label id="startTime">Startzeit:</label>
            <input type="time" name="startTime" value="14:00"><br>

            <label id="endTime">Endzeit:</label>
            <input type="time" name="endTime" value="17:00"><br>

            <label id="description">Beschreibung:</label> <br>
            <textarea name="description" rows="5" >Hornbach Bau- und Gartenmarkt eröffnet voraussichtlich im Frühjahr 2023 einen weiteren Markt in Leipzig auf rund 10.000 Quadratmetern und einem Gartenmarkt mit rund 3.000 Quadratmetern.
            </textarea> <br>

            <label id="requirements">Anforderungen:</label> <br>
            <textarea name="requirements" rows="5" >Jazzband mit Repertoir für einen Nachmittag (3std)
Kostenlose Verpflegung
Bis 2000€
            </textarea> <br>
            <a href="events.php">
                <input type="button" name="submit" value="Veranstaltung erstellen">
            </a>
        </form>
    </div>
</div>

<?php include_once "php/footer.php" ?>

</body>

</html>
<?php include_once "php/head.php" ?>

<body>

<?php include_once "php/header.php" ?>

<div>
    <h1> Veranstaltung erstellen </h1>
    <div id="create-event">
        <section class="left-column">
            <label id="bild" class="big-text">Bild</label>
            <input type="File" id="image" accept=".jpg,.png,.pdf">
            <img src="images/event.jpg" alt="eventImage" height="200" width="200">
            <label id="description" class="big-text">Beschreibung:</label>
            <textarea name="description" rows="5">Hornbach Bau- und Gartenmarkt eröffnet voraussichtlich im Frühjahr 2023 einen weiteren Markt in Leipzig auf rund 10.000 Quadratmetern und einem Gartenmarkt mit rund 3.000 Quadratmetern.
            </textarea>
        </section>
        <form method="get" action="event.php" class="right-column">
            <section>
                <label id="name" class="big-text">Name:</label> <br>
                <input class="name-input" type="text" name="name"
                       value="Neueröffnung Hornbach Bau- und Gartenmarkt Leipzig" required><br>
            </section>

            <section>
                <div>
                    <h3>Adresse</h3>
                </div>
                <div class="address-inputs">
                    <div class="street">
                        <label id="street">Straße:</label> <br>
                        <input type="text" name="street" value="Steinweg" required>
                    </div>
                   <div class="houseNr">
                       <label id="houseNr">Hausnummer:</label><br>
                       <input type="text" name="houseNr" value="2" required>
                   </div>
                    <div class="postalCode">
                        <label id="postalCode">PLZ:</label><br>
                        <input type="text" maxlength="5" minlength="0" name="postalCode" value="42275" pattern="[0-9]*"
                               required>
                    </div>
                   <div class="city">
                       <label id="city">Ort:</label><br>
                       <input type="text" name="city" value="Wuppertal" required>
                   </div>
                </div>
            </section>
            <section>
                <h3>Zeit</h3>

                <div class="time-inputs">
                    <div>
                        <label id="date">Datum:</label> <br>
                        <input type="date" name="date" value="2023-04-12" required>
                    </div>
                    <div class="times">
                        <div>
                            <label id="startTime">Startzeit:</label><br>
                            <input type="time" name="startTime" value="14:00" required>
                        </div>
                        <div>
                            <label id="endTime">Endzeit:</label><br>
                            <input type="time" name="endTime" value="17:00" required>
                        </div>
                    </div>
                </div>
            </section>

            <section class="requirements">
                <label id="requirements">Anforderungen:</label> <br>
                <textarea name="requirements" rows="5">Jazzband mit Repertoir für einen Nachmittag (3std)
Kostenlose Verpflegung
Bis 2000€
            </textarea>
            </section>

            <a href="events.php" class="submit">
                <input type="submit" name="submit" value="Veranstaltung erstellen">
            </a>
        </form>
    </div>
</div>

<?php include_once "php/footer.php" ?>

</body>
</html>
<style lang="css" itemscope>
    input {
        border: 2px solid lightblue;
        border-radius: 20px;
        padding: 0 20px;
        margin-top: 10px;
        height: 30px;
        width: -webkit-fill-available;
    }
    textarea {
        border: 2px solid lightblue;
        border-radius: 20px;
        padding: 10px 20px;
        margin-top: 10px;
    }

    .left-column {
        display: grid;
        padding-right: 10%;
    }

    .right-column {
        display: grid;
        width: 70%;
    }

    .name-input {
        margin-top: 10px;
        height: 30px;
    }
    .address-inputs {
        display: grid;
        grid-template-columns: 25% 25% 25%;
        row-gap: 10px;
        column-gap: 20px;
        grid-template-rows: 50% 50%;
        grid-template-areas:
                "street street houseNr"
                "postalCode city city";
    }
    .time-inputs {
        width: 50%;
    }
    .times {
        display: grid;
        grid-template-columns: 50% 50%;
        gap: 10px;
        width: 100%;
    }
    .requirements {
        display: grid;
        width: 50%;
        margin-top: 20px;
    }
    .submit {
        width: 50%;
    }
    .street {
        grid-area: street;
    }
    .houseNr {
        grid-area: houseNr;
    }
    .postalCode {
        grid-area: postalCode;
    }
    .city {
        grid-area: city;
    }

</style>
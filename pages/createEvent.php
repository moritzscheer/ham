<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>
<div>
    <h1> Create Event </h1>
    <div id="create-event">
        <section class="left-column">
            <label id="bild" class="big-text">Bild:
                <input type="File" id="image" accept=".jpg,.png,.pdf">
            </label>
            <img class="full-width" src="../resources/images/events/event.jpg" alt="eventImage">
            <label id="description" class="big-text">Description: <br/>
                <textarea class="full-width" name="description" rows="5">Hornbach Bau- und Gartenmarkt eröffnet voraussichtlich im Frühjahr 2023 einen weiteren Markt in Leipzig auf rund 10.000 Quadratmetern und einem Gartenmarkt mit rund 3.000 Quadratmetern.
                </textarea>
            </label>
        </section>
        <form method="get" action="event.php" class="right-column">
            <section>
                <label id="name" class="big-text">Name:
                    <input class="name-input" type="text" name="eventName"
                           value="Hornbach Bau- und Gartenmarkt" required>
                </label>
            </section>

            <section>
                <div>
                    <h3>Address</h3>
                </div>
                <div class="address-inputs">
                    <div class="street">
                        <label id="street">Street:
                            <input type="text" name="street" value="Steinweg" required>
                        </label>
                    </div>
                    <div class="houseNr">
                        <label id="houseNr">House Number:
                            <input type="text" name="houseNr" value="2" required>
                        </label>
                    </div>
                    <div class="postalCode">
                        <label id="postalCode">Postal Code:
                            <input type="text" maxlength="5" minlength="0" name="postalCode" value="42275"
                                   pattern="[0-9]*"
                                   required>
                        </label>
                    </div>
                    <div class="city">
                        <label id="city">City:
                            <input type="text" name="city" value="Wuppertal" required>
                        </label>
                    </div>
                </div>
            </section>
            <section>
                <h3>Time</h3>

                <div class="time-inputs">
                    <div>
                        <label id="date">Date:
                            <input type="date" name="date" value="2023-04-12" required>
                        </label>
                    </div>
                    <div class="times">
                        <div>
                            <label id="startTime">Starting Time:
                                <input type="time" name="startTime" value="14:00" required>
                            </label>
                        </div>
                        <div>
                            <label id="endTime">Ending Time:
                                <input type="time" name="endTime" value="17:00" required>
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <section class="requirements">
                <label id="requirement">Requirements: <br/>
                    <textarea class="full-width" name="requirements" rows="5">Jazzband mit Repertoir für einen Nachmittag (3std)
    Kostenlose Verpflegung
    Bis 2000€
                </textarea>
                </label>
            </section>

            <input type="submit" name="submit" value="Create Event">
        </form>
    </div>
</div>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php";
include_once "../php/events.php";
global $newEvent;
?>

<div>
    <h1> Create Event </h1>
    <form method="post" action="events.php">
        <div id="create-event">

            <section class="left-column">
                <label id="bild" class="big-text">Bild:
                    <input type="File" id="image" accept=".jpg,.png,.pdf" value="<?php echo $newEvent["image"] ?>">
                </label>
                <img class="full-width" src="../resources/images/events/event.jpg" alt="eventImage">
                <label id="description" class="big-text">Description: <br/>
                    <textarea class="full-width" name="description"
                              rows="5"><?php echo $newEvent["description"] ?></textarea>
                </label>
            </section>
            <div class="right-column">
                <section>
                    <label id="name" class="big-text">Name:
                        <input class="name-input" type="text" name="eventName"
                               value="<?php echo $newEvent["name"] ?>" required>
                    </label>
                </section>

                <section>
                    <div>
                        <h3>Address</h3>
                    </div>
                    <div class="address-inputs">
                        <div class="street">
                            <label id="street">Street:
                                <input type="text" name="street" value="<?php echo $newEvent["street"] ?>"
                                       required>
                            </label>
                        </div>
                        <div class="houseNr">
                            <label id="houseNr">House Number:
                                <input type="text" name="houseNr" value="<?php echo $newEvent["houseNr"] ?>"
                                       required>
                            </label>
                        </div>
                        <div class="postalCode">
                            <label id="postalCode">Postal Code:
                                <input type="text" maxlength="5" minlength="0"
                                       name="<?php echo $newEvent["postalCode"] ?>" value="42275"
                                       pattern="[0-9]*"
                                       required>
                            </label>
                        </div>
                        <div class="city">
                            <label id="city">City:
                                <input type="text" name="city" value="<?php echo $newEvent["city"] ?>" required>
                            </label>
                        </div>
                    </div>
                </section>
                <section>
                    <h3>Time</h3>

                    <div class="time-inputs">
                        <div>
                            <label id="date">Date:
                                <input type="date" name="date" value="<?php echo $newEvent["date"] ?>" required>
                            </label>
                        </div>
                        <div class="times">
                            <div>
                                <label id="startTime">Starting Time:
                                    <input type="time" name="startTime"
                                           value="<?php echo $newEvent["startTime"] ?>" required>
                                </label>
                            </div>
                            <div>
                                <label id="endTime">Ending Time:
                                    <input type="time" name="endTime" value="<?php echo $newEvent["endTime"] ?>"
                                           required>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="requirements">
                    <label id="requirement">Requirements: <br/>
                        <textarea class="full-width" name="requirements"
                                  rows="5"><?php echo $newEvent["requirements"] ?></textarea>
                    </label>
                </section>
                <input type="submit" name="submit" value="Create Event">
            </div>
        </div>
    </form>

</div>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

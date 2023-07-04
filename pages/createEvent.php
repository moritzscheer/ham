<?php use Item\Event;

include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/includes/navigation/header/header.php";
global $newEvent;
if(!isset($_GET["status"]) || $_GET["status"] !== 'Edit') {
    $_SESSION['event'] = new Event();
}
?>

    <?php include_once "../php/includes/elements/flickr.php"?>

    <div>
        <h1> <?php echo $_SESSION["status"] ?> Event </h1>
        <form method="post" class="create-event" enctype="multipart/form-data">
            <div id="create-event-inputs">
                <section class="left-column">
                    <label id="image" class="big-text">Select Image
                        <input type="submit" id="imageLoader" value="event" name="onEditImage">
                    </label>
                    <img id="preview" class="full-width" src="<?php echo $_SESSION["event"]->getImageSource() ?>" alt="preview">
                    <label id="description" class="big-text">Description: <br/>
                        <textarea class="full-width" name="description"
                                  rows="5"><?php echo $_SESSION["event"]->getDescription() ?></textarea>
                    </label>
                </section>
                <div class="right-column">
                    <section>
                        <label id="name" class="big-text">Name:
                            <input class="name-input" type="text" name="event_name"
                                   value="<?php echo $_SESSION["event"]->getName() ?>" required>
                        </label>
                    </section>

                    <section>
                        <div>
                            <h3>Address</h3>
                        </div>
                        <div class="address-inputs">
                            <div class="street">
                                <label id="street">Street:
                                    <input type="text" name="event_street_name" value="<?php echo $_SESSION["event"]->getStreetName() ?>"
                                           required>
                                </label>
                            </div>
                            <div class="houseNr">
                                <label id="houseNr">House Number:
                                    <input type="text" name="event_house_number" value="<?php echo $_SESSION["event"]->getHouseNumber() ?>"
                                           required>
                                </label>
                            </div>
                            <div class="postalCode">
                                <label id="postalCode">Postal Code:
                                    <input type="text" maxlength="5" minlength="0"
                                           name="event_postal_code" value="<?php echo $_SESSION["event"]->getPostalCode() ?>"
                                           pattern="[0-9]*"
                                           required>
                                </label>
                            </div>
                            <div class="city">
                                <label id="city">City:
                                    <input type="text" name="event_city" value="<?php echo $_SESSION["event"]->getCity() ?>" required>
                                </label>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h3>Time</h3>

                        <div class="time-inputs">
                            <div>
                                <label id="date">Date:
                                    <input type="date" name="date" value="<?php echo $_SESSION["event"]->getDate() ?>" required>
                                </label>
                            </div>
                            <div class="times">
                                <div>
                                    <label id="startTime">Starting Time:
                                        <input type="time" name="startTime"
                                               value="<?php echo $_SESSION["event"]->getStartTime() ?>" required>
                                    </label>
                                </div>
                                <div>
                                    <label id="endTime">Ending Time:
                                        <input type="time" name="endTime" value="<?php echo $_SESSION["event"]->getEndTime() ?>"
                                               required>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="requirements">
                        <label id="requirement">Requirements: <br/>
                            <textarea class="full-width" name="requirements"
                                      rows="5"><?php echo $_SESSION["event"]->getRequirements() ?></textarea>
                        </label>
                    </section>
                </div>
            </div>
            <div class="create-event-submit">
                <label id="createEventSubmit"><?php echo $_SESSION["status"] ?> Event
                    <input type="submit" name="submit">
                </label>
            </div>
        </form>
    </div>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>
<script>
    function onImageAdd(image) {
        var preview = window.document.getElementById('preview');
        preview.src = URL.createObjectURL(image.target.files[0]);
        preview.onload = function (){
            URL.revokeObjectURL(preview.src);
        }
    }
</script>

<?php global $error_message;
include_once "../php/head/head.php" ?>
<body>

    <?php include_once "../php/includes/elements/hints.php" ?>

    <?php include_once "../php/includes/navigation/header/header.php" ?>

    <?php include_once "../php/includes/elements/flickr.php"?>

    <form method="post" class="profile-Picture-Large-Box" enctype="multipart/form-data">
        <?php echo $_SESSION["profile_large"] ?>
        <div id="image-Select">
            <label>Edit Image
                <input id="addBackgroundImage" type="submit" value="profile_large" name="onEditImage">
            </label>
        </div>
    </form>

    <div class="profile-Navigation">
        <div>
            <form method="post" class="profile-Picture-Box" id="edit" enctype="multipart/form-data">
                <div id="profile_picture_small" class="edit">
                    <?php echo $_SESSION["profile_small"] ?>
                </div>
                <div id="profile-Picture-Link">
                    <label>Edit Image
                        <input id="addProfileImage" type="submit" value="profile_small" name="onEditImage"
                           class="profile-Picture-Submit">
                    </label>
                </div>
            </form>
            <?php include_once $_SESSION["navigation"] ?>
        </div>
    </div>

    <section class="profile-Grid">
        <form method="post" class="profile-Content">
            <div id="contact-Information">
                <h2>Contact Information</h2>

                <label id="input-entry" class="entry">Phone Number:
                    <input type="tel" name="phone_number" value="<?php echo $_SESSION["user"]->getPhoneNumber() ?>">
                </label>
            </div>

            <div id="about-me">
                <h2>About Me</h2>

                <div id="split" class="entry">
                    <label id="input-entry" class="entry">Name:
                        <input type="text" name="name" value="<?php echo $_SESSION["user"]->getName() ?>" required>
                    </label>
                    <label id="input-entry" class="entry">Surname:
                        <input type="text" name="surname" value="<?php echo $_SESSION["user"]->getSurname() ?>" required>
                    </label>
                </div>

                <div id="split">
                    <label id="input-entry" class="entry">Street:
                        <input type="text" name="user_street_name" value="<?php echo $_SESSION["user"]->getStreetName() ?>">
                    </label>
                    <label id="input-entry" class="entry">House Number:
                        <input type="text" name="user_house_number"
                               value="<?php echo $_SESSION["user"]->getHouseNumber() ?>">
                    </label>
                </div>

                <div id="split">
                    <label id="input-entry" class="entry">City:
                        <input type="text" name="user_city" value="<?php echo $_SESSION["user"]->getCity() ?>">
                    </label>
                    <label id="input-entry" class="entry">Postal Code:
                        <input type="text" name="user_postal_code" value="<?php echo $_SESSION["user"]->getPostalCode() ?>">
                    </label>
                </div>

                <label id="type-entry" class="entry">Type:
                    <div>
                        <label>Musician
                            <input type="radio" name="type" value="Musician" <?php echo $_SESSION["Musician"] ?> required>
                        </label>
                        <label>Host
                            <input type="radio" name="type" value="Host" <?php echo $_SESSION["Host"] ?> required>
                        </label>
                    </div>
                </label>

                <label id="input-entry" class="entry">Genre:
                    <input type="text" name="genre" value="<?php echo $_SESSION["user"]->getGenre() ?>">
                </label>

                <label id="input-entry" class="entry">Members:
                    <input type="text" name="members" value="<?php echo $_SESSION["user"]->getMembers() ?>">
                </label>

                <label id="input-entry" class="entry">Other Remarks:
                    <textarea name="other_remarks" rows="5"><?php echo $_SESSION["user"]->getOtherRemarks() ?></textarea>
                </label>
            </div>

            <div id="profile-Submit">
                <label>Cancel
                    <input type="submit" name="viewProfile" value="<?php echo $_SESSION["user_ID"] ?>">
                </label>
                <label>Save Change
                    <input type="submit" name="update_profile">
                </label>
            </div>
        </form>

        <form method="post" enctype="multipart/form-data" id="uploaded-Images">
            <?php echo $_SESSION["profile_gallery"] ?>
            <?php echo $error_message ?>
            <div class="newImage-Link">
                <label>Add Image
                    <input type="submit" value="profile_gallery" name="onEditImage">
                </label>
            </div>
        </form>
    </section>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>

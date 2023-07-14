<?php
    global $error_message;
    include_once "../php/includes/head/head.php"
?>
<body>

    <section id="popup_elements">
        <?php include_once "../php/includes/elements/flickr.php"?>
        <?php include_once "../php/includes/elements/delete.php" ?>
        <?php include_once "../php/includes/elements/hints.php" ?>
    </section>

    <?php include_once "../php/includes/navigation/header/header.php" ?>

    <section id="page_content">
        <form id="edit" class="pictureLarge_container" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
            <div id="pictureLarge_image">
                <?php echo $_SESSION["profile_large"] ?>
            </div>
            <label id="pictureLarge_edit">Edit Image
                <input type="submit" value="profile_large" name="onEditImage">
            </label>
        </form>

        <div id="navigation_container">
            <form id="edit" class="pictureSmall_container" method="post" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
                <div id="pictureSmall_image">
                    <?php echo $_SESSION["profile_small"] ?>
                </div>
                <label id="pictureSmall_edit">Edit Image
                    <input id="addProfileImage" class="profile-Picture-Submit" type="submit" value="profile_small"
                           name="onEditImage">
                </label>
            </form>
            <?php include_once $_SESSION["navigation"] ?>
        </div>

        <div id="content_container">
            <form class="information_container" method="post">
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
                <div id="contact_information">
                    <h2>Contact Information</h2>

                    <label id="input-entry" class="entry">Phone Number:
                        <input type="tel" name="phone_number" value="<?php echo $_SESSION["user"]->getPhoneNumber() ?>">
                    </label>
                </div>

                <div id="about_me">
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

                    <fieldset>
                        <legend>Type:</legend>
                        <div id="type-entry" class="entry">
                            <label>Musician
                                <input type="radio" name="type" value="Musician" <?php echo $_SESSION["Musician"] ?> required>
                            </label>
                            <label>Host
                                <input type="radio" name="type" value="Host" <?php echo $_SESSION["Host"] ?> required>
                            </label>
                        </div>
                    </fieldset>

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

                <div id="legal_disclosure">
                    <h2>Legal Disclosure</h2>

                    <label class="entry">
                        <input type="checkbox" id="agreementCheck" name="dsr" value="y" <?php echo $_SESSION["loggedIn"]["user"]->getDsrCheckBox() ?> onclick="document.getElementById('update_profile').click()">
                        <div id="agreementText"> I agree with the <a id="agreementLinks" href="impressum.php">Legal Disclosure</a>, <a id="agreementLinks" href="nutzungsbedingungen.php">Terms
                                of Use</a> and the <a id="agreementLinks" href="datenschutz.php">Privacy Policy</a></div>
                    </label>
                    <p>Note that if you uncheck this mark you can no longer see content from third party companies including Google Maps and Flickr.</p>
                </div>

                <div id="profile_submit">
                    <label>Cancel
                        <input type="submit" name="viewProfile" value="<?php echo $_SESSION["loggedIn"]["user_ID"] ?>">
                    </label>
                    <label>Save Change
                        <input type="submit" id="update_profile" name="update_profile">
                    </label>
                </div>
            </form>

            <form id="gallery_container" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
                <?php echo $_SESSION["profile_gallery"] ?>
                <?php echo $error_message ?>
                <div class="gallery_edit">
                    <label>Add Image
                        <input type="submit" value="profile_gallery" name="onEditImage">
                    </label>
                </div>
            </form>
        </div>
    </section>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>

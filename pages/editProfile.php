<?php global $error_message;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

<form method="post" class="profile-Picture-Large-Box" enctype="multipart/form-data">
    <img src="<?php echo $_SESSION["profile_picture_large"] ?>" alt="could not load image"
         class="profile-Picture-Large">
    <div id="image-Select">
        <label>Select Image
            <input oninput="window.document.getElementById('addBackgroundImage').click()" type="file"
                   accept=".jpg, .png, .jpeg" name="profile_picture_large">
        </label>
        <input id="addBackgroundImage" type="submit" value="Add" name="profile_picture_large">
    </div>
</form>

<div class="profile-Navigation">
    <div>
        <form method="post" class="profile-Picture-Box" id="edit" enctype="multipart/form-data">
            <img onclick="window.document.getElementById('profileInput').click()"
                 ondrop="window.document.getElementById('profileInput').click()"
                 src="<?php echo $_SESSION["profile_picture_small"] ?>" alt="profilePicture" class="profile-Picture">
            <div id="profile-Picture-Link">
                <label>Select Image
                    <input oninput="window.document.getElementById('addProfileImage').click()" type="file"
                           id="profileInput"
                           name="profile_picture_small" accept=".jpg, .png, .jpeg">
                </label>
                <input id="addProfileImage" type="submit" value="Add" name="profile_picture_small"
                       class="profile-Picture-Submit">
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
        <?php echo $_SESSION["image_gallery"] ?>
        <?php echo $error_message ?>
        <div class="newImage-Link">
            <label>Select Image
                <input type="file" accept=".jpg, .png, .jpeg" name="newImage">
            </label>
            <input type="submit" value="Add" name="newImage">
        </div>
    </form>
</section>
<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

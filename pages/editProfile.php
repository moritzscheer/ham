<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <form method="post" class="profile-Picture-Large-Box" enctype="multipart/form-data">
        <img src="<?php echo $_SESSION["profile-Picture-Large"]; ?>" alt="could not load image" class="profile-Picture-Large">
        <div id="image-Select">
            <label>Select Image
                <input type="file" accept=".jpg, .png, .jpeg" name="profile-Picture-Large">
            </label>
            <input type="submit" value="Add" name="profile-Picture-Large">
        </div>
    </form>

    <div class="profile-Navigation">
        <form method="post" class="profile-Picture-Box" enctype="multipart/form-data">
            <img src="<?php echo $_SESSION["profile-Picture-Small"]; ?>" alt="Profile could not load" height="120" width="120" class="profile-Picture" id="editProfilePicture">
            <div id="profile-Picture-Link">
                <label >Select Image
                    <input type="file" name="profile-Picture-Small" accept=".jpg, .png, .jpeg">
                </label>
                <input type="submit" value="Add" name="profile-Picture-Small" class="profile-Picture-Submit">
            </div>
        </form>
        <?php include_once "../php/navigation/profile/profileNavigation.php" ?>
    </div>

    <section class="profile-Grid">
        <form method="post" class="profile-Content">
            <div id="contact-Information">
                <h2>Contact Information</h2>

                <label class="entry">E-Mail:
                    <label><?php echo $_SESSION["user"]->getEmail() ?></label>
                </label>

                <label class="entry">Phone Number:
                    <input type="tel" name="phoneNumber" value="<?php echo $_SESSION["user"]->getPhoneNumber() ?>">
                </label>
            </div>

            <div id="about-me">
                <h2>About Me</h2>

                <label class="entry">Name:
                    <input type="text" name="name" value="<?php echo $_SESSION["user"]->getName() ?>" required>
                </label>

                <label class="entry">Surname:
                    <input type="text" name="surname" value="<?php echo $_SESSION["user"]->getSurname() ?>" required>
                </label>

                <div id="address-box">
                    <label class="entry">Street:
                        <input type="text" name="street_name" value="<?php echo $_SESSION["address"]->getStreetName() ?>">
                    </label>

                    <label id="address-box-right" class="entry">House Number:
                        <input type="text" name="house_number" value="<?php echo $_SESSION["address"]->getHouseNumber() ?>">
                    </label>
                </div>
                <div id="address-box">
                    <label class="entry">City:
                        <input type="text" name="city" value="<?php echo $_SESSION["address"]->getCity() ?>">
                    </label>

                    <label id="address-box-right" class="entry">Postal Code:
                        <input type="text" name="postal_code" value="<?php echo $_SESSION["address"]->getPostalCode() ?>">
                    </label>
                </div>
                
                <label class="entry">Type:
                    <div id="type">
                        <label>Musician
                            <input type="radio" name="type" value="Musician" <?php echo $_SESSION["Musician"] ?> required>
                        </label>
                        <label>Host
                            <input type="radio" name="type" value="Host" <?php echo $_SESSION["Host"] ?> required>
                        </label>
                    </div>
                </label>

                <label class="entry">Genre:
                    <input type="text" name="genre" value="<?php echo $_SESSION["user"]->getGenre() ?>">
                </label>

                <label class="entry">Members:
                    <input type="text" name="members" value="<?php echo $_SESSION["user"]->getMembers() ?>">
                </label>

                <label class="entry">Other Remarks:
                    <textarea name="otherRemarks" rows="5"><?php echo $_SESSION["user"]->getOtherRemarks() ?></textarea>
                </label>
            </div>

            <div id="profile-Submit">
                <a href="profile.php">Cancel</a>
                <input type="submit" name="update_profile" value="Save Changes">
            </div>
        </form>

        <form method="post" enctype="multipart/form-data" id="uploaded-Images">
            <?php echo getImageItems(false) ?>
            <?php echo $_SESSION["error"] ?>
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

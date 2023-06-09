<?php global $error_message;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <section class="profile-Picture-Large-Box">
        <img src="<?php echo $_SESSION["profile-Picture-Large"]; ?>" alt="could not load image" class="profile-Picture-Large">
    </section>

    <div class="profile-Navigation">
        <div class="profile-Picture-Box">
            <img src="<?php echo $_SESSION["profile-Picture-Small"]; ?>" alt="profile picture" height="120" width="120" class="profile-Picture">
        </div>
        <?php include_once "../php/navigation/profile/profileNavigation.php" ?>
    </div>

    <section class="profile-Grid">
        <div class="profile-Content">
            <div id="contact-Information">
                <h2>Contact Information</h2>

                <label class="entry">E-Mail:
                    <label><?php echo $_SESSION["user"]->getEmail() ?></label>
                </label>

                <label class="entry">Phone Number:
                    <label><?php echo $_SESSION["user"]->getPhoneNumber() ?></label>
                </label>
            </div>

            <div id="about-me">
                <h2>About Me</h2>

                <label class="entry">Name:
                    <label><?php echo $_SESSION["user"]->getName() ?></label>
                </label>

                <label class="entry">Surname:
                    <label><?php echo $_SESSION["user"]->getSurname() ?></label>
                </label>

                <div id="address-box">
                    <label class="entry">Street:
                        <label><?php echo $_SESSION["address"]->getStreetName() ?></label>
                    </label>

                    <label id="address-box-right" class="entry">House Number:
                        <label><?php echo $_SESSION["address"]->getHouseNumber() ?></label>
                    </label>
                </div>
                <div id="address-box">
                    <label class="entry">City:
                        <label><?php echo $_SESSION["address"]->getCity() ?></label>
                    </label>

                    <label id="address-box-right" class="entry">Postal Code:
                        <label><?php echo $_SESSION["address"]->getPostalCode() ?></label>
                    </label>
                </div>


                <label class="entry">Type:
                    <label><?php echo $_SESSION["user"]->getType() ?></label>
                </label>

                <label class="entry">Genre:
                    <label><?php echo $_SESSION["user"]->getGenre(); ?></label>
                </label>

                <label class="entry">Members:
                    <label><?php echo $_SESSION["user"]->getMembers(); ?></label>
                </label>

                <label class="entry">Other Remarks:
                    <label><?php echo $_SESSION["user"]->getOtherRemarks(); ?></label><br>
                </label>
            </div>
        </div>
                                            
        <div id="uploaded-Images">
            <?php echo getImageItems(true) ?>
        </div>
    </section>
<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

<?php global $error_message;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <section class="profile-Picture-Large-Box">
        <?php getProfilePictureLarge() ?>
    </section>

    <div class="profile-Navigation">
        <div>
            <div class="profile-Picture-Box">
                <?php getProfilePictureSmall() ?>
            </div>
            <?php include_once "../php/navigation/profile/profileNavigation.php" ?>
        </div>
    </div>

    <section class="profile-Grid">
        <div class="profile-Content">
            <div id="contact-Information">
                <h2>Contact Information</h2>

                <div id="output-entry" class="entry">E-Mail:
                    <div><?php echo $_SESSION["user"]->getEmail() ?></div>
                </div>

                <div id="output-entry" class="entry">Phone Number:
                    <div><?php echo $_SESSION["user"]->getPhoneNumber() ?></div>
                </div>
            </div>

            <div id="about-me">
                <h2>About Me</h2>

                <div id="output-entry" class="entry">Name:
                    <div><?php echo $_SESSION["user"]->getName()." ".$_SESSION["user"]->getSurname() ?></div>
                </div>

                <div id="output-entry" class="entry">Address:
                    <div><?php echo $_SESSION["address"]->printAddress() ?></div>
                </div>

                <div id="output-entry" class="entry">Type:
                    <div><?php echo $_SESSION["user"]->getType() ?></div>
                </div>

                <div id="output-entry" class="entry">Genre:
                    <div><?php echo $_SESSION["user"]->getGenre(); ?></div>
                </div>

                <div id="output-entry" class="entry">Members:
                    <div><?php echo $_SESSION["user"]->getMembers(); ?></div>
                </div>

                <div id="output-entry" class="entry">Other Remarks:
                    <div><?php echo $_SESSION["user"]->getOtherRemarks(); ?></div><br>
                </div>
            </div>
        </div>
                                            
        <div id="uploaded-Images">
            <?php echo getImageGallery() ?>
        </div>
    </section>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

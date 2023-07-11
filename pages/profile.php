<?php
    global $error_message;
    include_once "../php/includes/head/head.php"
?>
<body>

    <section id="popup_elements">
        <?php include_once "../php/includes/elements/delete.php" ?>
    </section>

    <?php include_once "../php/includes/navigation/header/header.php" ?>

    <section id="page_content">
        <div class="pictureLarge_container">
            <?php echo $_SESSION["profile_large"] ?>
        </div>

        <div id="navigation_container">
            <div class="pictureSmall_container">
                <div id="pictureSmall_image">
                    <?php echo $_SESSION["profile_small"] ?>
                </div>
            </div>
            <?php include_once $_SESSION["navigation"] ?>
        </div>

        <div id="content_container">
            <div id="information_container">
                <div id="contact_information">
                    <h2>Contact Information</h2>

                    <div id="output-entry" class="entry">E-Mail:
                        <div><?php echo $_SESSION["user"]->getEmail() ?></div>
                    </div>

                    <div id="output-entry" class="entry">Phone Number:
                        <div><?php echo $_SESSION["user"]->getPhoneNumber() ?></div>
                    </div>
                </div>

                <div id="about_me">
                    <h2>About Me</h2>

                    <div id="output-entry" class="entry">Name:
                        <div><?php echo $_SESSION["user"]->getName()." ".$_SESSION["user"]->getSurname() ?></div>
                    </div>

                    <div id="output-entry" class="entry">Address:
                        <div><?php echo $_SESSION["user"]->getAddress() ?></div>
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

            <div id="gallery_container">
                <?php echo $_SESSION["profile_gallery"] ?>
            </div>
        </div>
    </section>
<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>

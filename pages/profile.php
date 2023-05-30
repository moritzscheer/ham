<?php include_once "../php/head/head.php" ?>
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
                    <label><?php echo $_SESSION["email"]; ?></label>
                </label>

                <label class="entry">Phone Number:
                    <label><?php echo $_SESSION["phoneNumber"]; ?></label>
                </label>
            </div>

            <div id="about-me">
                <h2>About Me</h2>

                <label class="entry">Name:
                    <label><?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?></label>
                </label>

                <label class="entry">Type:
                    <label><?php echo $_SESSION["type"]; ?></label>
                </label>

                <label class="entry">Genre:
                    <label><?php echo $_SESSION["genre"]; ?></label>
                </label>

                <label class="entry">Members:
                    <label><?php echo $_SESSION["members"]; ?></label>
                </label>

                <label class="entry">Other Remarks:
                    <label><?php echo $_SESSION["otherRemarks"]; ?></label><br>
                </label>
            </div>
        </div>

        <div id="uploaded-Images">
            <img src="" alt="could not load Image" height="120" width="120">
        </div>
    </section>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

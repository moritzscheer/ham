<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <form method="post" class="profile-Picture-Large-Box" enctype="multipart/form-data">
        <img src="<?php echo $_SESSION["profile-Picture-Large"]; ?>" alt="could not load image" class="profile-Picture-Large">
        <div>
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
        <form method="post" action="profile.php" class="profile-Content">
            <div id="contact-Information">
                <h2>Contact Information</h2>

                <label class="entry">E-Mail:
                    <label><?php echo $_SESSION["email"]; ?></label>
                </label>

                <label class="entry">Phone Number:
                    <input type="tel" name="phoneNumber" value="<?php echo $_SESSION["phoneNumber"] ?>">
                </label>
            </div>

            <div id="about-me">
                <h2>About Me</h2>

                <label class="entry">Name:
                    <input type="text" name="name" value="<?php echo $_SESSION["name"] ?>">
                </label>

                <label class="entry">Surname:
                    <input type="text" name="surname" value="<?php echo $_SESSION["surname"] ?>">
                </label>

                <label class="entry">Address:
                    <input type="text" name="email" value="<?php echo $_SESSION["address"] ?>">
                </label>

                <label class="entry">Type:
                    <div id="type">
                        <label>Musician
                            <input type="radio" name="type" value="musician" <?php echo $_SESSION["musician"] ?>>
                        </label>
                        <label>Host
                            <input type="radio" name="type" value="host" <?php echo $_SESSION["host"] ?>>
                        </label>
                    </div>
                </label>

                <label class="entry">Genre:
                    <input type="text" name="genre" value="<?php echo $_SESSION["genre"] ?>">
                </label>

                <label class="entry">Members:
                    <input type="text" name="members" value="<?php echo $_SESSION["members"] ?>">
                </label>

                <label class="entry">Other Remarks:
                    <textarea name="otherRemarks" rows="5"><?php echo $_SESSION["otherRemarks"] ?></textarea>
                </label>
            </div>

            <input type="submit" value="Save Changes" id="profile-Submit">
        </form>

        <form method="post" enctype="multipart/form-data" id="uploaded-Images">
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

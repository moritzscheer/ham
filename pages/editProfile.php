<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <h1>edit profile</h1>

    <section class="profile-Grid">

        <!-- profile navigation -->
        <div class="profile-Navigation">
            <div class="profile-Picture-Box">
                <img src="../resources/images/profile/custom.jpg" alt="Profile could not load" height="120" width="120" class="profile-Picture" id="editProfilePicture">
                <label id="profile-Picture-Link">change Image
                    <input type="file" name="profilePicture" style="display:none;" id="profile-Picture-Link"/>
                </label>
            </div>
            <?php include_once "../php/navigation/profile/profileNavigation.php" ?>
        </div>

        <!-- profile content -->
        <form method="post" action="profile.php" class="profile-Content">
            <label class="entry">Name:
                <input type="text" name="name" value="<?php echo $_SESSION["name"] ?>">
            </label>

            <label class="entry">Surname:
                <input type="text" name="surname" value="<?php echo $_SESSION["surname"] ?>">
            </label>

            <label class="entry">E-Mail:
                <input type="email" name="email" value="<?php echo $_SESSION["address"] ?>">
            </label>

            <label class="entry">Phone Number:
                <input type="tel" name="phoneNumber" value="<?php echo $_SESSION["phoneNumber"] ?>">
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
                <textarea name="otherRemarks" rows="5">value="<?php echo $_SESSION["otherRemarks"] ?>"</textarea>
            </label>

            <input type="submit" value="Save Changes" id="profile-Submit">
        </form>
    </section>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

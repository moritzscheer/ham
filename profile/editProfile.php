<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1>edit profile</h1>

    <section class="profile-Grid">

        <!-- profile navigation -->
        <div class="profile-Navigation">
            <div class="profile-Picture-Box">
                <img src="../images/profile/custom.jpg" alt="Profile could not load" height="120" width="120" class="profile-Picture" id="editProfilePicture">
                <label id="profile-Picture-Link">change Image
                    <input type="file" name="profilePicture" id="image" style="display:none;" id="profile-Picture-Link"/>
                </label>
            </div>
            <?php include_once "../profile/profileNavigation.php" ?>
        </div>

        <!-- profile content -->
        <form method="post" action="../profile/profile.php" class="profile-Content">
            <label class="entry">Name:
                <input type="text" name="name" value="Max">
            </label>

            <label class="entry">Surname:
                <input type="text" name="surname" value="Mustermann">
            </label>

            <label class="entry">E-Mail:
                <input type="email" name="email" value="max.mustermann@uni-oldenburg.de">
            </label>

            <label class="entry">Phone Number:
                <input type="tel" name="phoneNumber" value="0176 123456789">
            </label>

            <label class="entry">Type:
                <div id="type">
                    <label>Musician
                        <input type="radio" name="type" value="musician" checked>
                    </label>
                    <label>Host
                        <input type="radio" name="type" value="host">
                    </label>
                </div>
            </label>

            <label class="entry">Genre:
                <input type="text" name="genre" value="rock">
            </label>

            <label class="entry">Members:
                <input type="text" name="members" value="Holger, Artur, Moritz">
            </label>

            <label class="entry">Other Remarks:
                <textarea name="otherRemarks" rows="5">nothing more</textarea>
            </label>

            <input type="submit" value="Save Changes" id="profile-Submit">
        </form>
    </section>

<?php include_once "../php/footer.php" ?>
</body>
</html>

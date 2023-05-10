<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1>edit profile</h1>

    <div class="profile-outer-Grid">
        <div class="profile-inner-Grid">

            <!-- profile navigation -->
            <div class="profileNavigation">
                <div for="image" class="profilePicture-Box">
                    <img src="../images/profilePicture.jpg" alt="Profile could not load" height="120" width="120" class="profilePicture" id="editProfilePicture">
                    <label id="profile-Link">Profilbild ändern
                        <input type="file" name="image" id="image" style="display:none;" id="profile-Link"/>
                    </label>
                </div>
                <?php include_once "../profile/profilNavigation.php" ?>
            </div>

            <!-- profile content -->
            <form method="get" action="account.php" class="profile-Content">
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
                    <textarea type="text" name="otherRemarks" rows="5" resize>nothing more</textarea>
                </label>
            </form>
        </div>
        <form method="get" action="account.php" class="profile-Submit">
            <input type="submit" name="submit" value="save changes" href="../Profile/profile.php" >

        </form>
    </div>

<?php include_once "../php/footer.php" ?>
</body>
</html>

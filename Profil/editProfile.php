<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1>edit profile</h1>

    <div class="profileGrid">

        <!-- profile navigation -->
        <div class="profileNav">
            <label for="image" >
                <input type="file" name="image" id="image" style="display:none;"/>
                <img src="../images/profilePicture.jpg" alt="profile picture" height="100" width="100" class="profilePicture">
            </label>
        </div>

            <!-- profile content -->
        <form method="get" action="account.php" class="profileContent">
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
                <input type="text" name="otherRemarks" value="nothing more">
            </label>

            <a href="../Profile/profile.php" class="accountSubmit">
                <input type="submit" name="submit" value="save changes">
            </a>
        </form>

    </div>

<?php include_once "../php/footer.php" ?>
</body>
</html>

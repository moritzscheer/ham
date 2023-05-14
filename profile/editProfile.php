<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1>edit profile</h1>

    <?php
    $name = (isset($_POST["name"]) && is_string($_POST["name"])) ? $_POST["name"] : "";
    $surname = (isset($_POST["surname"]) && is_string($_POST["surname"])) ? $_POST["surname"] : "";
    $email = (isset($_POST["email"]) && is_string($_POST["email"])) ? $_POST["email"] : "";
    $phoneNumber = (isset($_POST["phoneNumber"]) && is_string($_POST["phoneNumber"])) ? $_POST["phoneNumber"] : "";
    $type = (isset($_POST["type"]) && is_string($_POST["type"])) ? $_POST["type"] : "";
    $genre = (isset($_POST["genre"]) && is_string($_POST["genre"])) ? $_POST["genre"] : "";
    $members = (isset($_POST["members"]) && is_string($_POST["members"])) ? $_POST["members"] : "";
    $otherRemarks = (isset($_POST["otherRemarks"]) && is_string($_POST["otherRemarks"])) ? $_POST["otherRemarks"] : "";

    $name = htmlspecialchars($name);
    $surname = htmlspecialchars($surname);
    $email = htmlspecialchars($email);
    $phoneNumber = htmlspecialchars($phoneNumber);
    $type = htmlspecialchars($type);
    $genre = htmlspecialchars($genre);
    $members = htmlspecialchars($members);
    $otherRemarks = htmlspecialchars($otherRemarks);
    ?>


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
            <form method="post" action="profile.php" class="profile-Content">
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

                <input type="submit" name="submit" value="save changes" href="../Profile/profile.php" >
            </form>
        </div>
    </div>

<?php include_once "../php/footer.php" ?>
</body>
</html>

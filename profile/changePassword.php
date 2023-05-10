<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1 >Change Password</h1>

    <div class="profile-outer-Grid">
        <div class="profile-inner-Grid">

            <!-- account navigation -->
            <div class="profileNavigation">
                <div class="profilePicture-Box">
                    <img src="../images/profilePicture.jpg" alt="profile picture" height="120" width="120" class="profilePicture">
                </div>
                <?php include_once "../profile/profilNavigation.php" ?>
            </div>

            <!-- Passwort änder Feld -->
            <form action="profile.php" class="profile-Content">
                <label class="entry" id="changePassword">Aktuelles Passwort:
                    <input type="password" id="password_actuell"><br>
                </label>

                <label class="entry" id="changePassword">Neues Passwort eingeben:
                    <input type="password" id="password_new_1"><br>
                </label>

                <label class="entry" id="changePassword">Neues Passwort wiederholen:
                    <input type="password" id="password_new_2"><br>
                </label>

            </form>
        </div>
        <form action="profile.php" class="profile-Submit">
            <input type="submit" id="confirm_new_password" value="Neues Passwort einstellen" href="../Profile/profile.php" >
        </form>
    </div>
<?php include_once "../php/footer.php" ?>
</body>
</html>

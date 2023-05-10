<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1 >Change Password</h1>

    <div class="profileGrid">

    <!-- account navigation -->
    <div  class="profileNavBox">
        <div class="profilePicture">
            <img src="../images/profilePicture.jpg" alt="profile picture" height="120" width="120" class="profilePicture">
        </div>
        <?php include_once "../Profil/profilNavigation.php" ?>
    </div>

    <!-- Passwort änder Feld -->
        <form action="profile.php" class="profileContent">
            <label class="entry">Aktuelles Passwort:
                <input type="password" id="password_actuell"><br>
            </label>

            <label class="entry">Neues Passwort eingeben:
                <input type="password" id="password_new_1"><br>
            </label>

            <label class="entry">Neues Passwort wiederholen:
                <input type="password" id="password_new_2"><br>
            </label>

            <a href="../Profile/profile.php" class="accountSubmit">
                <input type="submit" id="confirm_new_password" value="Neues Passwort einstellen">
            </a>
        </form>

</div>
</body>

</html>

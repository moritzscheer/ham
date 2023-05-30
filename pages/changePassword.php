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
        <form method="post" action="../Profile/profile.php" id="loginData">
            <label class="entry">Old Password:
                <input type="password" id="password_actuell">
            </label>

            <label class="entry">New Password:
                <input type="password" id="password_new_1">
            </label>

            <label class="entry">Repeat new Password:
                <input type="password" id="password_new_2">
            </label>

            <input type="submit" value="Neues Passwort einstellen" id="profile-Submit">
        </form>

        <div id="uploaded-Images">
            <img src="" alt="could not load Image" height="120" width="120">
        </div>
    </section>
<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

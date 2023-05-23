<?php include_once "../php/head/head.php" ?>
<link rel="stylesheet" type="text/css" href="../resources/css/profile.css">
</head>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <h1 >Change Password</h1>

    <section class="profile-Grid">
        <!-- account navigation -->
        <div class="profile-Navigation">
            <div class="profile-Picture-Box">
                <img src="../resources/images/profile/custom.jpg" alt="profile picture" height="120" width="120" class="profile-Picture">
            </div>
            <?php include_once "../php/navigation/profile/profileNavigation.php" ?>
        </div>

        <!-- Passwort änder Feld -->
        <form method="post" action="../Profile/profile.php" class="profile-Content" id="profile-Content-Change-Password">
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
    </section>
<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

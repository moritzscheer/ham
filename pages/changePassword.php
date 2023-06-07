<?php global $error_message;
include_once "../php/head/head.php" ?>
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

    <form method="post" id="change-Password-Content" class="profile-Content">
        <div id="loginData">
            <p id="error-message"><?php echo $error_message ?></p>

            <label class="entry">Old Password:
                <input type="password" name="old_password" id="password_actuell">
            </label>
    
            <label class="entry">New Password:
                <input type="password" name="new_password" id="password_new_1">
            </label>

            <label class="entry">Repeat new Password:
                <input type="password" name="repeat_new_password" id="password_new_2">
            </label>
        </div>

        <div id="profile-Submit">
            <a href="profile.php">Cancel</a>
            <input type="submit" name="change_password" value="Save Changes">
        </div>
    </form>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

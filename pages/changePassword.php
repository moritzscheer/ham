<?php
    global $error_message;
    include_once "../php/includes/head/head.php"
?>
<body>
<?php include_once "../php/includes/navigation/header/header.php" ?>

    <section id="popup_elements">
        <?php include_once "../php/includes/elements/delete.php" ?>
    </section>

    <section id="page_content">
        <div class="pictureLarge_container">
            <?php echo $_SESSION["profile_large"] ?>
        </div>

        <div id="navigation_container">
            <div class="pictureSmall_container">
                <div id="pictureSmall_image">
                    <?php echo $_SESSION["profile_small"] ?>
                </div>
            </div>
            <?php include_once $_SESSION["navigation"] ?>
        </div>

        <form method="post" id="changePassword_container" class="information_container">
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
            <div id="password_data">
                <p id="error-message"><?php echo $error_message ?></p>

                <label class="entry">Old Password:
                    <input type="password" name="old_password" id="old_password">
                </label>

                <label class="entry">New Password:
                    <input type="password" name="new_password" id="new_password">
                </label>

                <label class="entry">Repeat new Password:
                    <input type="password" name="repeat_new_password" id="repeat_new_password">
                </label>
            </div>

            <div id="profile_submit">
                <label>Cancel
                    <input type="submit" name="viewProfile" value="<?php echo $_SESSION["loggedIn"]["user_ID"] ?>">
                </label>
                <label>Save Changes
                    <input type="submit" name="change_password">
                </label>
            </div>
        </form>
    </section>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>

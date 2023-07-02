<?php global $error_message;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/includes/navigation/header/header.php" ?>

    <section id="popup_elements">
        <?php include_once "../php/includes/elements/deleteAccount.php"?>
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
            <div id="password_data">
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

            <div id="profile_submit">
                <label>Cancel
                    <input type="submit" name="viewProfile" value="<?php echo $_SESSION["user_ID"] ?>">
                </label>
                <label>Save <Change></Change>
                    <input type="submit" name="change_password">
                </label>
            </div>
        </form>
    </section>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>

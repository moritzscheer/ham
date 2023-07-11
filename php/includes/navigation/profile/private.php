<nav id="navigation_buttons">
    <form method="post" action="editProfile.php">
        <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
        <label id="navigation_button">edit Profile
            <input type="submit" name="viewEditProfile" value="<?php echo $_SESSION["user_ID"] ?>">
        </label>
    </form>

    <form method="post" action="changePassword.php">
        <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
        <label id="navigation_button">Change Password
            <input type="submit" name="viewChangePassword" value="<?php echo $_SESSION["user_ID"] ?>">
        </label>
    </form>

    <form method="post">
        <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
        <label id="navigation_button">Log-out
            <input type="submit" name="logout">
        </label>
    </form>

    <form method="post">
        <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
        <label id="navigation_button">Delete Account
            <input type="submit" name="onDeleteClicked">
        </label>
    </form>

    <form method="post" id="hint_button" class="<?php echo $_SESSION["hintField"]["button"] ?>">
        <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
        <label>?
            <input type="submit" name="show_hint" value='Hint: To Change Images in Profile hover on an image and select "Edit Image".'>
        </label>
    </form>
</nav>
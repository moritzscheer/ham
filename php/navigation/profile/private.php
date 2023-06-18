<div class="profile-Links">
    <form method="post" action="editProfile.php">
        <label id="profile-navbar-button">edit Profile
            <input type="submit" name="viewEditProfile" value="<?php echo $_SESSION["user_ID"] ?>">
        </label>
    </form>

    <form method="post" action="changePassword.php">
        <label id="profile-navbar-button">Change Password
            <input type="submit" name="viewChangePassword" value="<?php echo $_SESSION["user_ID"] ?>">
        </label>
    </form>

    <form method="post">
        <label id="profile-navbar-button">Log-out
            <input type="submit" name="logout">
        </label>
    </form>

    <form method="post">
        <label id="profile-navbar-button">Delete Account
            <input type="submit" name="delete">
        </label>
    </form>
</div>
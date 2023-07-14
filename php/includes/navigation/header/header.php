<?php global $newEvent?>
<header>
    <div id="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="../resources/images/logo/ham_white_small.png" alt="logo" height="60" width="auto">
            </a>
        </div>

        <form action="events.php?type=events" method="post" id="desktop">
            <label id="navbar-button">Events
                <input type="submit">
            </label>
        </form>

        <form action="bands.php?type=bands" method="post" id="desktop">
            <label id="navbar-button">Bands
                <input type="submit" id="navbar-button">
            </label>
        </form>

        <form action="closeToMe.php" id="desktop">
            <label id="navbar-button">Close to Me
                <input type="submit" id="navbar-button">
            </label>
        </form>

        <form action="createEvent.php?status=create" id="mobile" class="<?php echo $_SESSION["profileHeader"] ?> create">
            <label id="navbar-button">create
                <input type="submit">
            </label>
        </form>

        <form action="register.php" method="post" id="desktop" class="<?php echo $_SESSION["normalHeader"] ?> login">
            <label id="navbar-button">Sign Up
                <input type="submit" id="navbar-button" name="reset">
            </label>
        </form>

        <form action="login.php" method="post" id="desktop" class="<?php echo $_SESSION["normalHeader"] ?> login">
            <label id="navbar-button">Log-In
                <input type="submit" id="navbar-button" name="reset">
            </label>
        </form>

        <form id="mobile" class="<?php echo $_SESSION["profileHeader"] ?> dropdown dropdownProfile">
            <div id="navbar-Profile">
                <?php echo $_SESSION["profileHeaderBox"]; ?>
            </div>
            <div ID="pictureSmall_image">
                <?php echo $_SESSION["loggedIn"]["profile_small"] ?>
            </div>
        </form>

        <div id="mobile" class="dropdown dropdownGeneral">
            <img src="../resources/images/header/menu.png" alt="profile" height="50">
        </div>
    </div>



    <div id="content-general" class="Header-Content">
        <form action="bands.php?type=bands">
            <label id="navbar-button">Bands
                <input type="submit" value="Bands">
            </label>
        </form>

        <form action="events.php?type=events">
            <label id="navbar-button">Events
                <input type="submit">
            </label>
        </form>

        <form action="closeToMe.php">
            <label id="navbar-button">Close To Me
                <input type="submit" value="Close to Me">
            </label>
        </form>

        <form action="createEvent.php?status=create" id="desktop" class="<?php echo $_SESSION["profileHeader"]?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
            <label id="navbar-button">create
                <input type="submit" name="onCreate" value="create">
            </form>
        </form>
    </div>

    <div id="content-profile" class="Header-Content">
        <form action="register.php" method="post" class="<?php echo $_SESSION["normalHeader"]?>">
            <label id="navbar-button">Sign Up
                <input type="submit" name="reset">
            </label>
        </form>

        <form action="login.php" class="<?php echo $_SESSION["normalHeader"]?>">
            <label id="navbar-button">Log-In
                <input type="submit">
            </label>
        </form>

        <form action="profile.php" method="post" id="desktop" class="<?php echo $_SESSION["profileHeader"]?>">
            <label id="navbar-button">profile
                <input type="submit" name="viewProfile" value="<?php echo $_SESSION["loggedIn"]["user_ID"] ?>">
            </label>
        </form>

        <form method="post" id="desktop" class="<?php echo $_SESSION["profileHeader"]?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
            <label id="navbar-button">Log-out
                <input type="submit" name="logout">
            </label>
        </form>
    </div>
</header>

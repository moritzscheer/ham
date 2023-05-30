<nav>
    <div id="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="../../../resources/images/logo/ham_white_small.png" alt="logo" height="50">
            </a>
        </div>

        <div id="desktop">
            <form action="bands.php?type=bands" method="post">
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>

        <div id="desktop">
            <form action="events.php?type=events" method="post">
                <input type="submit" value="Events" id="navbar-button">
            </form>
        </div>

        <div id="desktop">
            <form action="closeToMe.php">
                <input type="submit" value="Close to Me" id="navbar-button">
            </form>
        </div>

        <div id="mobile" class="<?php echo $_SESSION["profileHeader"]?> create">
            <form action="createEvent.php">
                <input type="submit" value="create" id="navbar-button">
            </form>
        </div>

        <div id="desktop" class="<?php echo $_SESSION["normalHeader"]?> login">
            <form action="register.php" method="post">
                <input type="submit" value="Sign Up" id="navbar-button" name="reset">
            </form>
        </div>

        <div id="desktop" class="<?php echo $_SESSION["normalHeader"]?> login">
            <form action="login.php">
                <input type="submit" value="Log-In" id="navbar-button" name="reset">
            </form>
        </div>

        <div id="mobile" class="<?php echo $_SESSION["profileHeader"]?> dropdown dropdownProfile">
            <div id="navbar-Profile">
                <?php echo $_SESSION["profileHeaderBox"]; ?>
            </div>
            <img src="<?php echo $_SESSION["profile-Picture-Small"]; ?>" height="50" width="50" alt="profilePicture" class="profile-Picture">
        </div>

        <div id="mobile" class="dropdown dropdownGeneral">
            <img src="../../../resources/images/header/menu.png" alt="profile" height="50">
        </div>
    </div>



    <div id="content-general" class="Header-Content">
        <div>
            <form action="bands.php" >
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>

        <div>
            <form action="events.php">
                <input type="submit" value="Events" id="navbar-button">
            </form>
        </div>

        <div>
            <form action="closeToMe.php">
                <input type="submit" value="Close to Me" id="navbar-button">
            </form>
        </div>

        <div id="desktop" class="<?php echo $_SESSION["profileHeader"]?>">
            <form action="createEvent.php"">
                <input type="submit" value="create" id="navbar-create-button">
            </form>
        </div>
    </div>

    <div id="content-profile" class="Header-Content">
        <div class="<?php echo $_SESSION["normalHeader"]?>">
            <form action="register.php" method="post">
                <input type="submit" value="Sign Up" id="navbar-button" name="reset">
            </form>
        </div>

        <div class="<?php echo $_SESSION["normalHeader"]?>">
            <form action="login.php">
                <input type="submit" value="Log-In" id="navbar-button">
            </form>
        </div>

        <div id="desktop" class="<?php echo $_SESSION["profileHeader"]?>">
            <form action="profile.php" id="navbar-Item">
                <input type="submit" value="Profile" id="navbar-button">
            </form>
        </div>

        <div id="desktop" class="<?php echo $_SESSION["profileHeader"]?>">
            <form action="index.php" method="post" id="navbar-Item">
                <input type="submit" value="Log-out" id="navbar-button" name="logout">
            </form>
        </div>
    </div>
</nav>

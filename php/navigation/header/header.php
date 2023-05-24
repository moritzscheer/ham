<nav>
    <div id="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="../../../resources/images/logo/ham_white_small.png" alt="logo" height="50">
            </a>
        </div>
        <p>Current session ID: <?php echo session_id(); ?></p>
        <div id="visible">
            <form action="bands.php">
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>

        <div id="visible">
            <form action="events.php">
                <input type="submit" value="Events" id="navbar-button">
            </form>
        </div>

        <div id="visible">
            <form action="closeToMe.php">
                <input type="submit" value="Close to Me" id="navbar-button">
            </form>
        </div>

        <div id="hidden" class="<?php echo $_SESSION["profileHeader"]?> create">
            <form action="createEvent.php">
                <input type="submit" value="create" id="navbar-button">
            </form>
        </div>

        <div id="visible" class="<?php echo $_SESSION["normalHeader"]?> login">
            <form action="register.php">
                <input type="submit" value="Sign Up" id="navbar-button">
            </form>
        </div>

        <div id="visible" class="<?php echo $_SESSION["normalHeader"]?> login">
            <form action="login.php">
                <input type="submit" value="Log-In" id="navbar-button">
            </form>
        </div>

        <div id="hidden" class="<?php echo $_SESSION["profileHeader"]?> dropdown dropdownProfile">
            <div id="navbar-Profile">
                <div>
                    <?php echo $_SESSION["name"]; ?>
                    <?php echo $_SESSION["surname"]; ?>
                </div>
                <div>
                    <?php echo $_SESSION["type"]; ?>
                </div>
            </div>
            <img src="../../../resources/images/profile/default.png" height="50" width="50" alt="profilePicture" class="profile-Picture">
        </div>

        <div class="hidden dropdown dropdownGeneral">
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

        <div class="<?php echo $_SESSION["profileHeader"]?>>
            <form action="createEvent.php"">
                <input type="submit" value="create" id="navbar-create-button">
            </form>
        </div>
    </div>

    <div id="content-profile" class="Header-Content">
        <div class="<?php echo $_SESSION["normalHeader"]?>">
            <form action="register.php">
                <input type="submit" value="Sign Up" id="navbar-button">
            </form>
        </div>

        <div class="<?php echo $_SESSION["normalHeader"]?>">
            <form action="login.php">
                <input type="submit" value="Log-In" id="navbar-button">
            </form>
        </div>

        <div class="<?php echo $_SESSION["profileHeader"]?>">
            <form action="profile.php" id="navbar-Item">
                <input type="submit" value="Profile" id="navbar-button">
            </form>
        </div>

        <div class="<?php echo $_SESSION["profileHeader"]?>">
            <form action="index.php" method="post" id="navbar-Item">
                <input type="submit" value="Log-out" id="navbar-button" name="logout">
            </form>
        </div>
    </div>
</nav>

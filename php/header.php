<nav>
    <div id="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="../images/logo/ham_white_small.png" alt="logo" height="50">
            </a>
        </div>

        <div class="desktop">
            <form action="bands.php">
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>

        <div class="desktop">
            <form action="events.php">
                <input type="submit" value="Events" id="navbar-button">
            </form>
        </div>

        <div class="desktop">
            <form action="closeToMe.php">
                <input type="submit" value="Close to Me" id="navbar-button">
            </form>
        </div>

        <div class="desktop <?php echo $_SESSION["profileHeader"]?>">
            <form action="createEvent.php">
                <input type="submit" value="create" id="navbar-button" class="create">
            </form>
        </div>

        <div class="desktop <?php echo $_SESSION["normalHeader"]?>">
            <form action="profile/register.php">
                <input type="submit" value="Sign Up" id="navbar-button">
            </form>
        </div>

        <div class="desktop <?php echo $_SESSION["normalHeader"]?>">
            <form action="profile/login.php">
                <input type="submit" value="Log-In" id="navbar-button">
            </form>
        </div>

        <div id="dropdownProfile" class="mobile dropdown  <?php echo $_SESSION["profileHeader"]?>">
            <div id="navbar-Profile">
                <div>
                    <?php echo $_SESSION["name"]; ?>
                    <?php echo $_SESSION["surname"]; ?>
                </div>
                <div>
                    <?php echo $_SESSION["type"]; ?>
                </div>
            </div>
            <img src="../images/profile/default.png" height="50" width="50" alt="profilePicture" class="profile-Picture">
        </div>

        <div id="dropdownGeneral" class="mobile dropdown">
            <img src="../images/header/menu.png" alt="profile" height="50">
        </div>
    </div>



    <div id="content-general" class="Header-Content">
        <div id="content-Item" >
            <form action="bands.php" >
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>

        <div id="content-Item">
            <form action="events.php">
                <input type="submit" value="Events" id="navbar-button">
            </form>
        </div>

        <div id="content-Item">
            <form action="closeToMe.php">
                <input type="submit" value="Close to Me" id="navbar-button">
            </form>
        </div>

        <div id="content-Item">
            <form action="createEvent.php" class="<?php echo $_SESSION["profileHeader"]?>">
                <input type="submit" value="create" id="navbar-create-button">
            </form>
        </div>
    </div>

    <div id="content-profile" class="Header-Content">
        <div id="content-Item" class=" <?php echo $_SESSION["normalHeader"]?>">
            <form action="profile/register.php">
                <input type="submit" value="Sign Up" id="navbar-button">
            </form>
        </div>

        <div id="content-Item" class=" <?php echo $_SESSION["normalHeader"]?>">
            <form action="profile/login.php">
                <input type="submit" value="Log-In" id="navbar-button">
            </form>
        </div>

        <div id="content-Item" class="<?php echo $_SESSION["profileHeader"]?>">
            <form action="profile/profile.php" id="navbar-Item">
                <input type="submit" value="Profile" id="navbar-button">
            </form>
        </div>

        <div id="content-Item" class="<?php echo $_SESSION["profileHeader"]?>">
            <form action="index.php" method="post" id="navbar-Item">
                <input type="submit" value="Log-out" id="navbar-button" name="logout">
            </form>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" media="screen" href="../css/header.css">
</nav>


<nav>
    <div id="nav-bar">
        <div id="header">
            <form action="bands.php" >
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>

        <div id="header">
            <form action="events.php" >
                <input type="submit" value="Events" id="navbar-button">
            </form>
        </div>

        <div id="header">
            <form action="closeToMe.php">
                <input type="submit" value="Close to Me" id="navbar-button">
            </form>
        </div>

        <div id="header">
            <form action="createEvent.php" class="blue-button">
                <input type="submit" value="create" id="navbar-create-button">
            </form>
        </div>

        <div id="header" class="<?php echo $_SESSION["normalHeader"]?>">
            <form action="profile/register.php">
                <input type="submit" value="Sign Up" id="navbar-button">
            </form>
        </div>

        <div id="header" class="<?php echo $_SESSION["normalHeader"]?>">
            <form action="profile/login.php">
                <input type="submit" value="Log-In" id="navbar-button">
            </form>
        </div>

        <div id="header" class="dropdown">
            <div id="dropdown-header" class="<?php echo $_SESSION["profileHeader"]?>">
                <?php echo $_SESSION["name"]; ?><br>
                <?php echo $_SESSION["type"]; ?>
                <img src="images/profilePicture.jpg" height="50" width="50" class="profilePicture">
            </div>

            <div id="dropdown-content">
                <form action="profile/profile.php" id="header">
                    <input type="submit" value="Profile" id="navbar-button">
                </form>
                <form action="index.php" method="post" id="header">
                    <input type="submit" value="Log-out" id="navbar-button" name="logout">
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
</nav>


<nav>
    <div id="nav-bar">
        <div id="header">
            <form action="../bands.php" >
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>
        <div id="header">
            <form action="../events.php" >
                <input type="submit" value="Veranstaltungen" id="navbar-button">
            </form>
        </div>
        <div id="header">
            <form action="../closeToMe.php">
                <input type="submit" value="In meiner Nähe" id="navbar-button">
            </form>
        </div>
        <div id="header">
            <form action="../createEvent.php" class="blue-button">
                <input type="submit" value="Erstellen" id="navbar-create-button">
            </form>
        </div>
        <div class="dropdown" id="header">
            <img src="../images/profilePicture.jpg" height="30" width="30" id="profilPicture">

            <div class="dropdown-content">
                <form action="../Profil/profile.php" id="header">
                    <input type="submit" value="Profil" id="navbar-button">
                </form>
                <form action="../index.php" id="header">
                    <input type="submit" value="Log-out" id="navbar-button">
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="../css/header.css">
</nav>
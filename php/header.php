
<nav>
    <div id="nav-bar">
        <div id="header">
            <form action="bands.php" >
                <input type="submit" value="Bands" id="navbar-button">
            </form>
        </div>
        <div id="header">
            <form action="events.php" >
                <input type="submit" value="Veranstaltungen" id="navbar-button">
            </form>
        </div>
        <div id="header">
            <form action="inMeinerNähe.php">
                <input type="submit" value="In meiner Nähe" id="navbar-button">
            </form>
        </div>
        <div id="header">
            <form action="createEvent.php" class="blue-button">
                <input type="submit" value="Erstellen" id="navbar-button">
            </form>
        </div>
        <div class="dropdown" id="header">
            <img src="images/profilePicture.jpg" height="30" width="30" id="profilPicture">

            <div class="dropdown-content">
                <form action="profil.php" id="header">
                    <input type="submit" value="Profil" id="navbar-button">
                </form>
                <form action="index.php" id="header">
                    <input type="submit" value="Log-out" id="navbar-button">
                </form>
            </div>
        </div>
    </div>
</nav>
<style itemscope lang="css">
    #header {
        flex-wrap: wrap;
        display: flex;
        align-content: center;
    }

    #navbar-button {
        background-color: transparent;
        height: 50px;
        width: 150px;
        border: transparent;
        cursor: pointer;
        font: bold 18px sans-serif;
    }
    #navbar-button:hover {
            border-bottom: 2px solid gray;
    }
    #nav-bar {
        display: inline-flex;
        width: 94%;
        justify-content: space-evenly;
        margin: 30px 3% 10px 3%;
        border: lightgrey dashed 2px;
        border-radius: 8px;
    }

    .blue-button {
        background: linear-gradient(135deg, rgba(16,147,227,1) 10%, rgba(154,242,136,1) 100%);
        border-radius: 8px;
        margin: 10px 10px 10px 10px ;
    }




</style>
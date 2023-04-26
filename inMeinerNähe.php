<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/header.php" ?>

    <!-- input -->
    <div>
        <h1> In meiner Nähe</h1>

        <!-- Filter -->
        <div>
            <form method="searchMap" action="event.php">
                <input type="text" name="search" value="">
                <label>Umkreis</label>
                <input type="range" min="10" max="200" id="range" name="range" step="1" value="0">
            </form>
        </div>

        <!-- Map -->
        <div>
            <img src="images/map.png">
        </div>
    </div>

    <!-- Output -->
    <div>
        <!-- Event 1 -->
        <div>
            <img src="images/event.jpg" alt="eventImage"/>
            <br>
            <span>
           Name: Neueröffnung Hornbach Bau- und Gartenmarkt Leipzig
        </span>
            <br>
            <span>
             Datum: 12 April 2023
        </span>
            <br>
            <span>
           Adresse: Steinweg 2, 42275 Wuppertal
        </span>
        </div>
        <br>

        <!-- Event 2 -->
        <div>
            <img src="images/event2.jpg" alt="eventImage"/>
            <br>
            <span>
           Name: Neueröffnung Hornbach Bau- und Gartenmarkt Leipzig
        </span>
            <br>
            <span>
             Datum: 12 April 2023
        </span>
            <br>
            <span>
           Adresse: Steinweg 2, 42275 Wuppertal
        </span>
        </div>
    </div>

    <?php include_once "php/footer.php" ?>

</body>

</html>
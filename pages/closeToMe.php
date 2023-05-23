<?php include_once "../php/head/head.php" ?>
<link rel="stylesheet" type="text/css" href="../resources/css/closeToMe.css">
</head>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <h1> In meiner Nähe</h1>

    <?php

    $range = (isset($_POST["range"]) &&
        is_string($_POST["range"])) ? $_POST["range"] : "";
    $range = htmlspecialchars($range);
    echo $range;
    ?>

    <div class="closeToMe-Grid">
        <form method="post" class="closeToMe-Filter">
            <input type="text" name="search" placeholder="search" class="closeToMe-Search">
            <label class="closeToMe-Radius-Box">Radius
                <input type="range" min="10" max="200" id="range-radius" name="range" step="1" value="0" class="closeToMe-Radius">
            </label>
        </form>

        <!-- Map -->
        <div id="mapBox">
            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d153122.14293201643!2d8.2883743!3d53.1544666!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2sde!4v1683737882607!5m2!1sde!2sde" width="100%" height="600" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
        </div>

        <!-- List of Items (Bands or Events) -->
        <?php include_once "../php/itemList.php" ?>

    </div>

<?php include_once "../php/navigation/footer/footer.php" ?>

</body>

</html>
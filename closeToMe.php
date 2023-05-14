<?php include_once "php/head.php" ?>
<body>
<?php include_once "php/header.php" ?>

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
                <input type="range" min="10" max="200" id="range" name="range" step="1" value="0" class="closeToMe-Radius">
            </label>
        </form>

        <!-- Map -->
        <div id="mapBox">
            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d153122.14293201643!2d8.2883743!3d53.1544666!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2sde!4v1683737882607!5m2!1sde!2sde" width="100%" height="600" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
        </div>

        <!-- Band 1 -->
        <div id="item-list-view">
            <section id="item-list">
                <div id="item">
                    <img id="item-image" src="images/event.jpg" alt="eventImage"/>
                    <div id="item-description">
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
                <div id="item">
                    <img id="item-image" src="images/event2.jpg" alt="eventImage"/>
                    <div id="item-description">
                     <span>
                         Name: MyWellness - Wellness-Center
                     </span>
                        <br>
                        <span>
                        Datum 22 Februar 2023
                    </span>
                        <br>
                        <span>
                        Adresse: Richard Lehmann Straße 117, 04103 Leipzig
                    </span>
                    </div>
                </div>
                <div id="item">
                    <img id="item-image" src="images/event.jpg" alt="eventImage"/>
                    <div id="item-description">
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
                <div id="item">
                    <img id="item-image" src="images/event2.jpg" alt="eventImage"/>
                    <div id="item-description">
                     <span>
                         Name: MyWellness - Wellness-Center
                     </span>
                        <br>
                        <span>
                        Datum 22 Februar 2023
                    </span>
                        <br>
                        <span>
                        Adresse: Richard Lehmann Straße 117, 04103 Leipzig
                    </span>
                    </div>
                </div>
            </section>
            <section id="item-details">
                <div id="item-details-title">
                    <img id="item-image" src="images/event.jpg" alt="eventImage"/>
                    <h2 id="item-details-name"> Neueröffnung Hornbach Bau- und Gartenmarkt Leipzig </h2>
                </div>
                <div>
                    <p>
                        Hornbach Bau- und Gartenmarkt eröffnet voraussichtlich im Frühjahr 2023 einen weiteren Markt in Leipzig auf rund 10.000 Quadratmetern und einem Gartenmarkt mit rund 3.000 Quadratmetern.
                        <br>
                        <br>
                        Wann?: 22 Februar 2023 14-17 Uhr<br>
                        Wo?: Richard Lehmann Straße 117, 04103 Leipzig<br>
                    </p>
                </div>
                <div id="item-details-foot">
                    <p>
                        <b>Sucht </b> <br>
                        <br>
                        Jazzband mit Repertoir für einen Nachmittag (3std)<br>
                        Kostenlose Verpflegung<br>
                        Bis 2000€
                    </p>
                </div>
            </section>
        </div>
    </div>


    <?php include_once "php/footer.php" ?>

</body>

</html>
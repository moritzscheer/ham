<?php include_once "php/head.php" ?>

<body>

    <div class="grid">

        <?php include_once "php/header.php" ?>

        <div class="content">
            <div class="headline">
                <h1>Profil</h1>
            </div>

            <!-- account navigation -->
            <?php include_once "profil_navigation.php" ?>

            <!-- account information -->
            <div class="info">
                <label>Vorname:</label>
                <label id="Max"></label><br>

                <label>Nachname:</label>
                <label id="nachname">Mustermann</label><br>

                <label>Email:</label>
                <label id="email">max.mustermann@uni-oldenburg.de</label><br>

                <label>Telefonnummer:</label>
                <label id="nummer">0176 123456789</label><br>

                <label>Typ:</label>
                <label id="typ">Musiker</label><br>

                <label>Genre:</label>
                <label id="genre">Rock</label><br>

                <label>Mitglieder:</label>
                <label id="mitglieder">Holger, Artur, Moritz</label><br>

                <label>Name:</label>
                <label id="name">Musiker</label><br>

                <label>sonstige Anmerkungen:</label>
                <label id="more">nichts weiters</label><br><br>
            </div>
        </div>

        <?php include_once "php/footer.php" ?>

    </div>

</body>

</html>

<?php include_once "php/head.php" ?>

<body>

    <div class="grid">

        <?php include_once "php/header.php" ?>

        <div class="profileContent">
            <!-- headline -->
            <h1 class="headline">Profil</h1>

            <!-- account navigation -->
            <?php include_once "profil_navigation.php" ?>

            <!-- account information parameter -->
            <div class="label">
                <label>Vorname:</label><br>
                <label>Nachname:</label><br>
                <label>Email:</label><br>
                <label>Telefonnummer:</label><br>
                <label>Typ:</label><br>
                <label>Genre:</label><br>
                <label>Mitglieder:</label><br>
                <label>Name:</label><br>
                <label>sonstige Anmerkungen:</label><br>
            </div>

            <!-- account information value -->
            <div class="labelInfo">
                <label id="Max">Max</label><br>
                <label id="nachname">Mustermann</label><br>
                <label id="email">max.mustermann@uni-oldenburg.de</label><br>
                <label id="nummer">0176 123456789</label><br>
                <label id="typ">Musiker</label><br>
                <label id="genre">Rock</label><br>
                <label id="mitglieder">Holger, Artur, Moritz</label><br>
                <label id="name">Musiker</label><br>
                <label id="more">nichts weiters</label><br><br>
            </div>
        </div>

        <?php include_once "php/footer.php" ?>

    </div>

</body>

</html>

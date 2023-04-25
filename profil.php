<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/header.php" ?>

    <div>
        <br>
        <div class="acountNav">
            <img src="/images/Profilbild.jpg" alt="Profilbild">

            <a href="profilBearbeiten.php">Profil Bearbeiten</a>
            <a href="index.php">Ausloggen</a>
            <a href="passwortÄndern.php">Passwort ändern</a>
        </div>
        <div>
            <label>Vorname:</label>
            <label for="Max"></label><br>

            <label>Nachname:</label>
            <label for="nachname">Mustermann</label><br>

            <label>Email:</label>
            <label for="email">max.mustermann@uni-oldenburg.de</label><br>

            <label>Telefonnummer:</label>
            <label for="nummer">0176 123456789</label><br>

            <label>Typ:</label>
            <label for="typ">Musiker</label><br>

            <label>Genre:</label>
            <label for="genre">Rock</label><br>

            <label>Mitglieder:</label>
            <label for="mitglieder">Holger, Artur, Moritz</label><br>

            <label>Name:</label>
            <label for="typ">Musiker</label><br>

            <label>sonstige Anmerkungen:</label>
            <label for="more">nichts weiters</label><br><br>
        </div>
    </div>

    <?php include_once "php/footer.php" ?>

</body>

</html>
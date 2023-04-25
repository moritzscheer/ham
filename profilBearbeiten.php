<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/header.php" ?>

    <div>
        <br>
        <div class="acountNav">
            <input type="File"  id="profilbild" accept=".jpg,.png,.pdf">
            <img src="/images/Profilbild.jpg" alt="Profilbild" height="100" width="100">

            <a href="index.php">Account löschen</a>
        </div>
        <div>
            <form method="acountInfo" action="/account.php">
                <label for="vorname">Vorname:</label>
                <input type="text" name="vorname" value="Max"><br>

                <label for="nachname">Nachname:</label>
                <input type="text" name="nachname" value="Mustermann"><br>

                <label for="email">Email:</label>
                <input type="email" name="emal" value="max.mustermann@uni-oldenburg.de"><br>

                <label for="nummer">Telefonnummer:</label>
                <input type="tel" name="nummer" value="0176 123456789"><br>

                <label for="typ">Typ:</label>
                <input type="radio" name="typ" value="Musiker" checked>
                <label>Musiker</label>
                <input type="radio" name="typ" value="Veranstalter">
                <label>Veranstalter</label><br>

                <label for="genre">Genre:</label>
                <input type="text" name="typ" value="Rock"><br>

                <label for="mitglieder">Mitglieder:</label>
                <input type="text" name="typ" value="Holger, Artur, Moritz"><br>

                <label for="typ">Name:</label>
                <input type="text" name="typ" value="Musiker"><br>

                <label for="more">sonstige Anmerkungen:</label>
                <input type="text" name="more" value="nichts weiteres"><br><br>

                <a href="profil.php">
                    <input type="button" name="submit" value="Einstellungen speichern">
                </a>
            </form>
        </div>
    </div>

    <?php include_once "php/footer.php" ?>

</body>

</html>
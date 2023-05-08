<?php include_once "../php/head.php" ?>

<body>

    <div class="grid">

        <?php include_once "../php/head<er.php" ?>

        <div class="content">
            <div class="headline">
                <h1>Profil Bearbeiten</h1>
            </div>

            <!-- account navigation -->
            <div class="profilNav">
                <input type="File"  id="profilbild" accept=".jpg,.png,.pdf">
                <img src="../images/profilePicture.jpg" alt="Profilbild" height="200" width="200">
            </div>

            <!-- account  information -->
            <div class="info">
                <form class="info-elements" method="get" action="account.php">
                    <label id="vorname">Vorname:
                    <input type="text" name="vorname" value="Max">
                    </label>

                    <label id="nachname">Nachname:
                    <input type="text" name="nachname" value="Mustermann">
                    </label>

                    <label id="email">Email:
                    <input type="email" name="email" value="max.mustermann@uni-oldenburg.de">
                    </label>

                    <label id="nummer">Telefonnummer:
                    <input type="tel" name="nummer" value="0176 123456789">
                    </label>

                    <label id="typ">Typ:</label>
                    <div class="chooseRole">
                        <input type="radio" name="typ" value="Musiker" checked>
                        <label>Musiker</label>
                    </div>
                    <div class="chooseRole">
                        <input type="radio" name="typ" value="Veranstalter">
                        <label>Veranstalter</label>
                    </div>

                    <label id="genre">Genre:
                    <input type="text" name="typ" value="Rock">
                    </label>

                    <label id="mitglieder">Mitglieder:
                    <input type="text" name="typ" value="Holger, Artur, Moritz">
                    </label>

                    <label id="name">Name:
                    <input type="text" name="typ" value="Musiker">
                    </label>

                    <label id="more">sonstige Anmerkungen:</label>
                    <input type="text" name="more" value="nichts weiteres">

                    <a href="profile.php">
                        <input type="submit" name="submit" value="Einstellungen speichern">
                    </a>
                </form>
            </div>
        </div>


        <?php include_once "../php/footer.php" ?>

    </div>
    <link rel="stylesheet" type="text/css" href="../css/editProfil.css">

</body>

</html>
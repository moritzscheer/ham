<?php include_once "../php/head.php" ?>

<body>

    <div class="grid">

        <?php include_once "../php/header.php" ?>

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
                    <label id="vorname">Vorname:</label>
                    <input type="text" name="vorname" value="Max"><br>

                    <label id="nachname">Nachname:</label>
                    <input type="text" name="nachname" value="Mustermann"><br>

                    <label id="email">Email:</label>
                    <input type="email" name="email" value="max.mustermann@uni-oldenburg.de"><br>

                    <label id="nummer">Telefonnummer:</label>
                    <input type="tel" name="nummer" value="0176 123456789"><br>

                    <label id="typ">Typ:</label>
                    <input type="radio" name="typ" value="Musiker" checked>
                    <label>Musiker</label>
                    <input type="radio" name="typ" value="Veranstalter">
                    <label>Veranstalter</label><br>

                    <label id="genre">Genre:</label>
                    <input type="text" name="typ" value="Rock"><br>

                    <label id="mitglieder">Mitglieder:</label>
                    <input type="text" name="typ" value="Holger, Artur, Moritz"><br>

                    <label id="name">Name:</label>
                    <input type="text" name="typ" value="Musiker"><br>

                    <label id="more">sonstige Anmerkungen:</label>
                    <input type="text" name="more" value="nichts weiteres"><br><br>

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
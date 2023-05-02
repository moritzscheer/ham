<?php include_once "php/head.php" ?>

<body>

<?php include_once "php/header.php" ?>

<div>
    <h1>Profil</h1>

    <!-- Navigation -->
    <?php include_once "profil_navigation.php" ?>

    <!-- Passwort änder Feld-->
    <div class="change_password">

        <form action="profile.php">
            <label>Aktuelles Passwort:</label>
            <input type="password" id="password_actuell"><br>

            <label>Neues Passwort eingeben:</label>
            <input type="password" id="password_new_1"><br>

            <label>Neues Passwort wiederholen:</label>
            <input type="password" id="password_new_2"><br>

            <input type="submit" id="confirm_new_password" value="Neues Passwort einstellen">

        </form>

    </div>

</div>
</body>

</html>

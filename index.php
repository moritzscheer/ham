<?php $_SESSION["loggedIn"] = 0; ?>
<?php include_once "php/head.php" ?>
<body>

<?php include_once "php/header.php" ?>

<section id="about-area">
    <div id="about-picture">
        <img id="about-logo-img" src="images/logo/ham_white.png" alt="ham-Logo">
    </div>
    <div id="about-content">
        <h1 id="welcome-head">Herzlich Willkommen</h1>
        <p>
            Du bist Veranstalter und suchst Künstler für die Veranstaltung? Oder du bist Künstler und möchtest einen
            Gig? Dann bist du hier bei <i>ham</i> genau richtig. <i>ham</i> steht für "high authentic music-events" und bietet dir die
            Möglichkeit dich mit Veranstaltern und Künstern zu vernetzen. Registriere dich jetzt!
        </p>
        <form action="profile/register.php">
            <input id="about-register-button" type="submit" value="Registrieren">
        </form>
    </div>
</section>
<link rel="stylesheet" type="text/css" media="screen" href="css/format.css">
<?php include_once "php/footer.php" ?>

</body>
</html>

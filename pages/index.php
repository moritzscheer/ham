<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

<section id="about-area">
    <div id="about-picture">
        <img id="about-logo-img" src="../resources/images/logo/ham_white.png" alt="ham-Logo">
    </div>
    <div id="about-content">
        <h1 id="welcome-head">Welcome</h1>
        <p>
            Are you an event organizer looking for artists for your event? Or are you an artist looking for a gig?
            Then you've come to the right place with <i>ham</i>. <i>ham</i> stands for "high authentic music-events"
            and offers you the opportunity to connect with organizers and artists. Register now!
        </p>
        <form action="register.php">
            <input id="about-register-button" type="submit" value="Register">
        </form>
    </div>
</section>
         <?php echo var_dump($_SESSION["initDatabase"]) ?>
<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>
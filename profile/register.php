<?php include_once "../php/head.php" ?>

<body class="app">
<section class="register">
    <div class="registerElement">
        <label id="Hregister">Registrieren</label>
    </div>
    <div>
        <form class="registerElement">
            <label id="rname">Name:</label>
            <input type="text" id="rname">
        </form>
    </div>
    <div>
        <form class="registerElement">
            <label id="remail">E-Mail Adresse:</label>
            <input type="email" id="remail">
        </form>
    </div>
    <div>
        <form class="registerElement">
            <label id="rpassword">Passwort eingeben:</label>
            <input type="password" id="rpassword">
        </form>
    </div>
    <div>
        <form class="registerElement">
            <label id="repassword">Passwort wiederholen:</label>
            <input type="password" id="repassword">
        </form>
    </div>
    <div>
        <form class="registerElement">
            <input type="submit" id="registerSubmit" value="Registrieren">
        </form>
    </div>
</section>
<link rel="stylesheet" type="text/css" href="../css/signIn.css">
</body>
</html>

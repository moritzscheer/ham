<?php include_once "../php/head.php" ?>

<body class="app">

<section class="register">
    <div class="registerElement">
        <label id="Hregister">Registrieren</label>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="rname">Name:</label>
            <input type="text" name="regName" id="rname">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="remail">E-Mail Adresse:</label>
            <input type="email" name="regMail" id="remail">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="rpassword">Passwort eingeben:</label>
            <input type="password" name="regPassword" id="rpassword">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="repassword">Passwort wiederholen:</label>
            <input type="password" name="reRegPassword" id="repassword">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post" action="../index.php">
            <input type="submit" id="registerSubmit" value="Registrieren" name="login">
        </form>
    </div>
</section>
<link rel="stylesheet" type="text/css" href="../css/signIn.css">
</body>
</html>

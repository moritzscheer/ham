<?php include_once "../php/head.php" ?>

<body class="app">
<div class="register">
    <div class="signIn">
        <form>
            <label id="Hregister">Registrieren</label>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="rname">Name:</label>
            <input type="text" id="rname">
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="remail">E-Mail Adresse:</label>
            <input type="email" id="remail">
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="rpassword">Passwort eingeben:</label>
            <input type="password" id="rpassword">
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="repassword">Passwort wiederholen:</label>
            <input type="password" id="repassword">
        </form>
    </div>
    <div class="signIn">
            <input type="submit" id="registerSubmit" value="Registrieren">
    </div>
</div>
<link rel="stylesheet" type="text/css" href="../css/signIn.css">
<link rel="stylesheet" type="text/css" href="../css/register.css">
</body>
</html>

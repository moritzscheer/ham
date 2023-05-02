<?php include_once "php/head.php" ?>

<body class="app">

<!-- require bei E-Mail und password, sodass die Felder ausfüllpflichtig ist -->

<div>
    <div class="signIn">
        <form>
            <label id="Hregister"><strong>Registrieren</strong></label>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="rname">Name:</label><br>
            <input type="text" id="rname"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="remail">E-Mail Adresse:</label><br>
            <input type="email" id="remail"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="rpassword">Passwort eingeben:</label><br>
            <input type="password" id="rpassword"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label id="repassword">Passwort wiederholen:</label><br>
            <input type="password" id="repassword"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <input type="submit" value="Registrieren">
        </form>
    </div>
</div>
</body>
</html>

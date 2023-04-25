<?php include_once "php/head.php" ?>

<body class="app">
<section>
    <div class="signIn">
        <form>
            <label id="Hregister"><h1>Registrieren</h1></label>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label for="rname">Name:</label><br>
            <input type="text" id="rname"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label for="remail">E-Mail Adresse:</label><br>
            <input type="email" id="remail"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label for="rpassword">Passwort eingeben:</label><br>
            <input type="password" id="rpassword"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <label for="repassword">Passwort wiederholen:</label><br>
            <input type="password" id="repassword"><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <input type="submit" value="Registrieren">
        </form>
    </div>
</section>
</body>
</html>

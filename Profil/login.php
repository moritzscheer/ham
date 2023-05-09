<?php include_once "../php/head.php" ?>

<body>
<section class="login">
    <div class="loginElement">
        <form>
            <label id="Hlogin">Login</label>
        </form>
    </div>
    <div class="loginElement">
        <form>
            <input type="email" id="lemail" placeholder="E-Mail adresse" required>
        </form>
    </div>
    <div class="loginElement">
        <form>
            <input type="password" id="lpassword" placeholder="Passwort" required>
        </form>
    </div>
    <div class="loginElement">
        <form>
            <input type="submit" id="loginSubmit" value="Login">
        </form>
    </div>
</section>
<link rel="stylesheet" type="text/css" href="../css/signIn.css">
<link rel="stylesheet" type="text/css" href="../css/login.css">
</body>
</html>

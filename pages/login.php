<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>


<section class="login">
    <div class="loginElement">
        <form method="post">
            <label id="Hlogin">Login</label>
        </form>
    </div>
    <div class="loginElement">
        <form method="post">
            <input type="email" id="lemail" name="logMail" placeholder="E-Mail adresse" required>
        </form>
    </div>
    <div class="loginElement">
        <form method="post">
            <input type="password" id="lpassword" name="logPassword" placeholder="Passwort" required>
        </form>
    </div>
    <div class="loginElement">
        <form method="post" action="index.php">
            <input type="submit" id="loginSubmit" name="login" value="Login">
        </form>
    </div>
</section>
<link rel="stylesheet" type="text/css" href="../resources/css/login.css">
</body>
</html>

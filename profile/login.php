<?php include_once "../php/head.php" ?>

<body>
<?php
    $logmail = (isset($_POST["logmail"]) && is_string($_POST["logmail"])) ? $_POST["logmail"] : "";
    $logpassword = (isset($_POST["logpassword"]) && is_string($_POST["logpassword"])) ? $_POST["logpassword"] : "";
    $logmail = htmlentities($_POST["logmail"]);
    $logpassword = htmlentities($_POST["logpassword"]);
?>

<section class="login">
    <div class="loginElement">
        <form method="post">
            <label id="Hlogin">Login</label>
        </form>
    </div>
    <div class="loginElement">
        <form method="post">
            <input type="email" id="lemail" name="logmail" placeholder="E-Mail adresse" required>
        </form>
    </div>
    <div class="loginElement">
        <form method="post">
            <input type="password" id="lpassword" name="logpassword" placeholder="Passwort" required>
        </form>
    </div>
    <div class="loginElement">
        <form method="post">
            <input type="submit" id="loginSubmit" name="logsubmit" value="Login">
        </form>
    </div>
</section>
<link rel="stylesheet" type="text/css" href="../css/signIn.css">
</body>
</html>

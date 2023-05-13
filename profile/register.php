<?php include_once "../php/head.php" ?>

<body class="app">
<?php
    $regname = (isset($_POST["regname"]) && is_string($_POST["regname"])) ? $_POST["regname"] : "";
    $regmail = (isset($_POST["regmail"]) && is_string($_POST["regmail"])) ? $_POST["regmail"] : "";
    $repassword = (isset($_POST["regpassword"]) && is_string($_POST["regpassword"])) ? $_POST["regpassword"] : "";
    $reregpassword = (isset($_POST["reregpassword"]) && is_string($_POST["reregpassword"])) ? $_POST["reregpassword"] : "";
    $regname = htmlentities($_POST["regname"]);
    $regmail = htmlentities($_POST["remail"]);
    $repassword = htmlentities($_POST["regpassword"]);
    $rereggmail = htmlentities($_POST["reregpassword"]);
?>

<section class="register">
    <div class="registerElement">
        <label id="Hregister">Registrieren</label>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="rname">Name:</label>
            <input type="text" name="regname" id="rname">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="remail">E-Mail Adresse:</label>
            <input type="email" name="regmail" id="remail">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="rpassword">Passwort eingeben:</label>
            <input type="password" name="regpassword" id="rpassword">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post">
            <label id="repassword">Passwort wiederholen:</label>
            <input type="password" name="reregpassword" id="repassword">
        </form>
    </div>
    <div>
        <form class="registerElement" method="post">
            <input type="submit" id="registerSubmit" value="Registrieren">
        </form>
    </div>
</section>
<link rel="stylesheet" type="text/css" href="../css/signIn.css">
</body>
</html>

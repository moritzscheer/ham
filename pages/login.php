<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

<section class="login-view">
    <div class="login-container">
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
        <div class="loginElement staylogin">
            <form method="post">
                <label class="staylogin-container">
                    <span id="stayLogin-Text">Stay Logged In</span>
                    <input type="checkbox" id="stayLogin-checkbox" name="login">
                    <span id="stayLogin-checkmark"></span>
                </label>
            </form>
        </div>
        <div class="loginElement">
            <form method="post" action="index.php">
                <input type="submit" id="loginSubmit" name="login" value="Login">
            </form>
        </div>
        <div class="loginElement">
            <span id="noAccountText">No Account yet ?</span>
        </div>
        <div class="loginElement">
            <form action="register.php">
                <input type="submit" id="registerSubmit" value="Register">
            </form>
        </div>
    </div>
</section>
</body>
</html>

<?php
    global $error_message;
    include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>
<section class="login-view">
    <form method="post" class="login-container">
        <div class="loginElement">
            <label id="Hlogin">Login</label>
        </div>
        <?php echo $error_message ?>
        <div class="loginElement">
            <input type="email" id="lemail" name="email" placeholder="E-Mail adresse" required>
        </div>
        <div class="loginElement">
            <input type="password" id="lpassword" name="password" placeholder="Passwort" required>
        </div>
        <div class="loginElement staylogin">
            <label class="staylogin-container">
                <span id="stayLogin-Text">Stay Logged In</span>
                <input type="checkbox" id="stayLogin-checkbox" name="login">
                <span id="stayLogin-checkmark"></span>
            </label>
        </div>
        <div class="loginElement">
            <input type="submit" id="loginSubmit" name="login" value="Login">
        </div>
        <div class="loginElement">
            <span id="noAccountText">No Account yet ?</span>
        </div>
        <div class="loginElement">
            <a href="register.php" id="registerSubmit">Register</a>
        </div>
    </form>

</section>
<?php include "../php/navigation/footer/footer.php" ?>
</body>
</html>

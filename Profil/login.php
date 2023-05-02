<?php include_once "../php/head.php" ?>

<body>
<div class="login">
    <div class="signIn">
        <form>
            <label id="Hlogin"><strong>Login</strong></label><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <input type="email" id="lemail" placeholder="E-Mail adresse" required><br><br>
        </form>
    </div>
    <div >
        <form class="signIn">
            <input type="password" id="lpassword" placeholder="Passwort" required><br><br>
        </form>
    </div>
    <div class="signIn">
        <form>
            <input type="submit" id="loginSubmit" value="Login">
        </form>
    </div>
</div>
</body>

<style>

    body {
        display: grid;
    }
    /*login elements in general*/
    .signIn {
        color: black;
    }

    .login {
        /* -webkit-background-clip: border-box;*/
        display: grid;
        place-items: center;
        width: 300px;
        background-color: #7ce2ff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 4px;
    }

    #Hlogin {
        padding: 10px 10px;
        height: 50px;
    }

    input {
        border: transparent;
    }

    input[type=email], input[type=password] {
        background-color: #d9d9d9;
        border: 0px solid;
        padding-left: 10px;
        margin: 5px 5px 5px 5px;
        height: 30px;
        border-radius: 4px;
        position: relative;
        outline: none;
    }

    #loginSubmit {
        color: white;
        text-shadow: black;
        border-radius: 4px;
        height: 30px;
        width:  180px;
        background-image: linear-gradient(to right bottom, #1ecf25, #22d939, #26e24a, #29ec5b, #2df66a);
    }
</style>
</html>

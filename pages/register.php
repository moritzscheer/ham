<?php
    global $step, $step1, $step2, $step3, $step4;

    // initial variables
    $step1 = "hidden";
    $step2 = "hidden";
    $step3 = "hidden";
    $step4 = "hidden";

    $_SESSION["progress2"] = "inActive";
    $_SESSION["progress3"] = "inActive";
    $_SESSION["progress4"] = "inActive";

    $step = (isset($_GET["step"]) && is_string($_GET["step"])) ? $_GET["step"] : "1";;

    $urlNext = $_SERVER["PHP_SELF"] . "?step=" . $step++;
    $urlLast = $_SERVER["PHP_SELF"] . "?step=" . $step--;



    // resets sign in page
    if(isset($_POST["reset"])) {
        unset($_SESSION["step"]);
    }

    if(!isset($_POST["cancel"])) {
        // use Session variable if exits
        if(isset($_SESSION["step"])) {
            $step = $_SESSION["step"];
        }

        // different states depending on the $step
        if($step == 1) {
            $step1 = "visible";
        } elseif ($step == 2) {
            $step2 = "visible";
            $_SESSION["progress2"] = "active";
        }  elseif ($step == 3) {
            $step3 = "visible";
            $_SESSION["progress2"] = "active";
            $_SESSION["progress3"] = "active";
        } elseif($step == 4) {
            $step4 = "visible";
            $_SESSION["progress2"] = "active";
            $_SESSION["progress3"] = "active";
            $_SESSION["progress4"] = "active";

            // todo set session or cookie timer
            if (isset($_POST["yes"])) {
                unset($_SESSION["step"]);
            } elseif (isset($_POST["no"])) {
                unset($_SESSION["step"]);
            }
        }
    }


    include_once "../php/head/head.php"
?>
<link rel="stylesheet" type="text/css" href="../resources/css/register.css">
</head>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

<section class="register">
    <ul class="progressBar">
        <li id="progressBar-Step" class="active">
            <h4>E-Mail and<br>Password</h4>
        </li>
        <li id="progressBar-Step" class="<?php echo $_SESSION["progress2"]?> ">
            <h4>Personal<br>Data</h4>
        </li>
        <li id="progressBar-Step" class="<?php echo $_SESSION["progress3"]?> ">
            <h4>More<br>Information</h4>
        </li>
        <li id="progressBar-Step" class="<?php echo $_SESSION["progress4"]?> ">
            <h4>Stay<br>Logged In</h4>
        </li>
    </ul>

    <form method="post" action="index.php" class="progressBar-Content">

        <div class="<?php echo $step1; ?>">
            <label class="entry">E-Mail address:
                <input type="email" name="email" id="email" >
            </label>

            <label class="entry">Enter Password:
                <input type="password" name="password" id="password" >
            </label>

            <label class="entry">Repeat Password:
                <input type="password" name="rePassword" id="repeatPassword" >
            </label>

            <div>
                <input type="submit" value="cancel" name="cancel">
                <a href="<?php echo $urlNext; ?>">Next Step</a>
            </div>
        </div>



        <div class="<?php echo $step2; ?>">
            <label class="entry">Name:
                <input type="text" name="name" id="name" >
            </label>

            <label class="entry">Surname:
                <input type="text" name="surname" id="surname" >
            </label>

            <label class="entry">Address:
                <input type="text" name="address" id="address">
            </label>

            <label class="entry">Phone Number:
                <input type="tel" name="phoneNumber" id="phoneNumber" dr>
            </label>

            <div>
                <a href="<?php echo $urlLast; ?>">Last Step</a>
                <a href="<?php echo $urlNext; ?>">Next Step</a>
            </div>
        </div>



        <div class="<?php echo $step3; ?>">
            <label class="entry">Type:
                <div id="type">
                    <label>Musician
                        <input type="radio" name="type" value="musician" >
                    </label>
                    <label>Host
                        <input type="radio" name="type" value="host" >
                    </label>
                </div>
            </label>

            <label class="entry">Genre:
                <input type="text" name="genre" value="rock">
            </label>

            <label class="entry">Members:
                <input type="text" name="members" value="Holger, Artur, Moritz">
            </label>

            <label class="entry">Other Remarks:
                <textarea name="otherRemarks" rows="5">nothing more</textarea>
            </label>

            <div>
                <a href="<?php echo $urlLast; ?>">Last Step</a>
                <a href="<?php echo $urlNext; ?>">Next Step</a>
            </div>
        </div>



        <div class="<?php echo $step4; ?>">
            <div>
                <p><?php echo $_SESSION["email"] ?></p>
                <p>Stay Logged In?</p>
            </div>

            <div>
                <input type="submit" id="" value="No" name="login">
                <input type="submit" id="" value="Yes" name="login">
            </div>
        </div>

    </form>
</section>
<p>
    $step variable:<?php echo $step ?><br>
    $_SESSION["step"] variable:<?php echo $_SESSION["step"] ?><br>
</p>
<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

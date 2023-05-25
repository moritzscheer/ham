<?php global $step, $step1, $step2, $step3, $step4, $steps1To3;
include_once "../php/head/head.php" ?>
<link rel="stylesheet" type="text/css" href="../resources/css/register.css">
</head>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

<section class="register">
    <ul class="progressBar">
        <li id="progressBar-Step" class="active">
            <h4>E-Mail and<br>Password</h4>
        </li>
        <li id="progressBar-Step" class="<?php echo $_SESSION["progress2"]?>">
            <h4>Personal<br>Data</h4>
        </li>
        <li id="progressBar-Step" class="<?php echo $_SESSION["progress3"]?>">
            <h4>More<br>Information</h4>
        </li>
        <li id="progressBar-Step" class="<?php echo $_SESSION["progress4"]?>">
            <h4>Stay<br>Logged In</h4>
        </li>
    </ul>

    <form method="post" action="register.php" class="progressBar-Content <?php echo $_SESSION["step1To3"]; ?>">
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
        </div>

        <div>
            <input type="submit" value="<?php echo $_SESSION["button1"]; ?>" name="nextStep">
        </div>
    </form>

    <form method="post" action="index.php" class="progressBar-Content <?php echo $step4; ?>">
        <div>
            <p><?php echo $_SESSION["email"] ?></p>
            <p>Stay Logged In?</p>
        </div>
        
        <div>
            <input type="submit" id="" value="No" name="login">
            <input type="submit" id="" value="Yes" name="login">
        </div>
    </form>
</section>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>

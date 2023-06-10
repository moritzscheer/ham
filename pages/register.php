<?php
    global $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $error_message, $progressBar;
    include_once "../php/register/progressBar.php";
    include_once "../php/head/head.php";
?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <section class="register">

        <ul id="progressBar" class="<?php echo $progressBar ?>">
            <li id="progressBar-Step" class="active step1">
                <h4>Personal<br>Data</h4>
            </li>
            <li id="progressBar-Step" class="step2 <?php echo $progress_2 ?> ">
                <h4>More<br>Information</h4>
            </li>
            <li id="progressBar-Step" class="step3 <?php echo $progress_3 ?> ">
                <h4>E-Mail and<br>Password</h4>
            </li>
        </ul>

        <div class="progressBar-Content">
            <h1>Register</h1>
            
            <p class="<?php echo $progressBar ?>"><?php echo $error_message ?></p>

            <form method="post" action="<?php echo getNextUrl($step) ?>" id="<?php echo $step_1 ?>">
                <label id="input-entry" class="entry">* Name:
                    <input type="text" value="<?php echo $_SESSION["user"]->getName() ?>" name="name" required>
                </label>

                <label id="input-entry" class="entry">* Surname:
                    <input type="text" value="<?php echo $_SESSION["user"]->getSurname() ?>" name="surname" required>
                </label>

                <label id="input-entry" class="entry">Phone Number:
                    <input type="tel" value="<?php echo $_SESSION["user"]->getPhoneNumber() ?>" name="phone_number">
                </label>

                <div id="split">
                    <label id="input-entry" class="entry">Street:
                        <input type="text" name="street_name" value="<?php echo $_SESSION["address"]->getStreetName() ?>">
                    </label>
                    <label id="input-entry" class="entry">House Number:
                        <input type="text" name="house_number" value="<?php echo $_SESSION["address"]->getHouseNumber() ?>">
                    </label>
                </div>

                <div id="split">
                    <label id="input-entry" class="entry">City:
                        <input type="text" name="city" value="<?php echo $_SESSION["address"]->getCity() ?>">
                    </label>
                    <label id="input-entry" class="entry">Postal Code:
                        <input type="text" name="postal_code" value="<?php echo $_SESSION["address"]->getPostalCode() ?>">
                    </label>
                </div>

                <div class="submit">
                    <a href="index.php">Cancel</a>
                    <input type="submit" value="Next Step">
                </div>
            </form>


            <form method="post" action="<?php echo getNextUrl($step) ?>" id="<?php echo $step_2 ?>">
                <div id="type-entry" class="entry">* Type:
                    <div class="type">
                        <label>Musician
                            <input type="radio" name="type" value="Musician" required>
                        </label>
                        <label>Host
                            <input type="radio" name="type" value="Host" required>
                        </label>
                    </div>
                </div>

                <label id="input-entry" class="entry">Genre:
                    <input type="text" value="<?php echo $_SESSION["user"]->getGenre() ?>" name="genre">
                </label>

                <label id="input-entry" class="entry">Members:
                    <input type="text" value="<?php echo $_SESSION["user"]->getMembers() ?>" name="members">
                </label>

                <label id="input-entry" class="entry">Other Remarks:
                    <textarea value="<?php echo $_SESSION["user"]->getOtherRemarks() ?>" name="other_remarks" rows="5"></textarea>
                </label>

                <div class="submit">
                    <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                    <input type="submit" value="Next Step">
                </div>
            </form>

            <form method="post" id="<?php echo $step_3 ?>">
                <label id="input-entry" class="entry">* E-Mail address:
                    <input type="email" name="email">
                </label>

                <label id="input-entry" class="entry">* Enter Password:
                    <input type="password" name="password">
                </label>

                <label id="input-entry" class="entry">* Repeat Password:
                    <input type="password" name="repeat_password"required>
                </label>

                <div class="submit">
                    <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                    <input id="registerSubmit" type="submit" value="Finish" name="register">
                </div>
            </form>

            <form method="post" action="index.php" id="<?php echo $step_4 ?>" class="lastStep">
                <div>
                    <p><?php echo $_SESSION["user"]->getName() . " " . $_SESSION["user"]->getSurname() ?></p>
                    <p><?php echo $_SESSION["user"]->getEmail() ?></p>
                </div>
                
                <label>Stay Logged In?
                    <input type="checkbox" id="stayLoggedIn" name="stayLoggedIn">
                </label>

                <div id="buttons">
                    <input type="submit" value="Ok">
                </div>
            </form>
        </div>
    </section>

<?php include "../php/navigation/footer/footer.php" ?>
</body>
</html>

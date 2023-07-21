<?php
    namespace php\controller;
    global $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $error_message, $progressBar;
    include_once "../php/controller/progressBar_controller.php";
    include_once "../php/includes/head/head.php"
?>
<body>
<?php include_once "../php/includes/navigation/header/header.php" ?>

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

        <p id="error-message" class="<?php echo $progressBar ?>"><?php echo $error_message ?></p>

        <form method="post" id="<?php echo $step_1 ?>">
            <h1>Personal Data</h1>
            
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
                    <input type="text" name="user_street_name" value="<?php echo $_SESSION["user"]->getStreetName() ?>">
                </label>
                <label id="input-entry" class="entry">House Number:
                    <input type="text" name="user_house_number"
                           value="<?php echo $_SESSION["user"]->getHouseNumber() ?>">
                </label>
            </div>

            <div id="split">
                <label id="input-entry" class="entry">City:
                    <input type="text" name="user_city" value="<?php echo $_SESSION["user"]->getCity() ?>">
                </label>
                <label id="input-entry" class="entry">Postal Code:
                    <input type="text" name="user_postal_code" value="<?php echo $_SESSION["user"]->getPostalCode() ?>">
                </label>
            </div>

            <div class="submit">
                <a href="index.php">Cancel</a>
                <label>Next Step
                    <input type="submit" name="check_address">
                </label>
            </div>
        </form>


        <form method="post" action="<?php echo getNextUrl($step) ?>" id="<?php echo $step_2 ?>">
            <h1>More Information</h1>

            <fieldset>
                <legend>Type:</legend>
                <div id="type-entry" class="entry">
                    <label>Musician
                        <input type="radio" name="type" value="Musician" required>
                    </label>
                    <label>Host
                        <input type="radio" name="type" value="Host" required>
                    </label>
                </div>
            </fieldset>

            <label id="input-entry" class="entry">Genre:
                <input type="text" value="<?php echo $_SESSION["user"]->getGenre() ?>" name="genre">
            </label>

            <label id="input-entry" class="entry">Members:
                <input type="text" value="<?php echo $_SESSION["user"]->getMembers() ?>" name="members">
            </label>

            <label id="input-entry" class="entry">Other Remarks:
                <textarea value="<?php echo $_SESSION["user"]->getOtherRemarks() ?>" name="other_remarks"
                          rows="5"></textarea>
            </label>

            <div class="submit">
                <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                <label>Next Step
                    <input type="submit">
                </label>
            </div>
        </form>

        <form method="post" id="<?php echo $step_3 ?>">
            <h1>Email and Password</h1>

            <label id="input-entry" class="entry">* E-Mail address:
                <input type="email" name="email">
            </label>

            <label id="input-entry" class="entry">* Enter Password:
                <input type="password" name="password">
            </label>

            <label id="input-entry" class="entry">* Repeat Password:
                <input type="password" name="repeat_password" required>
            </label>

            <label id="agreementField">*
                <input type="checkbox" id="agreementCheck" name="dsr" value="y" required>
                <div id="agreementText"> I agree with the <a id="agreementLinks" href="impressum.php" target="_blank" rel="noopener noreferrer">Legal Disclosure</a>, <a id="agreementLinks" href="nutzungsbedingungen.php" target="_blank" rel="noopener noreferrer">Terms
                        of Use</a> and the <a id="agreementLinks" href="datenschutz.php" target="_blank" rel="noopener noreferrer">Privacy Policy</a></div>
            </label>

            <div class="submit">
                <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                <label>Finish
                    <input type="submit" name="register" id="registerSubmit">
                </label>
            </div>
        </form>

        <form method="post" action="index.php" id="<?php echo $step_4 ?>" class="lastStep">
            <h1 id="success_message"><?php echo $_SESSION["success_message"] ?></h1>

            <div>
                <p><?php echo $_SESSION["loggedIn"]["user"]->getName() . " " . $_SESSION["loggedIn"]["user"]->getSurname() ?></p>
                <p><?php echo $_SESSION["loggedIn"]["user"]->getEmail() ?></p>
            </div>

            <label>Stay Logged In?
                <input type="checkbox" id="stayLoggedIn" name="stayLoggedIn">
            </label>

            <div class="submit">
                <label>Ok
                    <input type="submit">
                </label>
            </div>
        </form>
    </div>
</section>

<?php include "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>

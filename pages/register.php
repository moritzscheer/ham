<?php
    global $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $error_message, $progressBar;
    include_once "../php/register/progressBar.php";
    include_once "../php/head/head.php";
?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <section class="register">

        <ul id="progressBar" class="<?php echo $progressBar ?>">
            <li id="progressBar-Step" class="active">
                <h4>Personal<br>Data</h4>
            </li>
            <li id="progressBar-Step" class=" <?php echo $progress_2 ?> ">
                <h4>More<br>Information</h4>
            </li>
            <li id="progressBar-Step" class=" <?php echo $progress_3 ?> ">
                <h4>E-Mail and<br>Password</h4>
            </li>
        </ul>


        <p class="<?php echo $progressBar ?>"><?php echo $error_message ?></p>

        <form method="post" action="<?php echo getNextUrl($step) ?>" id="<?php echo $step_1 ?>" class="progressBar-Content">
            <label class="entry">* Name:
                <input type="text" value="<?php echo $_SESSION["user"]->getName() ?>" name="name" required>
            </label>

            <label class="entry">* Surname:
                <input type="text" value="<?php echo $_SESSION["user"]->getSurname() ?>" name="surname" required>
            </label>

            <label class="entry">Street:
                <input type="text" value="<?php echo $_SESSION["address"]->getStreetName() ?>" name="street_name">
            </label>

            <label class="entry">House Number:
                <input type="text" value="<?php echo $_SESSION["address"]->getHouseNumber() ?>" name="house_number">
            </label>

            <label class="entry">Postal Code:
                <input type="text" value="<?php echo $_SESSION["address"]->getPostalCode() ?>" name="postal_code">
            </label>

            <label class="entry">City:
                <input type="text" value="<?php echo $_SESSION["address"]->getCity() ?>" name="city">
            </label>

            <label class="entry">Phone Number:
                <input type="tel" value="<?php echo $_SESSION["user"]->getPhoneNumber() ?>" name="phone_number">
            </label>

            <div class="submit">
                <a href="index.php">Cancel</a>
                <input type="submit" value="Next Step">
            </div>
        </form>


        <form method="post" action="<?php echo getNextUrl($step) ?>" id="<?php echo $step_2 ?>" class="progressBar-Content">
            <label class="entry">* Type:
                <div class="type">
                    <label>Musician
                        <input type="radio" name="type" value="Musician" required>
                    </label>
                    <label>Host
                        <input type="radio" name="type" value="Host" required>
                    </label>
                </div>
            </label>

            <label class="entry">Genre:
                <input type="text" value="<?php echo $_SESSION["user"]->getGenre() ?>" name="genre">
            </label>

            <label class="entry">Members:
                <input type="text" value="<?php echo $_SESSION["user"]->getMembers() ?>" name="members">
            </label>

            <label class="entry">Other Remarks:
                <textarea value="<?php echo $_SESSION["user"]->getOtherRemarks() ?>" name="other_remarks" rows="5"></textarea>
            </label>

            <div class="submit">
                <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                <input type="submit" value="Next Step">
            </div>
        </form>

        <form method="post" id="<?php echo $step_3 ?>" class="progressBar-Content">
            <label class="entry">* E-Mail address:
                <input type="email" name="email">
            </label>

            <label class="entry">* Enter Password:
                <input type="password" name="password">
            </label>

            <label class="entry">* Repeat Password:
                <input type="password" name="repeat_password"required>
            </label>

            <div class="submit">
                <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                <input type="submit" value="Finish" name="register">
            </div>
        </form>

        <form method="post" action="index.php" id="<?php echo $step_4 ?>" class="progressBar-Content lastStep">
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
    </section>
<?php echo var_dump($_SESSION["user"]) ?><br><br>
<?php echo var_dump($_SESSION["address"]) ?><br><br>
<?php echo var_dump($_SESSION["findArray"]) ?><br><br>


<?php include "../php/navigation/footer/footer.php" ?>
</body>
</html>

<?php
    global $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $error_message;
    include_once "../php/progressBar.php";
    include_once "../php/head/head.php";
?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <section class="register">

        <ul class="progressBar">
            <li id="progressBar-Step" class="active">
                <h4>E-Mail and<br>Password</h4>
            </li>
            <li id="progressBar-Step" class=" <?php echo $progress_2 ?> ">
                <h4>Personal<br>Data</h4>
            </li>
            <li id="progressBar-Step" class=" <?php echo $progress_3 ?> ">
                <h4>More<br>Information</h4>
            </li>
        </ul>



        <form method="post" id="<?php echo $step_1 ?>" class="progressBar-Content">
            <?php echo $error_message ?>
            <label class="entry">* E-Mail address:
                <input type="email" value="<?php echo $_SESSION["email"] ?>" name="email" id="email" required>
            </label>

            <label class="entry">* Enter Password:
                <input type="password" value="<?php echo $_SESSION["password"] ?>" name="password" id="password" required>
            </label>

            <label class="entry">* Repeat Password:
                <input type="password" value="<?php echo $_SESSION["repeatPassword"] ?>" name="repeatPassword" id="repeatPassword" required>
            </label>

            <div class="submit">
                <a href="index.php">Cancel</a>
                <input type="submit" value="Next Step" name="register">
            </div>
        </form>


        <form method="post" action="<?php echo getNextUrl($step) ?>" id="<?php echo $step_2 ?>" class="progressBar-Content">
            <label class="entry">* Name:
                <input type="text" value="<?php echo $_SESSION["name"] ?>" name="name" id="name" required>
            </label>

            <label class="entry">* Surname:
                <input type="text" value="<?php echo $_SESSION["surname"] ?>" name="surname" id="surname" required>
            </label>

            <label class="entry">Address:
                <input type="text" value="<?php echo $_SESSION["address"] ?>" name="address" id="address">
            </label>

            <label class="entry">Phone Number:
                <input type="tel" value="<?php echo $_SESSION["phoneNumber"] ?>" name="phoneNumber" id="phoneNumber">
            </label>

            <div class="submit">
                <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                <input type="submit" value="Next Step">
            </div>
        </form>


        <form method="post" action="<?php echo getNextUrl($step) ?>" id="<?php echo $step_3 ?>" class="progressBar-Content">
            <label class="entry">* Type:
                <div id="type">
                    <label>Musician
                        <input type="radio" name="type" value="musician" required>
                    </label>
                    <label>Host
                        <input type="radio" name="type" value="host" required>
                    </label>
                </div>
            </label>

            <label class="entry">Genre:
                <input type="text" name="genre">
            </label>

            <label class="entry">Members:
                <input type="text" name="members">
            </label>

            <label class="entry">Other Remarks:
                <textarea name="otherRemarks" rows="5"></textarea>
            </label>

            <div class="submit">
                <a href="<?php echo getLastUrl($step) ?>">Last Step</a>
                <input type="submit" value="Next Step">
            </div>
        </form>


        <form method="post" action="index.php" id="<?php echo $step_4 ?>" class="progressBar-Content lastStep">
            <div>
                <p><?php echo $_SESSION["name"] . " " . $_SESSION["surname"] ?></p>
                <p><?php echo $_SESSION["email"] ?></p>
            </div>
            <label>Stay Logged In?
                <input type="checkbox" id="stayLoggedIn" name="login">
            </label>
            <div id="buttons">
                <input type="submit" id="" value="Done" name="login">
            </div>
        </form>
    </section>

<?php include "../php/navigation/footer/footer.php" ?>
</body>
</html>

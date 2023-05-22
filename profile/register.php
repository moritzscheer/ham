<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1 >Sign Up</h1>

    <section class="register">
        <ul class="progressBar">
            <li id="progressBar-Step" class="active">
                <h4>E-Mail and<br>Password</h4>
            </li>
            <li id="progressBar-Step" class="<?php echo $_SESSION["status2"]?>">
                <h4>Personal<br>Data</h4>
            </li>
            <li id="progressBar-Step" class="<?php echo $_SESSION["status3"]?>">
                <h4>More<br>Information</h4>
            </li>
        </ul>
        <?php include_once "../profile/form/Form_1.php" ?>
        <?php include_once "../profile/form/Form_2.php" ?>
        <?php include_once "../profile/form/Form_3.php" ?>
    </section>
</body>
</html>

<?php include_once "../php/head.php" ?>
<body class="app">
<?php include_once "../php/header.php" ?>

    <h1>Sign Up</h1>

    <section class="register">
        <ul class="progressBar">
            <li id="progressBar-Step" class="active">
                <h2>E-Mail and Password</h2>
            </li>
            <li id="progressBar-Step" class="<?php echo $_SESSION["status2"]?>">
                <h2>Personal Data</h2>
            </li>
            <li id="progressBar-Step" class="<?php echo $_SESSION["status3"]?>">
                <h2>More Information</h2>
            </li>
        </ul>
        <?php include_once "../profile/form/Form_1.php" ?>
        <?php include_once "../profile/form/Form_2.php" ?>
        <?php include_once "../profile/form/Form_3.php" ?>
    </section>
<link rel="stylesheet" type="text/css" href="../css/signIn.css">
</body>
</html>

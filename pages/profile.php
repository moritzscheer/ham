<?php include_once "../php/head.php" ?>
<link rel="stylesheet" type="text/css" href="../resources/css/profile.css">
</head>
<body>
<?php include_once "../php/header.php" ?>

    <h1 >profile</h1>

    <section class="profile-Grid">
        <!-- account navigation -->
        <div class="profile-Navigation">
            <div class="profile-Picture-Box">
                <img src="../resources/images/profile/custom.jpg" alt="profile picture" height="120" width="120" class="profile-Picture">
            </div>
            <?php include_once "../profile/profileNavigation.php" ?>
        </div>


        <!-- account information -->
        <div class="profile-Content">
            <label class="entry">Name:
                <label><?php echo $_SESSION["name"]; ?></label>
            </label>

            <label class="entry">Surname:
                <label><?php echo $_SESSION["surname"]; ?></label>
            </label>

            <label class="entry">E-Mail:
                <label><?php echo $_SESSION["email"]; ?></label>
            </label class="entry">

            <label class="entry">Phone Number:
                <label><?php echo $_SESSION["phoneNumber"]; ?></label>
            </label>

            <label class="entry">Type:
                <label><?php echo $_SESSION["type"]; ?></label>
            </label>

            <label class="entry">Genre:
                <label><?php echo $_SESSION["genre"]; ?></label>
            </label>

            <label class="entry">Members:
                <label><?php echo $_SESSION["members"]; ?></label>
            </label>

            <label class="entry">Other Remarks:
                <label><?php echo $_SESSION["otherRemarks"]; ?></label><br>
            </label>
        </div>
    </section>


<?php include_once "../php/footer.php" ?>
</body>
</html>

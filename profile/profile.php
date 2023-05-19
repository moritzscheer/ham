<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1 >profile</h1>

    <div class="profile-Grid">
        <!-- account navigation -->
        <div class="profile-Navigation">
            <div class="profile-Picture-Box">
                <img src="../images/profile/custom.jpg" alt="profile picture" height="120" width="120" class="profile-Picture">
            </div>
            <?php include_once "../profile/profilNavigation.php" ?>
        </div>


        <!-- account information -->
        <div class="profile-Content">
            <label class="entry">Name:
                <label><?php echo $_POST["name"]; ?></label>
            </label>

            <label class="entry">Surname:
                <label><?php echo $_POST["surname"]; ?></label>
            </label>

            <label class="entry">E-Mail:
                <label><?php echo $_POST["email"]; ?></label>
            </label class="entry">

            <label class="entry">Phone Number:
                <label><?php echo $_POST["phoneNumber"]; ?></label>
            </label>

            <label class="entry">Type:
                <label><?php echo $_POST["type"]; ?></label>
            </label>

            <label class="entry">Genre:
                <label><?php echo $_POST["genre"]; ?></label>
            </label>

            <label class="entry">Members:
                <label><?php echo $_POST["members"]; ?></label>
            </label>

            <label class="entry">Other Remarks:
                <label><?php echo $_POST["otherRemarks"]; ?></label><br>
            </label>
        </div>
    </div>


<?php include_once "../php/footer.php" ?>
</body>
</html>

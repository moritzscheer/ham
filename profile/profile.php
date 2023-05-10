<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1 >profile</h1>

    <div class="profile-outer-Grid">
        <div class="profile-inner-Grid">

            <!-- account navigation -->
            <div class="profileNavigation">
                <div class="profilePicture-Box">
                    <img src="../images/profilePicture.jpg" alt="profile picture" height="120" width="120" class="profilePicture">
                </div>
                <?php include_once "../profile/profilNavigation.php" ?>
            </div>


            <!-- account information -->
            <div class="profile-Content-Grid">
                <div class="profile-Content">
                    <label class="entry">Name:
                        <label id="Max">Max</label>
                    </label>

                    <label class="entry">Surname:
                        <label id="nachname">Mustermann</label>
                    </label>

                    <label class="entry">E-Mail:
                        <label id="email">max.mustermann@uni-oldenburg.de</label>
                    </label class="entry">

                    <label class="entry">Phone Number:
                        <label id="nummer">0176 123456789</label>
                    </label>

                    <label class="entry">Type:
                        <label id="typ">musician</label>
                    </label>

                    <label class="entry">Genre:
                        <label id="genre">rock</label>
                    </label>

                    <label class="entry">Members:
                        <label id="mitglieder">Holger, Artur, Moritz</label>
                    </label>

                    <label class="entry">Other Remarks:
                        <label id="more">nothing more</label><br>
                    </label>
                </div>
            </div>
        </div>
    </div>


<?php include_once "../php/footer.php" ?>
</body>
</html>

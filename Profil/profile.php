<?php include_once "../php/head.php" ?>
<body>
<?php include_once "../php/header.php" ?>

    <h1 >profile</h1>

    <div class="profileGrid">

        <!-- account navigation -->
        <div  class="profileNavBox">
            <div class="profilePictureBox">
                <img src="../images/profilePicture.jpg" alt="profile picture" height="120" width="120" class="profilePicture">
            </div>
            <?php include_once "../Profil/profilNavigation.php" ?>
        </div>


        <!-- account information -->
        <div class="profileContent">
            <label class="entry">Name:
                <label id="Max">Max</label><br>
            </label>

            <label class="entry">Surname:
                <label id="nachname">Mustermann</label><br>
            </label>

            <label class="entry">E-Mail:
                <label id="email">max.mustermann@uni-oldenburg.de</label><br>
            </label class="entry">

            <label class="entry">Phone Number:
                <label id="nummer">0176 123456789</label><br>
            </label>

            <label class="entry">Type:
                <label id="typ">musician</label><br>
            </label>

            <label class="entry">Genre:
                <label id="genre">rock</label><br>
            </label>

            <label class="entry">Members:
                <label id="mitglieder">Holger, Artur, Moritz</label><br>
            </label>

            <label class="entry">Other Remarks:
                <label id="more">nothing more</label><br><br>
            </label>
        </div>
    </div>

<?php include_once "../php/footer.php" ?>
</body>
</html>

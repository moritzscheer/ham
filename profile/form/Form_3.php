<form method="post" action="../index.php" class="progressBar-Content <?php echo $_SESSION["Step3"] ?>">
    <label class="entry">Type:
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
        <input type="text" name="genre" value="rock">
    </label>

    <label class="entry">Members:
        <input type="text" name="members" value="Holger, Artur, Moritz">
    </label>

    <label class="entry">Other Remarks:
        <textarea name="otherRemarks" rows="5">nothing more</textarea>
    </label>

    <input type="submit" id="register-Submit-Button" value="Finish" name="login">
</form>
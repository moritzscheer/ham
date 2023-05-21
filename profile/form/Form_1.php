<form method="post" class="progressBar-Content <?php echo $_SESSION["Step1"]?>">
    <label class="entry">E-Mail address:
        <input type="email" name="email" id="email" required>
    </label>

    <label class="entry">Enter Password:
        <input type="password" name="password" id="password" required>
    </label>

    <label class="entry">Repeat Password:
        <input type="password" name="rePassword" id="repeatPassword" required>
    </label>

    <input type="submit" id="register-Submit-Button" value="continue" name="toStep2">
</form>
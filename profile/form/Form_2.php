<form method="post"  id="<?php echo $_SESSION["Step2"]?>" class="progressBar-Content">
    <label class="entry">Name:
        <input type="text" name="name" id="name" required>
    </label>

    <label class="entry">Surname:
        <input type="text" name="surname" id="surname" required>
    </label>

    <label class="entry">Address:
        <input type="text" name="address" id="address">
    </label>

    <label class="entry">Phone Number:
        <input type="tel" name="phoneNumber" id="phoneNumber" dr>
    </label>

    <input type="submit" id="register-Submit-Button" value="continue" name="toStep3">
</form>

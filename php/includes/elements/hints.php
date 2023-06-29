<form method="post" id="<?php echo $_SESSION["hintField"]["visibility"] ?>" class="hint">
    <span><?php echo $_SESSION["hintField"]["message"] ?></span>
    <div id="hint_buttons">
        <label>Close
            <input type="submit" name="show_hint">
        </label>
    </div>
</form>
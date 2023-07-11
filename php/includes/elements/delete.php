<section id="delete_grid" class="<?php echo $_SESSION["delete"] ?>">
    <form method="post" class="col1">
        <label>
            <input type="submit" name="onDeleteClicked">
        </label>
    </form>
    <form method="post" class="col3">
        <label>
            <input type="submit" name="onDeleteClicked">
        </label>
    </form>
    <form method="post" class="row1">
        <label>
            <input type="submit" name="onDeleteClicked">
        </label>
    </form>
    <form method="post" class="row3">
        <label>
            <input type="submit" name="onDeleteClicked">
        </label>
    </form>
    <form method="post" id="delete">
        <span>Are you Sure you want to delete your Account?</span>
        <span>All your Information will be deleted.</span>
        <div id="profile_submit">
            <label>No
                <input type="submit" name="onDeleteClicked" value="hide">
            </label>
            <label>Yes
                <input type="submit" name="delete">
            </label>
        </div>
    </form>
</section>
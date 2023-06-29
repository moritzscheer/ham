<?php global $error_message ?>
<section id="select_image_box" class="<?php echo $_SESSION["ImageBox"] ?>">
    <form method="post" id="select_image_box_header">
        <label>X
            <input type="submit" name="onEditImage" value="hide">
        </label>
    </form>
    <div id="select_image_box_content">
        <form method="post" id="flickr_search">
            <input type="search" name="flickr_search" placeholder="search" >
            <label>Search
                <input type="submit" id="submit_flickr_search" placeholder="search" >
            </label>
        </form>
        <form method="post" id="flickr_images">
            <?php echo $_SESSION["flickr_search"] ?>
        </form>
        <div id="profile_picture_preview">
            <img src="<?php echo $_SESSION["profile_preview"]["source"] ?>" alt="no image selected!">
        </div>
        <div id="flickr_buttons">
            <form method="post" enctype="multipart/form-data">
                <?php echo $error_message ?>
                <label id="select_own">Select your Image
                    <input type="file" accept=".jpg, .png, .jpeg" name="upload_image">
                </label>
                <label id="submit_own" >upload
                    <input type="submit" name="upload_image" value="upload_image">
                </label>
            </form>
            <form method="post">
                <label id="profile_image_submit" >Submit
                    <input type="submit" name="submit_image">
                </label>
            </form>
        </div>
    </div>
</section>
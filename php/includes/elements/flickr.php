<?php global $error_message ?>
<section id="select_image_grid" class="<?php echo $_SESSION["ImageBox"] ?>">
    <form method="post" class="col1">
        <label>
            <input type="submit" name="onEditImage" value="hide">
        </label>
    </form>
    <form method="post" class="col3">
        <label>
            <input type="submit" name="onEditImage" value="hide">
        </label>
    </form>
    <form method="post" class="row1">
        <label>
            <input type="submit" name="onEditImage" value="hide">
        </label>
    </form>
    <form method="post" class="row3">
        <label>
            <input type="submit" name="onEditImage" value="hide">
        </label>
    </form>
    <div id="select_image_box" >
        <form method="post" id="flickr_search">
            <input type="search" name="flickr_search" placeholder="search" <?php echo $_SESSION["dsr"] ?>>
            <label>Search
                <input type="submit" id="submit_flickr_search" placeholder="search" <?php echo $_SESSION["dsr"] ?>>
            </label>
        </form>
        <form method="post" id="flickr_images">
            <?php echo $_SESSION["flickr_search"] ?>
        </form>
        <div id="image_preview">
            <?php echo $_SESSION["profile_preview"]["image"] ?>
        </div>
        <div id="image_buttons">
            <form method="post" enctype="multipart/form-data">
                <?php echo $error_message ?>
                <label id="select_own">Select your Image
                    <input type="file" accept=".jpg, .png, .jpeg" name="upload_image" onclick="onImageAdd(this)">
                </label>
                <label id="submit_own" >upload
                    <input type="submit" name="upload_image" value="upload_image">
                </label>
            </form>
            <form method="post" id="image_submit">
                <label>Submit
                    <input type="submit" name="submit_image">
                </label>
            </form>
        </div>
    </div>
</section>
<script>
    function onImageAdd(image) {
        var preview = document.getElementById("image_preview");
        var newImage = new Image();

        input.addEventListener('change', () => {
            newImage.src = URL.createObjectURL(image.files[0]);
        })
        newImage.alt = "could not load image";
        preview.onload = function (){
            URL.revokeObjectURL(preview.src);
            preview.appendChild(newImage);
        }
    }
</script>

<?php
    global $itemList, $error_message, $itemList;
    include_once "../php/includes/head/head.php"
?>
<body>
    <?php include_once "../php/includes/navigation/header/header.php" ?>

    <section id="events">
        <div id="filter">
            <form method="post" id="search">
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
                <input type="search" oninput="sendRequest(search)" name="search" placeholder="search" value="<?php echo $_SESSION["search"] ?>" >
                <label>Search
                    <input type="submit" name="submitSearch">
                </label>
            </form>
            <form method="post" id="sort">
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
                <div>Sort by:
                    <label>Name
                        <input type="submit" name="sort" value="Name">
                    </label>
                    <label>Genre
                        <input type="submit" name="sort" value="Genre">
                    </label>
                </div>
            </form>
        </div>

        <h1 id="header">All Bands</h1>

        <!-- remove final deadline-->
        <p id="error-message"><?php echo $error_message ?></p>
        <section id="item_list">
            <?php echo $itemList ?>
        </section>

    </section>

    <script src="../JavaScript/posts.js"></script>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>
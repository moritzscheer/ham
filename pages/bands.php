<?php global $itemList, $error_message;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/includes/navigation/header/header.php" ?>

<section id="events">
    <div id="filter">
        <form method="post" id="search">
            <input type="search" name="search" placeholder="search" >
            <label>Search
                <input type="submit" name="submitSearch">
            </label>
        </form>
        <form method="post" id="sort">
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

    <h1 id="header">Bands</h1>

    <!-- remove final deadline-->
    <p id="error-message"><?php echo $error_message ?></p>
    <section id="item_list">
        <?php echo $_SESSION["itemList"] ?>
    </section>

</section>

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>


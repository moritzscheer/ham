<?php include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <h1>Bands</h1>

    <div id="bands">
        <div id="item-list-head">
            <!-- <h2>Bands</h2> -->
            <div class="flexbox-center">
                <label class="filter-box">
                    <span class="flexbox-center filter-label">Filter</span>
                    <input class="filter" type="text" name="filter">
                </label>
            </div>
        </div>

        <!-- List of Items (Bands or Events) -->
        <?php include_once "../php/itemList/itemList.php" ?>
        <div id="item-list-view">
            <?php getItems() ?>
        </div>

    <div class="footer-area">
        <?php include_once "../php/navigation/footer/footer.php" ?>
    </div>

</body>
</html>


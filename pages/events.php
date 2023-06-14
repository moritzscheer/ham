<?php global $itemList;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

    <h1>Events</h1>

    <div id="bands">
        <div id="item-list-head">
            <div class="flexbox-center">
                <label class="filter-box">
                    <span class="flexbox-center filter-label">Filter</span>
                    <input class="filter" type="text" name="filter">
                </label>
            </div>
        </div>

        <!-- List of Items (Bands or Events) -->
        <div id="item-list-view">
            <?php echo $itemList ?>
        </div>

    </div>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>
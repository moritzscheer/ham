<?php include_once "php/head.php" ?>
<body>
<?php include_once "php/header.php" ?>


<div id="bands">
    <div id="item-list-head">
        <h2>Bands</h2>
        <div class="flexbox-center">
            <label class="filter-box">
                <span class="flexbox-center filter-label">Filter</span>
                <input class="filter" type="text" name="filter">
            </label>
        </div>
    </div>

    <!-- List of Items (Bands or Events) -->
    <?php include_once "itemList.php"?>

<div class="footer-area">
    <?php include_once "php/footer.php" ?>
</div>

</body>
</html>


<?php include_once "../php/head/head.php" ?>
<link rel="stylesheet" type="text/css" href="../resources/css/posts.css">
</head>
<body>
<?php include_once "../php/navigation/header/header.php" ?>


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
        <?php include_once "../php/itemList.php" ?>

    <div class="footer-area">
        <?php include_once "../php/navigation/footer/footer.php" ?>
    </div>

</body>
</html>


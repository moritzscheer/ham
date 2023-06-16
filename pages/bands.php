<?php global $itemList, $error_message;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

<section id="events">
    <div id="filter">
        <form method="post" id="search">
            <input type="search" name="search" placeholder="search" >
            <input type="date" name="searchDate" placeholder="Date">
            <input type="submit" name="submitSearch">
        </form>
        <form method="post" id="sort">
            <label>Sort by:
                <input type="submit" name="sortName" value="name">
                <input type="submit" name="sortDate" value="date">
            </label>
        </form>
    </div>

    <h1 id="header">Bands</h1>

    <p id="error-message"><?php echo $error_message ?></p>
    <section id="item_list">
        <?php echo $_SESSION["itemList"] ?>
    </section>

</section>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>


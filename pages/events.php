<?php global $itemList, $itemDetail, $error_message, $showEventOptions;
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

    <h1 id="header">Events</h1>

    <form method="post" id="<?php echo $_SESSION["showEventOptions"] ?>">
        <label>All Events
            <input type="submit" name="onGetAllEvents">
        </label>
        
        <label>My Events
            <input type="submit" name="onGetMyEvents" value="<?php echo $_SESSION["user_ID"] ?>">
        </label>
    </form>
    
    <p id="error-message"><?php echo $error_message ?></p>
    <?php echo $_SESSION["itemDetail"] ?>
    <section id="item_list">
        <?php echo $_SESSION["itemList"] ?>
    </section>

</section>

<?php include_once "../php/navigation/footer/footer.php" ?>
</body>
</html>
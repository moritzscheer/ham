<?php global $itemList, $itemDetail, $error_message, $showEventOptions;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/navigation/header/header.php" ?>

<section id="events">

    <div id="filter">
        <form method="post" id="search">
            <input type="search" name="search" value="<?php echo $_SESSION["search"] ?>" placeholder="search" >
            <input type="date" name="searchDate" value="<?php echo $_SESSION["searchDate"] ?>" placeholder="Date">
            <input type="submit" name="submitSearch">
        </form>
        <form method="post" id="sort">
            <label>Sort by:
                <input type="submit" name="sort" value="Name">
                <input type="submit" name="sort" value="Date">
            </label>
        </form>
    </div>

    <form method="post" id="event_options" class="<?php echo $_SESSION["showEventOptions"] ?>">
        <label id="option1">All Events
            <input type="submit" name="onGetAllEvents">
        </label>
        
        <label id="option2">My Events
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
<?php
    global $itemList, $itemDetail, $error_message, $showEventOptions;
    include_once "../php/includes/head/head.php"
?>
<body>
<?php include_once "../php/includes/navigation/header/header.php" ?>

<section id="events">

    <div id="filter">
        <form method="post" id="search">
            <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
            <input type="search" name="search" oninput="sendRequest(search)" value="<?php echo $_SESSION["search"] ?>" placeholder="search" >
            <input type="date" name="searchDate" value="<?php echo $_SESSION["searchDate"] ?>" placeholder="Date">
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
                <label>Date
                    <input type="submit" name="sort" value="Date">
                </label>
            </div>
        </form>
    </div>

    <form method="post" id="event_options" class="<?php echo $_SESSION["showEventOptions"] ?>">
        <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
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

<?php include_once "../php/includes/navigation/footer/footer.php" ?>
</body>
</html>
<script>
    function sendRequest(search) {
        var xmlhttp = new XMLHttpRequest();
        search = search.value;

        xmlhttp.open("GET", "../php/itemList.php?submitSearchJavaScript="+search, true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-formurlencoded");
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("item_list").innerHTML = this.responseText;
                console.log(this);
            }
        }
        xmlhttp.send();
    }
</script>
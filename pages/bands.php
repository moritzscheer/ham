<?php global $itemList, $error_message;
include_once "../php/head/head.php" ?>
<body>
<?php include_once "../php/includes/navigation/header/header.php" ?>

<section id="events">
    <div id="filter">
        <form method="post" id="search">
            <input type="search" oninput="searchBand(search)" name="search" placeholder="search" value="<?php echo $_SESSION["search"] ?>" >
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
<script>
    function searchBand(search){
        search = search.value;

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "../php/itemList.php?submitSearchJavaScript="+search, true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-formurlencoded");
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200){
                document.getElementById("item_list").innerHTML = this.responseText;
                console.log(this);
            }
        }
        xmlhttp.send();
    }


</script>

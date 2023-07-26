<?php
    namespace php\controller;
    global $error_message;
    include_once "../php/includes/head/head.php";
?>
<body>
    <?php include_once "../php/includes/navigation/header/header.php" ?>

    <h1> Close to Me </h1>

    <div class="closeToMe-Grid">
        <div>
            <?php echo $_SESSION["map"] ?>
        </div>

        <p id="error-message"><?php echo $error_message ?></p>
    
        <?php echo $_SESSION["itemDetail"] ?>
        <section id="item_list">
            <?php echo $_SESSION["itemList"] ?>
        </section>

    </div>

    <?php include_once "../php/includes/navigation/footer/footer.php" ?>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.3.1/highlight.min.js"></script>

    <script src="../php/includes/api/leaflet/modules.js"></script>
    <script src="../php/includes/api/leaflet/map.js"></script>
</body>
</html>



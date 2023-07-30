<?php
    global $map_events, $map_loggedInUser, $initMap, $url, $init;
    include "../php/settings.php";
    include "../php/controller/image_controller.php";
    include "../php/controller/user_controller.php";
    include "../php/controller/item_controller.php";
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="x-icon" href="../resources/images/logo/ham_xs.png">
    <meta name="author" content="Holger, Artur und Moritz">
    <meta name="keywords" content="Musiker, Veranstalter">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../resources/css/format.css">
    <?php echo $url ?>
    <link rel="stylesheet" type="text/css" media="screen" href="../resources/css/header.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../resources/css/footer.css">
    <title>ham</title>

    <script>
        var events = <?php echo json_encode($map_events) ?>;
        var userAddress = <?php echo json_encode($map_loggedInUser) ?>;
        var radius = <?php echo $_SESSION["radius"] ?>;
        var init = <?php echo $init ?>;
    </script>
</head>

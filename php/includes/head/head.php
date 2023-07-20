<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php/settings.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php/controller/user_controller.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php/controller/item_controller.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php/controller/flickr_controller.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/php/controller/map_controller.php";
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
    <?php echo $_SESSION["url"] ?>
    <link rel="stylesheet" type="text/css" media="screen" href="../resources/css/header.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../resources/css/footer.css">
    <title>ham</title>
</head>

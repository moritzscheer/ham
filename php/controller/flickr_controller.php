<?php
global $blobObj, $flickrApi;

$_SESSION["flickr_search"] = $_SESSION["flickr_search"] ?? "";
$_SESSION["selectImageBox"] = $_SESSION["selectImageBox"] ?? "";

$_SESSION["profile_preview"] = $_SESSION["profile_preview"] ?? array("source" => "", "category" => "", "image" => "No Image Selected.");

/**
 * if an image was clicked the editImage box will be displayed
 */
if (isset($_POST["onEditImage"])) {
    if($_POST["onEditImage"] === "hide") {
        $_SESSION["ImageBox"] = "hidden";
        unset($_SESSION["profile_preview"]);
        unset($_SESSION["flickr_search"]);
    } else {
        $_SESSION["ImageBox"] = "visible";

        // sets the category of the image
        $_SESSION["profile_preview"]["category"] = $_POST["onEditImage"];

        if($_SESSION["loggedIn"]["user"]->getDsr() === "n") {
            $_SESSION["flickr_search"] =
                '<span id="agreementText">If you want to see the content of Third party companies accept the <a id="agreementLinks" href="impressum.php" target="_blank" rel="noopener noreferrer">Legal Disclosure</a>' .
                ', <a id="agreementLinks" href="nutzungsbedingungen.php" target="_blank" rel="noopener noreferrer">Terms of Use</a>' .
                ' and the <a id="agreementLinks" href="datenschutz.php" target="_blank" rel="noopener noreferrer">Privacy Policy</a>.</span>';

        }
    }
}

/**
 * sets the preview image to the uploaded image
 */
if (isset($_POST["upload_image"])) {
    try {
        $_SESSION["profile_preview"]["source"] = "../resources/images/profile/custom/".verifyImage($_POST["upload_image"], "profile/custom");
        $_SESSION["profile_preview"]["image"] = '<img src="'.$_SESSION["profile_preview"]["source"].'" alt="could not load image">';
    } catch (RuntimeException $ex) {
        $error_message = "could not upload Image";
    }
}

/**
 * sets the preview image to the selected image
 */
if (isset($_POST["select_image"])) {
    $_SESSION["profile_preview"]["source"] =  $_POST["select_image"];
    $_SESSION["profile_preview"]["image"] = '<img src="'.$_SESSION["profile_preview"]["source"].'" alt="could not load image">';
}

/**
 * submits the preview image
 */
if(isset($_POST["submit_image"])) {
    if($_SESSION["profile_preview"]["source"] != null) {
        $blobObj->insertBlob($_SESSION["loggedIn"]["user"]->getUserID(), $_SESSION["profile_preview"]["category"], $_SESSION["profile_preview"]["source"], "image/gif");
    }
    setProfileImages($_SESSION["loggedIn"]["user"]->getUserID(), true);
    unset($_SESSION["profile_preview"]);
    $_SESSION["ImageBox"] = "hidden";
}

/**
 * gets flickr images depending on the search tags
 */
if(isset($_POST["flickr_search"])) {
    $_SESSION["flickr_search"] = $flickrApi->searchPhotos($_POST["flickr_search"], 1);

}
















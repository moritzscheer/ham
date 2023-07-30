<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                            import and autoload classes                                             */
/* ------------------------------------------------------------------------------------------------------------------ */

namespace php\controller;

global $blobObj, $flickrApi;

use RuntimeException;

include $_SERVER['DOCUMENT_ROOT'] . '/autoloader.php';

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               http request functions                                               */
/* ------------------------------------------------------------------------------------------------------------------ */

$_SESSION["flickr_search"] = $_SESSION["flickr_search"] ?? "";
$_SESSION["selectImageBox"] = $_SESSION["selectImageBox"] ?? "";

$_SESSION["profile_preview"] = $_SESSION["profile_preview"] ?? array("source" => "", "category" => "", "image" => "No Image Selected.");

/**
 * if an image was clicked the editImage box will be displayed
 */
if (isset($_POST["onEditImage"])) {
    if ($_POST["onEditImage"] === "hide") {
        $_SESSION["ImageBox"] = "hidden";
        unset($_SESSION["profile_preview"]);
        unset($_SESSION["flickr_search"]);
    } else {
        $_SESSION["ImageBox"] = "visible";

        // sets the category of the image
        $_SESSION["profile_preview"]["category"] = $_POST["onEditImage"];

        if ($_SESSION["loggedIn"]["user"]->getDsr() === "n") {
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
    } catch (RuntimeException) {
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
if (isset($_POST["submit_image"])) {
    // if any photo was selected
    if ($_SESSION["profile_preview"]["source"] != null) {

        if ($_SESSION["profile_preview"]["category"] === "event") {
            $_SESSION["event"]->setImage($_SESSION["profile_preview"]["source"]);

        } else {
            $blobObj->create($_SESSION["loggedIn"]["user"]->getUserID(), $_SESSION["profile_preview"]["category"], $_SESSION["profile_preview"]["source"], "image/gif");

            if ($_SESSION["profile_preview"]["category"] === "profile_large") {
                $_SESSION["profile_large"] = getImage($_SESSION["loggedIn"]["user"]->getUserID(), "profile_large", "../resources/images/profile/default/defaultLarge.jpeg", false);

            } elseif ($_SESSION["profile_preview"]["category"] === "profile_small") {
                $_SESSION["profile_small"] = getImage($_SESSION["loggedIn"]["user"]->getUserID(), "profile_small", "../resources/images/profile/default/defaultSmall.png", false);
                $_SESSION["loggedIn"]["profile_small"] = $_SESSION["profile_small"];

            } else {
                $_SESSION["profile_gallery"] = getImage($_SESSION["loggedIn"]["user"]->getUserID(), "profile_gallery", "../resources/images/profile/default/defaultGallery.jpeg", true);
            }
        }
    }
    unset($_SESSION["profile_preview"]);
    $_SESSION["ImageBox"] = "hidden";
}

/**
 * gets flickr images depending on the search tags
 */
if (isset($_POST["flickr_search"])) {
    $_SESSION["flickr_search"] = $flickrApi->searchPhotos($_POST["flickr_search"], 1);

}

/**
 * @param $user_ID
 * @param $isEdit
 * @return void
 */
function setProfileImages($user_ID, $isEdit) : void {
    $_SESSION["profile_small"] = getImage($user_ID, "profile_small", "../resources/images/profile/default/defaultSmall.png", false);
    $_SESSION["profile_large"] = getImage($user_ID, "profile_large", "../resources/images/profile/default/defaultLarge.jpeg", false);
    $_SESSION["profile_gallery"] = getImage($user_ID, "profile_gallery", "../resources/images/profile/default/defaultGallery.jpeg", $isEdit);
}

/**
 * @param $user_ID
 * @param $category
 * @param $altUrl
 * @param $isEdit
 * @return string
 */
function getImage($user_ID, $category, $altUrl, $isEdit) : string {
    global $blobObj;

    try {
        $ids = $blobObj->queryID($user_ID, $category);

        $output = "";
        foreach ($ids as $id) {
            $source = $blobObj->findOne($id[0]);

            if ($isEdit && $category === "profile_gallery") {
                $img =
                    '<div id="image">                                                                                              '.
                    '    <img src="' . $source . '" alt="could not load image"/>                                                   '.
                    '    <label id="exit">X                                                                                        '.
                    '         <input type="submit" name="onDeleteImage" value="' . $id[0] . '">                                    '.
                    '    </label>                                                                                                  '.
                    '</div>                                                                                                        ';
            } else {
                $img = '<img src="' . $source . '" alt="could not load image"/>';
            }
            $category === "profile_gallery" ? ($output .= $img) : ($output = $img);
        }
        return $output;
    } catch (RuntimeException) {
        if ($category === "profile_gallery") {
            return $isEdit ? "" : "There are no Images uploaded!";
        } else {
            return '<img src="'.$altUrl.'" alt="could not load image"/>';
        }
    }
}

if (isset($_POST["onDeleteImage"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        // deletes image from store
        $blobObj->delete($_POST["onDeleteImage"]);

        // gets image gallery
        setProfileImages($_SESSION["loggedIn"]["user"]->getUserID(), true);

        // redirect to edit profile page
        header("Location: editProfile.php");
        exit();
    } catch (RuntimeException $e) {
        $error_message = $e->getMessage();
    }
}

/**
 * @param $name
 * @param $type
 * @return String
 */
function verifyImage($name, $type): String {
    $file_name = $_FILES[$name]["name"];
    $file_size = $_FILES[$name]["size"];
    $file_tmp = $_FILES[$name]["tmp_name"];
    $file_format = strtolower(pathinfo($_FILES[$name]["name"], PATHINFO_EXTENSION));
    $expected_format = array("jpeg","jpg","png");

    // checking file format
    if (!in_array($file_format, $expected_format)) {
        throw new RuntimeException("invalid format");
    }

    // checking image size
    if ($file_size > 8000000) {
        throw new RuntimeException("exceeds filesize limit");
    }

    // moving file to dictionary
    if (!move_uploaded_file($file_tmp,"../resources/images/".$type."/".$file_name)) {
        throw new RuntimeException("failed to upload image");
    }
    return $file_name;
}














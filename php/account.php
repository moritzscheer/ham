<?php

// Set session parameters
ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_set_cookie_params(1);

// Initialize the session.
session_start();


/* ------------------------------------------------------------------------------------------------------------------ */
/*                            Different Headers depending on if a user is logged in or not                            */
/* ------------------------------------------------------------------------------------------------------------------ */
$_SESSION["normalHeader"] = "";
$_SESSION["profileHeader"] = "";

// switches the logged in status
if (isset($_POST["login"])) {
    $_SESSION["loggedIn"] = true;
} elseif (isset($_POST["logout"])) {
    unset($_SESSION["loggedIn"]);
    $_SESSION["normalHeader"] = "visible";
    $_SESSION["profileHeader"] = "hidden";
}

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    $_SESSION["normalHeader"] = "hidden";
    $_SESSION["profileHeader"] = "visible";
}

    //session_destroy();


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          variables for the profile page                                            */
/* ------------------------------------------------------------------------------------------------------------------ */

$_SESSION["step1"] = "visible";
$_SESSION["step2"] = "hidden";
$_SESSION["step3"] = "hidden";
$_SESSION["progress2"] = "inactive";
$_SESSION["progress3"] = "inactive";

// switches the header elements
if(isset($_POST["toStep1"])){
    $_SESSION["step1"] = "visible";
    $_SESSION["step2"] = "hidden";
    $_SESSION["step3"] = "hidden";
    $_SESSION["progress2"] = "inactive";
    $_SESSION["progress3"] = "inactive";
} elseif (isset($_POST["toStep2"])){
    $_SESSION["step1"] = "hidden";
    $_SESSION["step2"] = "visible";
    $_SESSION["step3"] = "hidden";
    $_SESSION["progress2"] = "active";
    $_SESSION["progress3"] = "inactive";
} elseif (isset($_POST["toStep3"])){
    $_SESSION["step1"] = "hidden";
    $_SESSION["step2"] = "hidden";
    $_SESSION["step3"] = "visible";
    $_SESSION["progress2"] = "active";
    $_SESSION["progress3"] = "active";
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          variables for the profile page                                            */
/* ------------------------------------------------------------------------------------------------------------------ */


// Form 1
$email = (isset($_POST["email"]) && is_string($_POST["email"])) ? $_POST["email"] : "";
$password = (isset($_POST["password"]) && is_string($_POST["password"])) ? $_POST["password"] : "";
$repeatPassword = (isset($_POST["repeatPassword"]) && is_string($_POST["repeatPassword"])) ? $_POST["repeatPassword"] : "";

$_SESSION["email"] = htmlspecialchars($email);
$_SESSION["password"] = htmlentities($password);
$_SESSION["repeatPassword"] = htmlentities($repeatPassword);


// Form 2
$name = (isset($_POST["name"]) && is_string($_POST["name"])) ? $_POST["name"] : "";
$surname = (isset($_POST["surname"]) && is_string($_POST["surname"])) ? $_POST["surname"] : "";
$phoneNumber = (isset($_POST["phoneNumber"]) && is_string($_POST["phoneNumber"])) ? $_POST["phoneNumber"] : "";

$_SESSION["name"] = htmlspecialchars($name);
$_SESSION["surname"] = htmlspecialchars($surname);
$_SESSION["phoneNumber"] = htmlspecialchars($phoneNumber);


// Form 3
$genre = (isset($_POST["genre"]) && is_string($_POST["genre"])) ? $_POST["genre"] : "";
$members = (isset($_POST["members"]) && is_string($_POST["members"])) ? $_POST["members"] : "";
$otherRemarks = (isset($_POST["otherRemarks"]) && is_string($_POST["otherRemarks"])) ? $_POST["otherRemarks"] : "";
$type = (isset($_POST["type"]) && is_string($_POST["type"])) ? $_POST["type"] : "";

$_SESSION["type"] = htmlspecialchars($type);
$_SESSION["genre"] = htmlspecialchars($genre);
$_SESSION["members"] = htmlspecialchars($members);
$_SESSION["otherRemarks"] = htmlspecialchars($otherRemarks);

















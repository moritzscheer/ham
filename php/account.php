<?php
ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();


/* ------------------------------------------------------------------------------------------------------------------ */
/*                     Different User Interface depending on if a user is logged in or not                            */
/* ------------------------------------------------------------------------------------------------------------------ */
$_SESSION["loggedIn"] = 0;


// switches the logged in status
if (isset($_POST["login"])) {
    $_SESSION["loggedIn"] = 1;
} elseif (isset($_POST["logout"])) {
    $_SESSION["loggedIn"] = 0;
}

// switches the header elements
if( $_SESSION["loggedIn"] === 1 ){
    $_SESSION["normalHeader"] = "hidden";
    $_SESSION["profileHeader"] = "visible";
} else{
    $_SESSION["normalHeader"] = "visible";
    $_SESSION["profileHeader"] = "hidden";
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          variables for the profile page                                            */
/* ------------------------------------------------------------------------------------------------------------------ */

$_SESSION["Step1"] = "visible";
$_SESSION["Step2"] = "hidden";
$_SESSION["Step3"] = "hidden";
$_SESSION["status2"] = "inactive";
$_SESSION["status3"] = "inactive";

// switches the header elements
if(isset($_POST["toStep1"])){
    $_SESSION["Step1"] = "visible";
    $_SESSION["Step2"] = "hidden";
    $_SESSION["Step3"] = "hidden";
    $_SESSION["status2"] = "inactive";
    $_SESSION["status3"] = "inactive";
} elseif (isset($_POST["toStep2"])){
    $_SESSION["Step1"] = "hidden";
    $_SESSION["Step2"] = "visible";
    $_SESSION["Step3"] = "hidden";
    $_SESSION["status2"] = "active";
    $_SESSION["status3"] = "inactive";

} elseif (isset($_POST["toStep3"])){
    $_SESSION["Step1"] = "hidden";
    $_SESSION["Step2"] = "hidden";
    $_SESSION["Step3"] = "visible";
    $_SESSION["status2"] = "active";
    $_SESSION["status3"] = "active";
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

















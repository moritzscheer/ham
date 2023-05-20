<?php
ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();


// -------------- Different User Interface depending on if a user is logged in or not -------------- //

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

// --------------------------------- variables for the profile page --------------------------------- //
$name = (isset($_POST["name"]) && is_string($_POST["name"])) ? $_POST["name"] : "";
$surname = (isset($_POST["surname"]) && is_string($_POST["surname"])) ? $_POST["surname"] : "";
$email = (isset($_POST["email"]) && is_string($_POST["email"])) ? $_POST["email"] : "";
$phoneNumber = (isset($_POST["phoneNumber"]) && is_string($_POST["phoneNumber"])) ? $_POST["phoneNumber"] : "";
$type = (isset($_POST["type"]) && is_string($_POST["type"])) ? $_POST["type"] : "";
$genre = (isset($_POST["genre"]) && is_string($_POST["genre"])) ? $_POST["genre"] : "";
$members = (isset($_POST["members"]) && is_string($_POST["members"])) ? $_POST["members"] : "";
$otherRemarks = (isset($_POST["otherRemarks"]) && is_string($_POST["otherRemarks"])) ? $_POST["otherRemarks"] : "";

$_SESSION["name"] = htmlspecialchars($name);
$_SESSION["surname"] = htmlspecialchars($surname);
$_SESSION["email"] = htmlspecialchars($email);
$_SESSION["phoneNumber"] = htmlspecialchars($phoneNumber);
$_SESSION["type"] = htmlspecialchars($type);
$_SESSION["genre"] = htmlspecialchars($genre);
$_SESSION["members"] = htmlspecialchars($members);
$_SESSION["otherRemarks"] = htmlspecialchars($otherRemarks);

// --------------------------------- variables for the register page --------------------------------- //
$regName = (isset($_POST["regName"]) && is_string($_POST["regName"])) ? $_POST["regName"] : "";
$regMail = (isset($_POST["regMail"]) && is_string($_POST["regMail"])) ? $_POST["regMail"] : "";
$regPassword = (isset($_POST["regPassword"]) && is_string($_POST["regPassword"])) ? $_POST["regPassword"] : "";
$reRegPassword = (isset($_POST["reRegPassword"]) && is_string($_POST["reRegPassword"])) ? $_POST["reRegPassword"] : "";

$_SESSION["regName"] = htmlentities($regName);
$_SESSION["regMail"] = htmlentities($regMail);
$_SESSION["regPassword"] = htmlentities($regPassword);
$_SESSION["reRegPassword"] = htmlentities($reRegPassword);

// ---------------------------------- variables for the login page ---------------------------------- //
$logMail = (isset($_POST["logMail"]) && is_string($_POST["logMail"])) ? $_POST["logMail"] : "";
$logPassword = (isset($_POST["logPassword"]) && is_string($_POST["logPassword"])) ? $_POST["logPassword"] : "";

$_SESSION["logMail"] = htmlentities($logMail);
$_SESSION["logPassword"] = htmlentities($logPassword);







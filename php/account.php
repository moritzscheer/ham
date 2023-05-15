<?php
ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
session_start();

// profile page variables
$_SESSION["name"] = (isset($_POST["name"]) && is_string($_POST["name"])) ? $_POST["name"] : "";
$_SESSION["surname"] = (isset($_POST["surname"]) && is_string($_POST["surname"])) ? $_POST["surname"] : "";
$_SESSION["email"] = (isset($_POST["email"]) && is_string($_POST["email"])) ? $_POST["email"] : "";
$_SESSION["phoneNumber"] = (isset($_POST["phoneNumber"]) && is_string($_POST["phoneNumber"])) ? $_POST["phoneNumber"] : "";
$_SESSION["type"] = (isset($_POST["type"]) && is_string($_POST["type"])) ? $_POST["type"] : "";
$_SESSION["genre"] = (isset($_POST["genre"]) && is_string($_POST["genre"])) ? $_POST["genre"] : "";
$_SESSION["members"] = (isset($_POST["members"]) && is_string($_POST["members"])) ? $_POST["members"] : "";
$_SESSION["otherRemarks"] = (isset($_POST["otherRemarks"]) && is_string($_POST["otherRemarks"])) ? $_POST["otherRemarks"] : "";
$name = htmlspecialchars($_SESSION['name']);
$surname = htmlspecialchars($_SESSION['surname']);
$email = htmlspecialchars($_SESSION['email']);
$phoneNumber = htmlspecialchars($_SESSION['phoneNumber']);
$type = htmlspecialchars($_SESSION['type']);
$genre = htmlspecialchars($_SESSION['genre']);
$members = htmlspecialchars($_SESSION['members']);
$otherRemarks = htmlspecialchars($_SESSION['otherRemarks']);

// register page variables
$_SESSION["regName"] = (isset($_POST["regName"]) && is_string($_POST["regName"])) ? $_POST["regName"] : "";
$_SESSION["regMail"] = (isset($_POST["regMail"]) && is_string($_POST["regMail"])) ? $_POST["regMail"] : "";
$_SESSION["regPassword"] = (isset($_POST["regPassword"]) && is_string($_POST["regPassword"])) ? $_POST["regPassword"] : "";
$_SESSION["reRegPassword"] = (isset($_POST["reRegPassword"]) && is_string($_POST["reRegPassword"])) ? $_POST["reRegPassword"] : "";
$regName = htmlentities($_SESSION["regName"]);
$regMail = htmlentities($_SESSION["regMail"]);
$regPassword = htmlentities($_SESSION["regPassword"]);
$reRegPassword = htmlentities($_SESSION["reRegPassword"]);

// login page variables
$_SESSION["logMail"] = (isset($_POST["logMail"]) && is_string($_POST["logMail"])) ? $_POST["logMail"] : "";
$_SESSION["logPassword"] = (isset($_POST["logPassword"]) && is_string($_POST["logPassword"])) ? $_POST["logPassword"] : "";
$logmail = htmlentities($_SESSION["logMail"]);
$logpassword = htmlentities($_SESSION["logPassword"]);





// switches the logged in status
if (isset($_POST["login"])) {
    $_SESSION["loggedIn"] = 1;
} elseif (isset($_POST["logout"])) {
    $_SESSION["loggedIn"] = -1;
}
// switches the header elements
if( $_SESSION["loggedIn"] === 1 ){
    $_SESSION["normalHeader"] = "hidden";
    $_SESSION["profileHeader"] = "visible";
} else{
    $_SESSION["normalHeader"] = "visible";
    $_SESSION["profileHeader"] = "hidden";
}

if (isset($_FILES["profilePicture"])) {

}

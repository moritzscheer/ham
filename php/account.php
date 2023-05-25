<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          reset for all account variables                                           */
/* ------------------------------------------------------------------------------------------------------------------ */


// unsets all the session variables
if(isset($_POST["reset"]) || isset($_POST["logout"])) {
    unset($_SESSION["email"]);
    unset($_SESSION["password"]);
    unset($_SESSION["repeatPassword"]);
    unset($_SESSION["name"]);
    unset($_SESSION["surname"]);
    unset($_SESSION["address"]);
    unset($_SESSION["phoneNumber"]);
    unset($_SESSION["type"]);
    unset($_SESSION["genre"]);
    unset($_SESSION["members"]);
    unset($_SESSION["otherRemarks"]);
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          variables for the account                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */


// initialize session variables
$_SESSION["email"] = checkVariable("email");
$_SESSION["password"] = checkVariable("password");
$_SESSION["repeatPassword"] = checkVariable("repeatPassword");

$_SESSION["name"] = checkVariable("name");
$_SESSION["surname"] = checkVariable("surname");
$_SESSION["address"] = checkVariable("address");
$_SESSION["phoneNumber"] = checkVariable("phoneNumber");

$_SESSION["type"] = checkVariable("type");
$_SESSION["genre"] = checkVariable("genre");
$_SESSION["members"] = checkVariable("members");
$_SESSION["otherRemarks"] = checkVariable("otherRemarks");


// for radio button
$_SESSION["musician"] = "";
$_SESSION["host"] = "";

if($_SESSION["type"] === "musician") {
    $_SESSION["musician"] = "checked";
} elseif ($_SESSION["type"] === "host") {
    $_SESSION["host"] = "checked";
}


// checks if a post variable was set then if a session variable is set, else the variable is set to an empty string
function checkVariable($var): String {
    if (isset($_POST["$var"]) && is_string($_POST["$var"])) {
        return htmlspecialchars($_POST["$var"]);
    } elseif (isset($_SESSION["$var"]) && is_string($_SESSION["$var"])) {
        return $_SESSION["$var"];
    } else {
        return "";
    }
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                   change header elements on logged in status                                       */
/* ------------------------------------------------------------------------------------------------------------------ */


$_SESSION["normalHeader"] = "";
$_SESSION["profileHeader"] = "";


// switches the logged in status
if (isset($_POST["login"])) {
    setcookie("loggedIn", true, time()+5);
    $_SESSION["loggedIn"] = true;
} elseif (isset($_POST["logout"])) {
    $_SESSION["loggedIn"] = false;
}

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    $_SESSION["normalHeader"] = "hidden";
    $_SESSION["profileHeader"] = "visible";
} elseif (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === false) {
    $_SESSION["normalHeader"] = "visible";
    $_SESSION["profileHeader"] = "hidden";
}





















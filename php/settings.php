<?php
include_once "../php/user/FileUserStore.php";
include_once "../php/user/DBUserStore.php";

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                   start session                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */


// Set session parameters
ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);


ini_set("session.cache_limiter", "");
// each client should remember their session id
ini_set("session.cookie_lifetime", 0);
// server keeps session data
ini_set('session.gc_maxlifetime', 0);


// If the user does not want to stay logged In
if (isset($_POST["stayLoggedIn"]) && $_POST["stayLoggedIn"] == "on") {
    // each client remembers their session id for EXACTLY 1 hour
    ini_set("session.cookie_lifetime", 3600 * 24 * 7);
    // server keeps session data for EXACTLY 1 hour
    ini_set('session.gc_maxlifetime', 3600 * 24 * 7);
}


// Initialize the session.
session_start();


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                  assign urls to stylesheets                                        */
/* ------------------------------------------------------------------------------------------------------------------ */


$_SESSION["url2"] = "";

// sets the link to the stylesheet depending on which page is currently displayed
if (str_contains($_SERVER["PHP_SELF"], "changePassword") || str_contains($_SERVER["PHP_SELF"], "profile") || str_contains($_SERVER["PHP_SELF"], "editProfile")) {
    $_SESSION["url1"] = "../resources/css/profile.css";
} elseif (str_contains($_SERVER["PHP_SELF"], "bands") || str_contains($_SERVER["PHP_SELF"], "events")) {
    $_SESSION["url1"] = "../resources/css/posts.css";
} elseif (str_contains($_SERVER["PHP_SELF"], "closeToMe")) {
    $_SESSION["url1"] = "../resources/css/" . basename(basename($_SERVER["PHP_SELF"], '/ham/pages/'), '.php') . ".css";
    $_SESSION["url2"] = "../resources/css/posts.css";
} else {
    $_SESSION["url1"] = "../resources/css/" . basename(basename($_SERVER["PHP_SELF"], '/ham/pages/'), '.php') . ".css";
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                             create Database tables                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */


$_SESSION["initDatabase"] = (isset($_SESSION["initDatabase"])) ? $_SESSION["initDatabase"] : initDatabase();

function initDatabase(): void
{
    global $userStore;
    //$userStore = new DBUserStore();
    $userStore = new FileUserStore();
    $userStore->create("../resources/json/user.json");
}






$sql = "CREATE TABLE address (
    address_ID int(11) DEFAULT NULL,
    street_name int(30) DEFAULT NULL,
    house_number int(5) DEFAULT NULL,
    postal_code int(5) DEFAULT NULL,
    city varchar(20) DEFAULT NULL,
    PRIMARY KEY (address_ID)
);";

// creates the types table and adds the two types in
$sql = "CREATE TABLE type (
    type_ID tinyint(1) DEFAULT NULL,
    type_name varchar(10) NOT NULL,
    PRIMARY KEY (type_ID)
);";








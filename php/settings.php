<?php
    include_once "../php/includes/includes.php";
    global $blobObj, $db;

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
    $_SESSION["url1"] = "../resources/css/closeToMe.css";
    $_SESSION["url2"] = "../resources/css/posts.css";
} else {
    $_SESSION["url1"] = "../resources/css/" . basename(basename($_SERVER["PHP_SELF"], '/ham/pages/'), '.php') . ".css";
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                             create Database tables                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */


$_SESSION["initDatabase"] = (isset($_SESSION["initDatabase"])) ? $_SESSION["initDatabase"] : initDatabase();

function initDatabase(): void {

    global $db, $userStore, $addressStore, $bandStore, $eventStore, $blobObj;

    try {
        $user = "root";
        $pw = null;
        $dsn = "sqlite:sqlite-pdo.db";
        $db = new PDO($dsn, $user, $pw);
        $dsnBlob = "sqlite:sqlite-pdo-blob.db";
        $dbBlob = new PDO($dsnBlob, $user, $pw);
    } catch (PDOException $exc) {
        $db = NULL;
        $dbBlob = NULL;
        throw $exc;
    }

    /**
     * Blob object
     */
    $blobObj = new Blob($dbBlob);

    /**
     * database
     */
    $addressStore = new DBAddressStore($db);
    $eventStore = new DBEventStore($db, $addressStore, $blobObj);
    $userStore = new DBUserStore($db, $addressStore, $blobObj);

    /**
     * memory
     */
    //$addressStore = new FileAddressStore($db);
    /*$bandStore = new FileBandStore("../resources/json/Bands.json");
    $eventStore = new FileEventStore("../resources/json/Events.json");
    $userStore = new FileUserStore("../resources/json/Events.json");
    */
}

function closeConnection(): void {
    global $db;
    if ($db != NULL) {
        $db->close();
    }
}









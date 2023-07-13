<?php

global $blobObj, $db, $flickrApi;

use Item\User;
use Item\Event;


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
    $_SESSION["url1"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/profile.css">';
    if(str_contains($_SERVER["PHP_SELF"], "editProfile")) {
        $_SESSION["url2"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/flickr.css">';
    }
} elseif (str_contains($_SERVER["PHP_SELF"], "createEvent")) {
    $_SESSION["url1"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/createEvent.css">';
    $_SESSION["url2"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/flickr.css">';
} elseif (str_contains($_SERVER["PHP_SELF"], "bands") || str_contains($_SERVER["PHP_SELF"], "events")) {
    $_SESSION["url1"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/posts.css">';
} elseif (str_contains($_SERVER["PHP_SELF"], "closeToMe")) {
    $_SESSION["url1"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/closeToMe.css">';
    $_SESSION["url2"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/posts.css">';
} else {
    $_SESSION["url1"] = '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/' . basename(basename($_SERVER["PHP_SELF"], '/ham/pages/'), '.php') . '.css">';
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                             create Database tables                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */

$_SESSION["initDatabase"] = (isset($_SESSION["initDatabase"])) ? $_SESSION["initDatabase"] : initDatabase();

function initDatabase(): void {

    global $db, $userStore, $addressStore, $eventStore, $blobObj, $flickrApi;

    try {
        $user = "root";
        $pw = null;
        $dsn = "sqlite:../stores/sqlite-pdo.db";
        $db = new PDO($dsn, $user, $pw);

        /**
         * Blob object
         */
        $blobObj = new Blob($db);

        /**
         * database
         */
        $addressStore = new DBAddressStore($db);
        $eventStore = new DBEventStore($db, $addressStore, $blobObj);
        $userStore = new DBUserStore($db, $addressStore, $blobObj);

        $flickrApi = new Flickr("3b8e15fa98c7850431166704a6ed5be0");

        insertDummies();

        //todo: remove following line at deadline. Just use for memory Filestore Testing
        //throw new PDOException("Use Memory Stores");

    } catch (PDOException $exc) {
        $db = NULL;

        /**
         * memory
         */
        $eventStore = new FileEventStore("../resources/json/Events.json");
        $userStore = new FileUserStore("../resources/json/user.json");
    }
}

function closeConnection(): void {
    global $db;
    if ($db != NULL) {
        $db->close();
    }
}


/**
 * sources for the dummies
 * www.facebook.com/seeedde/photos
 * www.facebook.com/amadeus.oldenburg
 * www.pixabay.com
 */
function insertDummies() : void {
    global $userStore, $eventStore, $blobObj;
    $content = file_get_contents("../resources/dummy/dummies.json", false);
    $dummyJson = json_decode($content, true);
    try {
        foreach ($dummyJson["users"] as $user) {
            $user = User::withAddress($user);
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $userStore->create($user);
        }
        foreach ($dummyJson["events"] as $event) {
            $eventStore->create(Event::withAddress($event));
        }
        foreach ($dummyJson["images"] as $image) {
            $blobObj->insertBlob($image["assignded_ID"], $image["category"], $image["path"], $image["mime"]);
        }
    } catch (Exception $ex) {

    }
}





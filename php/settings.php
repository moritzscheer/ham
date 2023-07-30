<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                            import and autoload classes                                             */
/* ------------------------------------------------------------------------------------------------------------------ */

namespace php;

use Exception;
use PDO;
use php\includes\api\Flickr;
use php\includes\api\AddressValidator;
use php\includes\items\Event;
use php\includes\items\User;
use stores\database\DBAddressStore;
use stores\database\DBBlobStore;
use stores\database\DBEventStore;
use stores\database\DBUserStore;
use stores\memory\FileAddressStore;
use stores\memory\FileBlobStore;
use stores\memory\FileEventStore;
use stores\memory\FileUserStore;

global $url;

include $_SERVER['DOCUMENT_ROOT'] . '/autoloader.php';

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

// sets the link to the stylesheet depending on which page is currently displayed

$page = substr($_SERVER["PHP_SELF"], 11, -4);
$url = "";

switch ($page) {
    case "events":
    case "bands":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/posts.css">';
    break;
    case "profile":
    case "changePassword":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/profile.css">';
        break;
    case "closeToMe":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/posts.css">';
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/closeToMe.css">';
        $url .= '<link rel="stylesheet" href="https://unpkg.com/@highlightjs/cdn-assets@11.3.1/styles/a11y-light.min.css">';
        $url .= '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />';
        $url .= '<link rel="stylesheet" href="../resources/css/leaflet/range.css">';
        $url .= '<link rel="stylesheet" href="../resources/css/leaflet/search.css">';
        break;
    case "createEvent":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/createEvent.css">';
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/flickr.css">';
        break;
    case "editProfile":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/profile.css">';
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/flickr.css">';
        break;
    case "index":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/index.css">';
        break;
    case "login":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/login.css">';
        break;
    case "register":
        $url .= '<link rel="stylesheet" type="text/css" media="screen" href="../resources/css/register.css">';
        break;
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                             create Database tables                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */

$_SESSION["initDatabase"] = (isset($_SESSION["initDatabase"])) ? $_SESSION["initDatabase"] : initDatabase();

function initDatabase() : void {

    global $db, $userStore, $addressStore, $eventStore, $blobObj, $flickrApi, $geoLocApi;

    try {
        $user = "root";
        $pw = null;
        $dsn = "sqlite:".$_SERVER['DOCUMENT_ROOT']."/stores/sqlite-pdo.db";
        $db = new PDO($dsn, $user, $pw);

        /**
         * Api's
         */
        $flickrApi = new Flickr("3b8e15fa98c7850431166704a6ed5be0");
        $geoLocApi = new AddressValidator("3e6cf917f419488cbeec8ac503210f17");

        /**
         * database
         */
        $blobObj = new DBBlobStore($db);
        $addressStore = new DBAddressStore($db);
        $eventStore = new DBEventStore($db, $addressStore, $blobObj);
        $userStore = new DBUserStore($db, $addressStore, $blobObj);

        insertDummies();

    } catch (Exception) {
        $db = NULL;

        /**
         * memory
         */
        $blobObj = new FileBlobStore($_SERVER['DOCUMENT_ROOT']."/resources/json/images.json");
        $addressStore = new FileAddressStore($_SERVER['DOCUMENT_ROOT']."/resources/json/address.json");
        $eventStore = new FileEventStore($_SERVER['DOCUMENT_ROOT']."/resources/json/events.json", $addressStore, $blobObj);
        $userStore = new FileUserStore($_SERVER['DOCUMENT_ROOT']."/resources/json/user.json", $addressStore, $blobObj);

        insertDummies();
    }
}

function closeConnection(): void {
    global $db;
    if ($db != NULL) {
        $db->close();
    }
}

/**
 * sources for the dummies images
 * www.facebook.com/seeed/photos
 * www.facebook.com/amadeu.oldenburg/photos
 * www.pixabay.com
 * www.facebook.com/p/Jakub-Zytecki-100044442650010/
 * www.facebook.com/snarkypuppy/photos
 * www.facebook.com/Evanescence/photos
 * www.facebook.com/Gogopenguin/photos
 */
function insertDummies() : void {
    global $userStore, $eventStore, $blobObj;

    $content = file_get_contents($_SERVER['DOCUMENT_ROOT']."/resources/dummy/dummies.json", false);
    $dummyJson = json_decode($content, true);
    try {
        foreach ($dummyJson["users"] as $user) {
            $user = User::withAddress($user);
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $userStore->create($user);
        }
       foreach ($dummyJson["events"] as $event) {
           $eventStore->create(Event::create($event));
       }
        foreach ($dummyJson["images"] as $image) {
            $blobObj->create($image["assigned_ID"], $image["category"], $image["path"], $image["mime"]);
        }

    } catch (Exception $e) {
    }
}





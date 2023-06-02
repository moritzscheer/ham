<?php
global $db;

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
if(isset($_POST["login"]) && $_POST["login"] == "on") {
    // each client remembers their session id for EXACTLY 1 hour
    ini_set("session.cookie_lifetime", 3600 * 24 * 7 * 30);
    // server keeps session data for EXACTLY 1 hour
    ini_set('session.gc_maxlifetime', 3600 * 24 * 7 * 30);
}


// Initialize the session.
session_start();


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                  assign urls to stylesheets                                        */
/* ------------------------------------------------------------------------------------------------------------------ */


$_SESSION["url2"] = "";

// sets the link to the stylesheet depending on which page is currently displayed
if(str_contains($_SERVER["PHP_SELF"], "changePassword") || str_contains($_SERVER["PHP_SELF"], "profile") || str_contains($_SERVER["PHP_SELF"], "editProfile")) {
    $_SESSION["url1"] = "../resources/css/profile.css";
} elseif(str_contains($_SERVER["PHP_SELF"], "bands") || str_contains($_SERVER["PHP_SELF"], "events")) {
    $_SESSION["url1"] = "../resources/css/posts.css";
} elseif (str_contains($_SERVER["PHP_SELF"], "closeToMe")) {
    $_SESSION["url1"] = "../resources/css/" . basename(basename($_SERVER["PHP_SELF"], '/ham/pages/'), '.php') . ".css";
    $_SESSION["url2"] = "../resources/css/posts.css";
} else {
    $_SESSION["url1"] = "../resources/css/" . basename(basename($_SERVER["PHP_SELF"], '/ham/pages/'), '.php') . ".css";
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                             initialize mysql connection                                            */
/* ------------------------------------------------------------------------------------------------------------------ */



function connectToDatabase(): Boolean {
    global $db;
    try {
        $servername = 'localhost:63342';
        $user = 'root';
        $pw = null;

        $dbname = 'PHP';
        $db = new MySQLi( $servername, $user, $pw, $dbname );
        echo 'Verbindungsaufbau erfolgreich.';

        return true;
    } catch ( Exception $ex ) {
        echo 'Fehler: ' . $ex->getMessage();
        return false;
    }
}

function closeDatabase(): void {
    global $db;
    $db->close();
}

























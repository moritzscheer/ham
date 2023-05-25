<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                   start session                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */


// Set session parameters
ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.auto_start", 0);
ini_set("session.cookie_lifetime", 0);

// Initialize the session.
session_start();


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                  assign urls to stylesheets                                        */
/* ------------------------------------------------------------------------------------------------------------------ */


// sets the link to the stylesheet depending on which page is currently displayed
if(str_contains($_SERVER["PHP_SELF"], "changePassword") || str_contains($_SERVER["PHP_SELF"], "profile")) {
    $_SESSION["url"] = "../resources/css/profile.css";
} elseif(str_contains($_SERVER["PHP_SELF"], "bands") || str_contains($_SERVER["PHP_SELF"], "events")) {
    $_SESSION["url"] = "../resources/css/posts.css";
} else {
    $_SESSION["url"] = "../resources/css/" . basename(basename($_SERVER["PHP_SELF"], '/ham/pages/'), '.php') . ".css";
}
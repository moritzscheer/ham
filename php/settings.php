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
if(isset($_POST["stayLoggedIn"]) && $_POST["stayLoggedIn"] == "on") {
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



function connectToDatabase(): void {
    global $db;
    $user = "root";
    $pw = null;
    $dsn = "sqlite:sqlite-pdo.db";
    
    $db = new PDO($dsn, $user, $pw);
}

function closeDatabase(): void {
    global $db;
    $db = null;
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                             create Database tables                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */



$_SESSION["initDatabase"] = (isset($_SESSION["initDatabase"])) ? $_SESSION["initDatabase"]: initDatabase();

function initDatabase(): void {
    global $db;
    try {
        connectToDatabase();

        // creates the address table
        $sql = "CREATE TABLE address (
            address_ID int(11) DEFAULT NULL AUTO_INCREMENT,
            street_name int(30) DEFAULT NULL,
            house_number int(5) DEFAULT NULL,
            postal_code int(5) DEFAULT NULL,
            city varchar(20) DEFAULT NULL,
            PRIMARY KEY (address_ID)
        );";
        $db->exec($sql);
        
        // creates the types table and adds the two types in
        $sql = "CREATE TABLE type (
              type_ID tinyint(1) DEFAULT NULL AUTO_INCREMENT,
              type_name varchar(10) NOT NULL,
              PRIMARY KEY (type_ID)
        );";
        $db->exec($sql);
        $sql = "INSERT INTO type VALUES ('1', 'Musician');";
        $db->exec($sql);
        $sql = "INSERT INTO type VALUES ('2', 'Host');";
        $db->exec($sql);

        // creates the user table
        $sql = "CREATE TABLE user (
              user_ID bigint(20) DEFAULT NULL AUTO_INCREMENT,
              type_ID tinyint(1) NOT NULL,
              address_ID int(11) DEFAULT NULL,
              name varchar(15) DEFAULT NULL,
              surname varchar(15) DEFAULT NULL,
              password varchar(20) NOT NULL,
              phone_number varchar(20) DEFAULT NULL,
              email varchar(30) NOT NULL,
              PRIMARY KEY (user_ID),
              FOREIGN KEY (type_ID) REFERENCES type(type_ID),
              FOREIGN KEY (address_ID) REFERENCES address(address_ID)
        );";
        $db->exec($sql);

        // creates the type user table
        $sql = "CREATE TABLE type_user (
              user_type_ID bigint(20) DEFAULT NULL AUTO_INCREMENT,
              type_ID tinyint(1) NOT NULL,
              user_ID bigint(20) NOT NULL,
              genre varchar(30) DEFAULT NULL,
              members varchar(50) DEFAULT NULL,
              other_remarks longtext DEFAULT NULL,
              PRIMARY KEY (user_type_ID),
              FOREIGN KEY (type_ID) REFERENCES type(type_ID),
              FOREIGN KEY (user_ID) REFERENCES user(user_ID)

        );";
        $db->exec($sql);

        closeDatabase();
        $_SESSION["initDatabase"] = "Database successfully created";
    } catch (PDOException $ex) {
        $error_message = $ex->getMessage();
    }
}




//session_destroy();










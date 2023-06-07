<?php
global $userStore, $images, $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $db;

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

// initialize session variables
$_SESSION["user_ID"] = isset($_SESSION["user_ID"]) && is_string($_SESSION["user_ID"]) ? $_SESSION["user_ID"]: null;

$_SESSION["email"] = check_variable("email");
$_SESSION["password"] = check_variable("password");
$_SESSION["repeat_password"] = check_variable("repeat_password");
$_SESSION["name"] = check_variable("name");
$_SESSION["surname"] = check_variable("surname");
$_SESSION["address"] = check_variable("address");
$_SESSION["phone_number"] = check_variable("phone_number");
$_SESSION["genre"] = check_variable("genre");
$_SESSION["members"] = check_variable("members");
$_SESSION["other_remarks"] = check_variable("other_remarks");
$_SESSION["street_name"] = check_variable("street_name");
$_SESSION["house_number"] = check_variable("house_number");
$_SESSION["postal_code"] = check_variable("postal_code");
$_SESSION["city"] = check_variable("city");

// change password
$_SESSION["old_password"] = check_variable("old_password");
$_SESSION["new_password"] = check_variable("new_password");
$_SESSION["repeat_new_password"] = check_variable("repeat_new_password");


// type
$_SESSION["type"] = check_variable("type");
$_SESSION["type_ID"] = ($_SESSION["type"] == "Musician") ? 1 : 2;
$_SESSION["Musician"] = ($_SESSION["type"] === "Musician") ? "checked" : "";
$_SESSION["Host"] = ($_SESSION["type"] === "Host") ? "checked" : "";

$error_message = "";

$_SESSION["registrationSuccessful"] = (isset($_SESSION["registrationSuccessful"])) ? $_SESSION["registrationSuccessful"] : false;
$_SESSION["loginSuccessful"] = (isset($_SESSION["loginSuccessful"])) ? $_SESSION["loginSuccessful"] : false;

// initialize session variables
$profile_header_box = "<div id='name'>".$_SESSION["name"]." ".$_SESSION["surname"].'</div><div id="type">'.$_SESSION["type"]."</div>";
$_SESSION["normalHeader"] = (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) ? "hidden": "visible";
$_SESSION["profileHeader"] = (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) ? "visible": "hidden";
$_SESSION["profileHeaderBox"] = (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) ? $profile_header_box : "";



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               post methods                                                         */
/* ------------------------------------------------------------------------------------------------------------------ */


/**
 * If a user clicks on logout or on Sign up
 */
if(isset($_POST["reset"])) {
    reset_variables();
}


/**
 * If a user clicks on register
 */
if(isset($_POST["register"])) {
    try {
        if($_SESSION["password"] === $_SESSION["repeat_password"]) {
            $_SESSION["user_ID"] = $userStore->register($_SESSION["type_ID"], $_SESSION["address"], $_SESSION["name"], $_SESSION["surname"], $_SESSION["password"], $_SESSION["phone_number"], $_SESSION["email"] );

            $_SESSION["loggedIn"] = true;

            header("Location: " . getNextUrl($step));
            exit();
        } else {
            $_SESSION["password"] = "";
            $_SESSION["repeat_password"] = "";
            throw new Exception("Passwords must be the same.");
        }
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}


/**
 * If a user clicks on login
 */
if(isset($_POST["login"])) {
    try {
        $user = $userStore->login($_SESSION["email"], $_SESSION["password"]);

        set_variables($user);
        $_SESSION["loggedIn"] = true;

        header("Location: index.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}

/**
 * If a user clicks on login
 */
if(isset($_POST["logout"])) {
    try {
        reset_variables();

        $_SESSION["loggedIn"] = false;

        header("Location: index.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}


/**
 * If a user clicks on delete account
 */
if(isset($_POST["delete"])) {
    try {
        $userStore->delete();

        $_SESSION["loggedIn"] = false;

        header("Location: index.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}


/**
 * If a user wants to change passwords
 */
if(isset($_POST["change_password"])) {
    try {
        if($_SESSION["old_password"] === $_SESSION["password"]) {
            if($_SESSION["new_password"] === $_SESSION["repeat_new_password"]) {
                $userStore->update($_SESSION["new_password"]);
                
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION["old_password"] = "";
                $_SESSION["new_password"] = "";
                $_SESSION["repeat_new_password"] = "";
                throw new Exception("Passwords must be the same.");
            }
        } else {
            $_SESSION["old_password"] = "";
            $_SESSION["new_password"] = "";
            $_SESSION["repeat_new_password"] = "";
            throw new Exception("Passwords must be the same.");
        }
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                   functions                                                                        */
/* ------------------------------------------------------------------------------------------------------------------ */


/**
 * checks if a post variable was set then if a session
 * variable is set, else the variable is set to an empty string
 */
function check_variable($var): String {
    if (isset($_POST["$var"]) && is_string($_POST["$var"])) {
        return htmlspecialchars($_POST["$var"]);
    } elseif (isset($_SESSION["$var"]) && is_string($_SESSION["$var"])) {
        return $_SESSION["$var"];
    } else {
        return "";
    }
}


/**
 * unsets all the session variables
 */
function reset_variables(): void {
    session_destroy();
}


/**
 * sets all the session variables on login
 */
function set_variables($user): void {
    $_SESSION["email"] = $user->email;
    $_SESSION["password"] = $user->password;
    $_SESSION["name"] = $user->name;
    $_SESSION["surname"] = $user->surname;
    $_SESSION["address"] = $user->address;
    $_SESSION["phone_number"] = $user->phone_number;
    $_SESSION["genre"] = $user->genre;
    $_SESSION["members"] = $user->members;
    $_SESSION["other_remarks"] = $user->other_remarks;
    $_SESSION["street_name"] = $user->street_name;
    $_SESSION["house_number"] = $user->house_number;
    $_SESSION["postal_code"] = $user->postal_code;
    $_SESSION["city"] = $user->city;
}




/* ------------------------------------------------------------------------------------------------------------------ */
/*                                   change header elements on logged in status                                       */
/* ------------------------------------------------------------------------------------------------------------------ */






/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          functions to switch urls in register                                      */
/* ------------------------------------------------------------------------------------------------------------------ */



// gets the url for the next step in the register progressbar
function getNextUrl($var): String {
    $var++;
    return "register.php?step=" . $var;
}

// gets the url for the last step in the register progressbar
function getLastUrl($var): String {
    $var--;
    return "register.php?step=" . $var;
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                 initialize upload and verification                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */



// initialize session variable
$_SESSION["profile-Picture-Small"] = (isset($_SESSION["profile-Picture-Small"])) ? $_SESSION["profile-Picture-Small"] : "../resources/images/profile/default/defaultSmall.png";
$_SESSION["profile-Picture-Large"] = (isset($_SESSION["profile-Picture-Large"])) ? $_SESSION["profile-Picture-Large"] : "../resources/images/profile/default/defaultLarge.jpeg";

$_SESSION["error"] = "";

$images = [];
$newImage["name"] = "";
$newImage["path"] = "";

$file = file_get_contents("../resources/json/images.json", true);
$images = json_decode($file, false);



if (isset($_POST["profile-Picture-Small"])) {
    $_SESSION["profile-Picture-Small"] = "../resources/images/profile/default/".verifyImage("profile-Picture-Small", "profile/default");

} elseif (isset($_POST["profile-Picture-Large"])) {
    $_SESSION["profile-Picture-Large"] = "../resources/images/profile/default/".verifyImage("profile-Picture-Large", "profile/default");

} elseif (isset($_POST["newImage"])) {
    $fileName = verifyImage("newImage", "profile/custom");
    $path = "../resources/images/profile/custom/".$fileName;

    if(!empty($fileName)) {
        $newImage["name"] = $fileName;
        $newImage["path"] = $path;
        addImageItems($newImage);
    }
}



function addImageItems($newImage): void {
    global $images;
    $images[] = (object) $newImage;
    file_put_contents("../resources/json/images.json", json_encode($images));
}



function getImageItems($public): void {
    global $images;
    if($public && empty($images)) {
        echo "No Images were Uploaded.";
    } else {
        foreach ($images as $image) {
            echo "<img src=".$image -> path.' alt="could not load Image">';
        }
    }
}



function verifyImage($name, $type): String {
    try {
        $file_name = $_FILES["$name"]["name"];
        $file_size = $_FILES["$name"]["size"];
        $file_tmp = $_FILES["$name"]["tmp_name"];
        $file_format = strtolower(pathinfo($_FILES["$name"]["name"], PATHINFO_EXTENSION));
        $expected_format = array("jpeg","jpg","png");

        // checking file format
        if (!in_array($file_format, $expected_format)) {
            throw new RuntimeException("invalid format");
        }

        // checking image size
        if ($file_size > 2000000) {
            throw new RuntimeException("exceeds filesize limit");
        }

        // moving file to dictionary
        if (!move_uploaded_file($file_tmp,"../resources/images/".$type."/".$file_name)) {
            throw new RuntimeException("failed to upload image");
        }

        return $file_name;
    } catch (RuntimeException $e) {
        $_SESSION["error"] = $e->getMessage();
        return "";
    }
}




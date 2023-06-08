<?php
global $userStore, $addressStore, $images, $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $db;

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */


// init user and address session variable
$_SESSION["user"] = $_SESSION["user"] ?? new User();
$_SESSION["address"] = $_SESSION["address"] ?? new Address();

// if post request were send the input is put in the object
isset($_POST["type"]) && is_string($_POST["type"])   ?   $_SESSION["user"]->setType(htmlspecialchars($_POST["type"]))   :   "";
isset($_POST["name"]) && is_string($_POST["name"])   ?   $_SESSION["user"]->setName(htmlspecialchars($_POST["name"]))   :   "";
isset($_POST["surname"]) && is_string($_POST["surname"])   ?   $_SESSION["user"]->setSurname(htmlspecialchars($_POST["surname"]))   :   "";
isset($_POST["phone_number"]) && is_string($_POST["phone_number"])   ?   $_SESSION["user"]->setPhoneNumber(htmlspecialchars($_POST["phone_number"]))   :   "";
isset($_POST["email"]) && is_string($_POST["email"])   ?   $_SESSION["user"]->setEmail(htmlspecialchars($_POST["email"]))   :   "";
isset($_POST["genre"]) && is_string($_POST["genre"])   ?   $_SESSION["user"]->setGenre(htmlspecialchars($_POST["genre"]))   :   "";
isset($_POST["members"]) && is_string($_POST["members"])   ?   $_SESSION["user"]->setMembers(htmlspecialchars($_POST["members"]))   :   "";
isset($_POST["other_remarks"]) && is_string($_POST["other_remarks"])   ?   $_SESSION["user"]->setOtherRemarks(htmlspecialchars($_POST["other_remarks"]))   :   "";
isset($_POST["street_name"]) && is_string($_POST["street_name"])   ?   $_SESSION["address"]->setStreetName(htmlspecialchars($_POST["street_name"]))   :   "";
isset($_POST["house_number"]) && is_string($_POST["house_number"])   ?   $_SESSION["address"]->setHouseNumber(htmlspecialchars($_POST["house_number"]))  :   "";
isset($_POST["postal_code"]) && is_string($_POST["postal_code"])   ?   $_SESSION["address"]->setPostalCode(htmlspecialchars($_POST["postal_code"]))   :   "";
isset($_POST["city"]) && is_string($_POST["city"])   ?   $_SESSION["address"]->setCity(htmlspecialchars($_POST["city"]))   :   "";

// password variables
$password = isset($_POST["password"]) && is_string($_POST["password"])   ?   htmlspecialchars($_POST["password"])   :   "";
$repeat_password = isset($_POST["repeat_password"]) && is_string($_POST["repeat_password"])   ?   htmlspecialchars($_POST["repeat_password"])   :   "";
$old_password = isset($_POST["old_password"]) && is_string($_POST["old_password"])   ?   htmlspecialchars($_POST["old_password"])   :   "";
$new_password = isset($_POST["new_password"]) && is_string($_POST["new_password"])   ?   htmlspecialchars($_POST["new_password"])   :   "";
$repeat_new_password = isset($_POST["repeat_new_password"]) && is_string($_POST["repeat_new_password"])   ?   htmlspecialchars($_POST["repeat_new_password"])   :   "";

// for the checkbox
$_SESSION["Musician"] = ($_SESSION["user"]->getType() === "Musician") ? "checked" : "";
$_SESSION["Host"] = ($_SESSION["user"]->getType() === "Host") ? "checked" : "";

$error_message = "";

// initialize session variables
$profile_header_box = "<div id='name'>".$_SESSION["user"]->getName()." ".$_SESSION["user"]->getSurname().'</div><div id="type">'.$_SESSION["user"]->getType()."</div>";
$_SESSION["normalHeader"] = (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) ? "hidden": "visible";
$_SESSION["profileHeader"] = (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) ? "visible": "hidden";
$_SESSION["profileHeaderBox"] = (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) ? $profile_header_box : "";

$_SESSION["profile-Picture-Small"] = (isset($_SESSION["profile-Picture-Small"])) ? $_SESSION["profile-Picture-Small"] : "../resources/images/profile/default/defaultSmall.png";
$_SESSION["profile-Picture-Large"] = (isset($_SESSION["profile-Picture-Large"])) ? $_SESSION["profile-Picture-Large"] : "../resources/images/profile/default/defaultLarge.jpeg";



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
        if($password === $repeat_password) {
            $_SESSION["address"] = $addressStore->create($_SESSION["address"]);

            $_SESSION["user"]->setPassword($password);
            $_SESSION["user"] = $userStore->create($_SESSION["user"]);
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
        $_SESSION["user"] = $_SESSION["userStore"]->login($_SESSION["user"]->getEmail(), $password);
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
        $userStore->delete($_SESSION["user"]->getUserID());
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
                $userStore->update($_SESSION["user_ID"], array("password" => $_SESSION["new_password"]));

                $_SESSION["password"] = $_SESSION["new_password"];

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
            throw new Exception("Old Password is incorrect.");
        }
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}



/**
 *  If a user wants to change user data
 */
if(isset($_POST["update_profile"])) {
    try {
        $array = array(
            "type" => $_SESSION["type"],
            "name" => $_SESSION["name"],
            "surname" => $_SESSION["surname"],
            "password" => $_SESSION["password"],
            "phone_number" => $_SESSION["phone_number"],
            "email" => $_SESSION["email"]
            );

        $userStore->update($_SESSION["user_ID"], $array);

        header("Location: profile.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }

}



/**
 *  If a user wants to change the small profile picture
 */
if (isset($_POST["profile_picture_small"])) {
    try {
        $_SESSION["profile_picture_small"] = "../resources/images/profile/default/".verifyImage("profile_picture_small", "profile/default");
        $userStore->update($_SESSION["user_ID"], $array);
    } catch (RuntimeException $e) {
        $_SESSION["error"] = $e->getMessage();
    }
}



/**
 *  If a user wants to change the large profile picture
 */
if (isset($_POST["profile_picture_large"])) {
    try {
        $_SESSION["profile_picture_large"] = "../resources/images/profile/default/" . verifyImage("profile_picture_large", "profile/default");
        $userStore->update($_SESSION["user_ID"], array("profile_picture_large" => $_SESSION["profile_picture_large"]));
    } catch (RuntimeException $e) {
        $_SESSION["error"] = $e->getMessage();
    }
}



/**
 *  If a user wants to add an image to the profile gallery
 */
if (isset($_POST["newImage"])) {
    try {
        $fileName = verifyImage("newImage", "profile/custom");
        $path = "../resources/images/profile/custom/".$fileName;
        $userStore->update($_SESSION["user_ID"], array("profile_gallery" => $path));
    } catch (RuntimeException $e) {
        $_SESSION["error"] = $e->getMessage();
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
    $_SESSION["user_ID"] = $user->getUser_ID();
    $_SESSION["type"] = $user->getType();
    $_SESSION["email"] = $user->getEmail();
    $_SESSION["password"] = $user->getPassword();
    $_SESSION["name"] = $user->getName();
    $_SESSION["surname"] = $user->getSurname();
    $_SESSION["address"] = $user->getAddress();
    $_SESSION["phone_number"] = $user->getPhone_number();
    $_SESSION["genre"] = $user->getGenre();
    $_SESSION["members"] = $user->getMembers();
    $_SESSION["other_remarks"] = $user->getOther_remarks();
}



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
}




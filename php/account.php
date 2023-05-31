<?php
global $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3;

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
    unset($_SESSION["profile-Picture-Small"]);
    unset($_SESSION["profile-Picture-Large"]);
    unset($_SESSION["Image1"]);
    unset($_SESSION["Image2"]);
    unset($_SESSION["Image3"]);
    unset($_SESSION["Image4"]);
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */



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

$_SESSION["musician"] = "";
$_SESSION["host"] = "";

if($_SESSION["type"] === "musician") {
    $_SESSION["musician"] = "checked";
} elseif ($_SESSION["type"] === "host") {
    $_SESSION["host"] = "checked";
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               Register checking                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */



$error_message = "";

if(isset($_POST["register"])) {
    if($_SESSION["password"] === $_SESSION["repeatPassword"]) {
        // todo: if password and email already exist in database, then continue, else error message
        header("Location: " . getNextUrl($step));
        exit();

    } else {
        $error_message = "<p>passwords must be the same</p>";
    }
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                 Login checking                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */







/* ------------------------------------------------------------------------------------------------------------------ */
/*                                   change header elements on logged in status                                       */
/* ------------------------------------------------------------------------------------------------------------------ */



// switches the logged in status
if (isset($_POST["login"])) {
    $_SESSION["loggedIn"] = true;
} elseif (isset($_POST["logout"])) {
    $_SESSION["loggedIn"] = false;
}

$_SESSION["normalHeader"] = "";
$_SESSION["profileHeader"] = "";
$_SESSION["profileHeaderBox"] = "";

// switches the header
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    $_SESSION["normalHeader"] = "hidden";
    $_SESSION["profileHeader"] = "visible";
    $_SESSION["profileHeaderBox"] = "<div id='name'>".$_SESSION["name"]." ".$_SESSION["surname"]."</div><div id='type'>".$_SESSION["type"]."</div>";
} elseif (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === false) {
    $_SESSION["normalHeader"] = "visible";
    $_SESSION["profileHeader"] = "hidden";
}




/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          functions to switch urls in register                                      */
/* ------------------------------------------------------------------------------------------------------------------ */



function getNextUrl($var): String {
    $var++;
    return "register.php?step=" . $var;
}

function getLastUrl($var): String {
    $var--;
    return "register.php?step=" . $var;
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          Image verification                                                        */
/* ------------------------------------------------------------------------------------------------------------------ */



$_SESSION["profile-Picture-Small"] = (isset($_SESSION["profile-Picture-Small"])) ? $_SESSION["profile-Picture-Small"] : "../resources/images/profile/defaultSmall.png";
$_SESSION["profile-Picture-Large"] = (isset($_SESSION["profile-Picture-Large"])) ? $_SESSION["profile-Picture-Large"] : "../resources/images/profile/defaultLarge.jpeg";
$_SESSION["Image1"] = (isset($_SESSION["Image1"])) ? $_SESSION["Image1"] : "../resources/images/profile/imagePlaceholder.jpeg";
$_SESSION["Image2"] = (isset($_SESSION["Image2"])) ? $_SESSION["Image2"] : "../resources/images/profile/imagePlaceholder.jpeg";
$_SESSION["Image3"] = (isset($_SESSION["Image3"])) ? $_SESSION["Image3"] : "../resources/images/profile/imagePlaceholder.jpeg";
$_SESSION["Image4"] = (isset($_SESSION["Image4"])) ? $_SESSION["Image4"] : "../resources/images/profile/imagePlaceholder.jpeg";




$_SESSION["error"] = "";

if(isset($_POST["profile-Picture-Small"])) {
    $_SESSION["profile-Picture-Small"] = "../resources/images/profile/".verifyImage("profile-Picture-Small", "profile");
} elseif(isset($_POST["profile-Picture-Large"])) {
    $_SESSION["profile-Picture-Large"] = "../resources/images/profile/".verifyImage("profile-Picture-Large", "profile");
} elseif(isset($_POST["Image1"])) {
    $_SESSION["Image1"] = "../resources/images/profile/".verifyImage("Image1", "profile");
} elseif(isset($_POST["Image2"])) {
    $_SESSION["Image2"] = "../resources/images/profile/".verifyImage("Image2", "profile");
} elseif(isset($_POST["Image3"])) {
    $_SESSION["Image3"] = "../resources/images/profile/".verifyImage("Image3", "profile");
} elseif(isset($_POST["Image4"])) {
    $_SESSION["Image4"] = "../resources/images/profile/".verifyImage("Image4", "profile");
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






//session_destroy();






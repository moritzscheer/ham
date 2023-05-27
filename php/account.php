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
    $_SESSION["profileHeaderBox"] = "<div>".$_SESSION["name"]." ".$_SESSION["surname"]."</div><div>".$_SESSION["type"]."</div>";
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
/*                                          profile Picture verification                                              */
/* ------------------------------------------------------------------------------------------------------------------ */



$_SESSION["profilePicture"] = "../resources/images/profile/default.png";
$_SESSION["error"] = "";


if(isset($_POST["profilePicture"])) {
    try {
        $_SESSION["error"] = "1234";

        if (!isset($_FILES["profilePicture"]["error"]) || is_array($_FILES["profilePicture"]["error"])) {
            throw new RuntimeException('Invalid parameters.');
        }

        // Check the Files value
        switch ($_FILES["profilePicture"]["error"]) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException("No file sent.");
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException("Exceeded filesize limit.");
            default:
                throw new RuntimeException("Unknown errors.");
        }

        // Check the Files size
        if ($_FILES["profilePicture"]["size"] > 1000000) {
            throw new RuntimeException("Exceeded filesize limit.");
        }

        // Check MIME Type
        $fInfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $fInfo -> file($_FILES["profilePicture"]["tmp_name"]),
                array(
                    "jpg" => "image/jpeg",
                    "png" => "image/png",
                ),
                true
            )) {
            throw new RuntimeException("Invalid file format.");
        }

        // On this example, obtain safe unique name from its binary data.
        if (!move_uploaded_file($_FILES["profilePicture"]["tmp_name"],
            sprintf("../resources/images/profile/%s.%s", sha1_file($_FILES["profilePicture"]['tmp_name']), $ext))
        ) {
            throw new RuntimeException("Failed to move uploaded file.");
        }

        $_SESSION["profilePicture"] = "../resources/images/profile/custom.png";

    } catch (RuntimeException $e) {
        $_SESSION["error"] = $e->getMessage();
    }
}




//session_destroy();






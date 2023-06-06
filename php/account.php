<?php
global $images, $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $db;

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                          reset for all account variables                                           */
/* ------------------------------------------------------------------------------------------------------------------ */

// unsets all the session variables
function resetVariables(): void {
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
    unset($_SESSION["newImage"]);
    unset($_SESSION["initDatabase"]);
}

if(isset($_POST["reset"]) || isset($_POST["logout"])) {
    resetVariables();
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

$_SESSION["street_name"] = checkVariable("street_name");
$_SESSION["house_number"] = checkVariable("house_number");
$_SESSION["postal_code"] = checkVariable("postal_code");
$_SESSION["city"] = checkVariable("city");

$_SESSION["Musician"] = "";
$_SESSION["Host"] = "";

if($_SESSION["type"] === "Musician") {
    $_SESSION["Musician"] = "checked";
} elseif ($_SESSION["type"] === "Host") {
    $_SESSION["Host"] = "checked";
}

$error_message = "";
$_SESSION["registrationSuccessful"] = (isset($_SESSION["registrationSuccessful"])) ? $_SESSION["registrationSuccessful"] : false;
$_SESSION["loginSuccessful"] = (isset($_SESSION["loginSuccessful"])) ? $_SESSION["loginSuccessful"] : false;


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               Register checking                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */



if(isset($_POST["register"])) {
    try {
        if($_SESSION["password"] === $_SESSION["repeatPassword"]) {
            connectToDatabase();
            $db->exec("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
            $db->beginTransaction();

            /**
             *  checking if email already exist
             */
            $sql = "SELECT * FROM user WHERE email = '".$_SESSION["email"]."';";
            $result = $db->exec($sql);
            if ($result > 0) {
                throw new Exception("Email already exist");
            }
            
            /**
             *  checking if password already exist
             */
            $sql = "SELECT * FROM user WHERE password = '".$_SESSION["password"]."';";
            $result = $db->exec($sql);
            if ($result > 0) {
                throw new Exception("Password already exist");
            }

            // change type to typeID
            ($_SESSION["type"] == "Musician") ? $type = 1 : $type = 2;
            
            /**
             *  inserting data in the user and address table
             */
            if($_SESSION["street_name"] != null || $_SESSION["house_number"] != null || $_SESSION["postal_code"] != null || $_SESSION["city"] != null) {
                // if any data is given for address put in data
                $sql = "INSERT INTO address VALUES ('null', '".$_SESSION["street_name"]."', '".$_SESSION["house_number"]."', '".$_SESSION["postal_code"]."', '".$_SESSION["city"]."');";
                $db->exec($sql);
                $sql = "INSERT INTO user VALUES ('null', '".$type."', '".LAST_INSERT_ID()."', '".$_SESSION["name"]."', '".$_SESSION["surname"]."', '".$_SESSION["password"]."', '".$_SESSION["phoneNumber"]."', '".$_SESSION["email"]."');";
                $db->exec($sql);
            } else {
                // if no data is given set addressID to null
                $sql = "INSERT INTO user VALUES ('null', '".$type."', 'null', '".$_SESSION["name"]."', '".$_SESSION["surname"]."', '".$_SESSION["password"]."', '".$_SESSION["phoneNumber"]."', '".$_SESSION["email"]."');";
                $db->exec($sql);
            }

            $db->commit();
            closeDatabase();
            header("Location: " . getNextUrl($step));
            exit();
        } else {
            throw new Exception("Passwords must be the same.");
        }
    } catch (Exception $ex) {
        $error_message = "Error: " . $ex->getMessage();
    }
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                 Login checking                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */



if(isset($_POST["login"])) {
    try {
        connectToDatabase();

        // checking if email and password already exist
        $sqlLogin = "SELECT email, password FROM user WHERE email = '".$_SESSION["email"]."' AND password = '".$_SESSION["password"]."';";
        $resultLogin = $db->query($sqlLogin);

        if (mysqli_num_rows($resultLogin) == 0) {
            throw new Exception("Email or Password are not correct!");
        }

        closeDatabase();
        header("Location: index.php");
        exit();
    } catch (Exception $ex) {           
        $error_message = $ex->getMessage();
    }
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                 delete User                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */



function deleteUser(): void {
    global $db, $error_message;
    try {
        connectToDatabase();

        $sql = "DELETE FROM user WHERE email = '".$_SESSION["email"]."';";
        $db->query($sql);

        closeDatabase();
        $LoginSuccessful = "true";
    } catch (Exception $ex) {
        $error_message = "Error: " . $ex->getMessage();
    }
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                   change header elements on logged in status                                       */
/* ------------------------------------------------------------------------------------------------------------------ */



// initialize session variables
$_SESSION["normalHeader"] = "";
$_SESSION["profileHeader"] = "";
$_SESSION["profileHeaderBox"] = "";


// switches the logged in status
if ($_SESSION["loginSuccessful"] === true || $_SESSION["registrationSuccessful"] === true) {
    $_SESSION["loggedIn"] = true;
} elseif (isset($_POST["logout"])) {
    $_SESSION["loggedIn"] = false;
}

// switches the header
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    $_SESSION["normalHeader"] = "hidden";
    $_SESSION["profileHeader"] = "visible";
    $_SESSION["profileHeaderBox"] = "<div id='name'>".$_SESSION["name"]." ".$_SESSION["surname"].'</div><div id="type">'.$_SESSION["type"]."</div>";
} elseif (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === false) {
    $_SESSION["normalHeader"] = "visible";
    $_SESSION["profileHeader"] = "hidden";
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




<?php
global $userStore, $addressStore, $blobObj, $registerFlag, $db, $success_message, $step;

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               loggedIn changes                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */

use Item\User;

// init loggedIn session variable
$_SESSION["loggedIn"] = $_SESSION["loggedIn"] ?? array("status" => false, "profile_small" => "../resources/images/profile/default/defaultSmall.png");

if($_SESSION["loggedIn"]["status"] === true) {
    $_SESSION["user_ID"] = $_SESSION["loggedIn"]["user"]->getUserID();

    $profile_header_box =                           
        '<div id="name">                                   '.
        $_SESSION["loggedIn"]["user"]->getName().' '.
        $_SESSION["loggedIn"]["user"]->getSurname().
        '</div>                                            '.
        '<div id="type">                                   '.
        $_SESSION["loggedIn"]["user"]->getType().
        '</div>                                            ';

    $_SESSION["Musician"] = ($_SESSION["loggedIn"]["user"]->getType() === "Musician") ? "checked" : "";
    $_SESSION["Host"] = ($_SESSION["loggedIn"]["user"]->getType() === "Host") ? "checked" : "";
} else {
    $_SESSION["user_ID"] = "";
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

// init tmp session variable (important for register)
$_SESSION["user"] = update_user_variable($_SESSION["user"] ?? new User());

// password variables
$password = isset($_POST["password"]) && is_string($_POST["password"])   ?   $_POST["password"]   :   "";
$repeat_password = isset($_POST["repeat_password"]) && is_string($_POST["repeat_password"])   ?   $_POST["repeat_password"]   :   "";
$old_password = isset($_POST["old_password"]) && is_string($_POST["old_password"])   ?   $_POST["old_password"]   :   "";
$new_password = isset($_POST["new_password"]) && is_string($_POST["new_password"])   ?   $_POST["new_password"]   :   "";
$repeat_new_password = isset($_POST["repeat_new_password"]) && is_string($_POST["repeat_new_password"])   ?   $_POST["repeat_new_password"]   :   "";

// for the checkbox in profile
$_SESSION["Musician"] = ($_SESSION["user"]->getType() === "Musician") ? "checked" : "";
$_SESSION["Host"] = ($_SESSION["user"]->getType() === "Host") ? "checked" : "";

// Which header should be shown
$_SESSION["normalHeader"] = $_SESSION["loggedIn"]["status"] === true ? "hidden" : "visible";
$_SESSION["profileHeader"] = $_SESSION["loggedIn"]["status"] === false ? "hidden" : "visible";
$_SESSION["profileHeaderBox"] = $_SESSION["loggedIn"]["status"] === true ? $profile_header_box : "";

$_SESSION["delete"] = $_SESSION["delete"] ?? "";
$_SESSION["token"] = $_SESSION["token"] ?? "";
$_SESSION["hintField"] = $_SESSION["hintField"] ?? array("showAlways" => false, "message" => "", "visibility" => "", "button" => "hidden");

$error_message = "";

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
            // sets password in user object
            $_SESSION["user"]->setPassword(password_hash($password, PASSWORD_DEFAULT));

            // creates user and address in store
            $_SESSION["user"] = $userStore->create($_SESSION["user"]);

            // sets the loggedIn session variable with user and profile picture for header
            $image = getImage($_SESSION["user"]->getUserID(), "profile_small", "../resources/images/profile/default/defaultSmall.png", false);
            $_SESSION["loggedIn"] = array("status" => true, "user" => $_SESSION["user"], "profile_small" => $image);
            unset($_SESSION["user"]);

            $_SESSION["success_message"] = "Success! Welcome to our Team.";
            $_SESSION["hintField"]["showAlways"] = true;
            $_SESSION["token"] = uniqid();

            // redirect to next step
            header("Location: " . getNextUrl($step));
            exit();
        } else {
            $password = "";
            $repeat_password = "";
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
        // gets user and address from store
        $_SESSION["user"] = $userStore->login($_SESSION["user"]->getEmail(), $password);

        // sets the loggedIn session variable with user and profile picture for header
        $image = getImage($_SESSION["user"]->getUserID(), "profile_small", "../resources/images/profile/default/defaultSmall.png", false);
        $_SESSION["loggedIn"] = array("status" => true, "user" => $_SESSION["user"], "profile_small" => $image);
        unset($_SESSION["user"]);

        $_SESSION["token"] = uniqid();

        // redirect to homepage
        header("Location: index.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}

/**
 * If a user clicks on login
 */
if(isset($_POST["logout"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        reset_variables();

        // redirect to homepage
        header("Location: index.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}

/**
 * If a user clicks on delete account
 */
if(isset($_POST["delete"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        // delete all user information
        $userStore->delete($_SESSION["loggedIn"]["user"]->getUserID());
        $ids = $blobObj->queryOwnIDs($_SESSION["loggedIn"]["user"]->getUserID());
        foreach ($ids as $image) {
            $blobObj->delete($image[0]);
        }

        reset_variables();

        // redirect to homepage
        header("Location: index.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}

/**
 * If a user wants to change passwords
 */
if(isset($_POST["change_password"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        if($new_password === $repeat_new_password) {
            // changes password in store
            $_SESSION["loggedIn"]["user"] = $userStore->changePassword($_SESSION["loggedIn"]["user"], $old_password, $new_password);

            // redirect to homepage
            header("Location: profile.php");
            exit();
        } else {
            throw new Exception("Passwords must be the same.");
        }
    } catch (Exception $ex) {
        $old_password = "";
        $new_password = "";
        $repeat_new_password = "";
        $error_message = $ex->getMessage();
    }
}

/**
 *  If a user wants to change user data
 */
if(isset($_POST["update_profile"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        $user = update_user_variable($_SESSION["loggedIn"]["user"]);
        $_SESSION["loggedIn"]["user"] = $userStore->update($user);

        // redirect to profile page
        header("Location: profile.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}

/**
 *  if a user opens and closes the hints field
 */
if(isset($_POST["show_hint"]) && $_POST["token"] === $_SESSION["token"]) {
    if($_SESSION["hintField"]["visibility"] === "") {
        $_SESSION["hintField"]["message"] = $_POST["show_hint"];
        $_SESSION["hintField"]["visibility"] = "hintVisible";
    } else {
        $_SESSION["hintField"]["visibility"] = "";
        $_SESSION["hintField"]["showAlways"] = false;
    }
}

/**
 *  if a user wants to delete the account
 */
if(isset($_POST["onDeleteClicked"]) && $_POST["token"] === $_SESSION["token"]) {
    if($_SESSION["delete"] === "") {
        $_SESSION["delete"] = "visible";
    } else {
        $_SESSION["delete"] = "";

    }
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              view posts                                                            */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * If a user wants to view a profile page
 * $_POST["viewProfile"] contains the user_ID of the profile

 */
if(isset($_POST["viewProfile"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        if($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewProfile"]) {
            // sets the user variable to the loggedInUser (user variable is displayed in profile)
            $_SESSION["user"] = $_SESSION["loggedIn"]["user"];
            // sets the profile navigation to private -> with navigation buttons
            $_SESSION["navigation"] = "../php/includes/navigation/profile/private.php";
        } else {
            // sets the user variable to the user with the user_ID (user variable is displayed in profile)
            $_SESSION["user"] = $userStore->findOne($_POST["viewProfile"]);
            // sets the profile navigation to public -> without navigation buttons
            $_SESSION["navigation"] = "../php/includes/navigation/profile/public.php";
        }

        // sets the images of the profile via user_ID
        setProfileImages($_POST["viewProfile"], false);

        $_SESSION["hintField"]["visibility"] = "";
        $_SESSION["hintField"]["button"] = "hidden";

        // redirect to profile page
        header("Location: profile.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }
}

/**
 * If a user wants to view an edit profile page
 * $_POST["viewEditProfile"] contains the user_ID of the profile
 */
if(isset($_POST["viewEditProfile"]) && $_POST["token"] === $_SESSION["token"]) {
    if ($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewEditProfile"]) {
        // sets the profile navigation to private -> with navigation buttons
        $_SESSION["navigation"] = "../php/includes/navigation/profile/private.php";

        // sets the images of the profile via user_ID
        setProfileImages($_POST["viewEditProfile"], true);

        // adds the hint field
        $_SESSION["hintField"]["button"] = "visible";
        if($_SESSION["hintField"]["showAlways"] === true) {
            $_SESSION["hintField"]["visibility"] = "hintVisible";
            $_SESSION["hintField"]["message"] = 'Hint: To Change Images in Profile hover on an image and select "Edit Image".';
        }
        // redirect to edit profile page
        header("Location: editProfile.php");
        exit();
    }
}

/**
 * If a user wants to view the change password page
 * $_POST["viewChangePassword"] contains the user_ID of the profile
 */
if(isset($_POST["viewChangePassword"]) && $_POST["token"] === $_SESSION["token"]) {
    if ($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewChangePassword"]) {
        // sets the profile navigation to private -> with navigation buttons
        $_SESSION["navigation"] = "../php/includes/navigation/profile/private.php";

        // sets the images of the profile via user_ID
        setProfileImages($_POST["viewChangePassword"], false);

        $_SESSION["hintField"]["visibility"] = "";
        $_SESSION["hintField"]["button"] = "hidden";

        // redirect to change password page
        header("Location: changePassword.php");
        exit();
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                   functions                                                                        */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * checks the variables for the user
 * @param $user
 * @return User
 */
function update_user_variable($user): User {
    isset($_POST["type"]) && is_string($_POST["type"])   ?   $user->setType(htmlspecialchars($_POST["type"]))   :   "";
    isset($_POST["name"]) && is_string($_POST["name"])   ?   $user->setName(htmlspecialchars($_POST["name"]))   :   "";
    isset($_POST["surname"]) && is_string($_POST["surname"])   ?   $user->setSurname(htmlspecialchars($_POST["surname"]))   :   "";
    isset($_POST["phone_number"]) && is_string($_POST["phone_number"])   ?   $user->setPhoneNumber(htmlspecialchars($_POST["phone_number"]))   :   "";
    isset($_POST["email"]) && is_string($_POST["email"])   ?   $user->setEmail(htmlspecialchars($_POST["email"]))   :   "";
    isset($_POST["genre"]) && is_string($_POST["genre"])   ?   $user->setGenre(htmlspecialchars($_POST["genre"]))   :   "";
    isset($_POST["members"]) && is_string($_POST["members"])   ?   $user->setMembers(htmlspecialchars($_POST["members"]))   :   "";
    isset($_POST["other_remarks"]) && is_string($_POST["other_remarks"])   ?   $user->setOtherRemarks(htmlspecialchars($_POST["other_remarks"]))   :   "";
    isset($_POST["user_street_name"])&& is_string($_POST["user_street_name"])   ?   $user->setStreetName(htmlspecialchars($_POST["user_street_name"]))   :   "";
    isset($_POST["user_house_number"]) && is_string($_POST["user_house_number"])   ?   $user->setHouseNumber(htmlspecialchars($_POST["user_house_number"]))  :   "";
    isset($_POST["user_postal_code"]) && is_string($_POST["user_postal_code"])   ?   $user->setPostalCode(htmlspecialchars($_POST["user_postal_code"]))   :   "";
    isset($_POST["user_city"]) && is_string($_POST["user_city"])   ?   $user->setCity(htmlspecialchars($_POST["user_city"]))   :   "";
    return $user;
}

/**
 * unsets all the session variables
 */
function reset_variables(): void {
    session_destroy();
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               image functions                                                      */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * @param $user_ID
 * @param $isEdit
 * @return void
 */
function setProfileImages($user_ID, $isEdit) : void {
    $_SESSION["profile_small"] = getImage($user_ID, "profile_small", "../resources/images/profile/default/defaultSmall.png", false);
    $_SESSION["loggedIn"]["profile_small"] = $_SESSION["profile_small"];
    $_SESSION["profile_large"] = getImage($user_ID, "profile_large", "../resources/images/profile/default/defaultLarge.jpeg", false);
    $_SESSION["profile_gallery"] = getImage($user_ID, "profile_gallery", "../resources/images/profile/default/defaultGallery.jpeg", $isEdit);
}

/**
 * @param $user_ID
 * @param $category
 * @param $altUrl
 * @param $isEdit
 * @return string
 */
function getImage($user_ID, $category, $altUrl, $isEdit) : string {
    global $blobObj;

    try {
        $ids = $blobObj->queryID($user_ID, $category);

        $output = "";
        foreach ($ids as $image) {
            $a = $blobObj->selectBlob($image[0]);

            if($isEdit && $category === "profile_gallery") {
                $img =
                    '<div id="image">                                                                                              '.
                    '    <img src="data:' . $a['mime'] . ';base64,' . base64_encode($a['data']) . '" alt="could not load image"/>  '.
                    '    <label id="exit">X                                                                                        '.
                    '         <input type="submit" name="onDeleteImage" value="' . $image[0] . '">                                 '.
                    '    </label>                                                                                                  '.
                    '</div>                                                                                                        ';
            } else {
                $img = '<img src="data:' . $a['mime'] . ';base64,' . base64_encode($a['data']) . '" alt="could not load image"/>';
            }
            $category === "profile_gallery" ? $output .= $img : $output = $img;
        }
        return $output;
    } catch (RuntimeException $e) {
        if($category === "profile_gallery") {
            return $isEdit ? "" : "There are no Images uploaded!";
        } else {
            return '<img src="'.$altUrl.'" alt="could not load image"/>';
        }
    }
}

if (isset($_POST["onDeleteImage"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        // deletes image from store
        $blobObj->delete($_POST["onDeleteImage"]);

        // gets image gallery
        setProfileImages($_SESSION["loggedIn"]["user"]->getUserID(), true);
                                                                                
        // redirect to edit profile page
        header("Location: editProfile.php");
        exit();
    } catch (RuntimeException $e) {
        $error_message = $e->getMessage();
    }
}

/**
 * @param $name
 * @param $type
 * @return String
 */
function verifyImage($name, $type): String {
    $file_name = $_FILES[$name]["name"];
    $file_size = $_FILES[$name]["size"];
    $file_tmp = $_FILES[$name]["tmp_name"];
    $file_format = strtolower(pathinfo($_FILES[$name]["name"], PATHINFO_EXTENSION));
    $expected_format = array("jpeg","jpg","png");

    // checking file format
    if (!in_array($file_format, $expected_format)) {
        throw new RuntimeException("invalid format");
    }

    // checking image size
    if ($file_size > 8000000) {
        throw new RuntimeException("exceeds filesize limit");
    }

    // moving file to dictionary
    if (!move_uploaded_file($file_tmp,"../resources/images/".$type."/".$file_name)) {
        throw new RuntimeException("failed to upload image");
    }
    return $file_name;
}


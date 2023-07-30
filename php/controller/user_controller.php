<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                            import and autoload classes                                             */
/* ------------------------------------------------------------------------------------------------------------------ */

namespace php\controller;

global $userStore, $blobObj, $step, $error_message, $geoLocApi;

use Exception;
use php\includes\items\User;
use RuntimeException;

require $_SERVER['DOCUMENT_ROOT'] . '/autoloader.php';

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               loggedIn changes                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */


// init loggedIn session variable
$_SESSION["loggedIn"] = $_SESSION["loggedIn"] ?? array(
    "status" => false,
    "profile_small" => "../resources/images/profile/default/defaultSmall.png",
    "user_ID" => "",
    "Musician" => "",
    "Host" => ""
);

$profile_header_box = "";

if ($_SESSION["loggedIn"]["status"] === true) {
    $_SESSION["loggedIn"]["user_ID"] = $_SESSION["loggedIn"]["user"]->getUserID();
    $_SESSION["dsr"] = ($_SESSION["loggedIn"]["user"]->getDsr() === "n") ? "disabled" : "";

    $profile_header_box =
        '<div id="name">                                   '.
        $_SESSION["loggedIn"]["user"]->getName().' '.
        $_SESSION["loggedIn"]["user"]->getSurname().
        '</div>                                            '.
        '<div id="type">                                   '.
        $_SESSION["loggedIn"]["user"]->getType().
        '</div>                                            ';
}
/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

// init tmp session variable (important for register and profile)
$_SESSION["user"] = $_SESSION["user"] ?? new User();

// password variables
$password = isset($_POST["password"]) && is_string($_POST["password"])   ?   $_POST["password"]   :   "";
$repeat_password = isset($_POST["repeat_password"]) && is_string($_POST["repeat_password"])   ?   $_POST["repeat_password"]   :   "";
$old_password = isset($_POST["old_password"]) && is_string($_POST["old_password"])   ?   $_POST["old_password"]   :   "";
$new_password = isset($_POST["new_password"]) && is_string($_POST["new_password"])   ?   $_POST["new_password"]   :   "";
$repeat_new_password = isset($_POST["repeat_new_password"]) && is_string($_POST["repeat_new_password"])   ?   $_POST["repeat_new_password"]   :   "";

// Which header should be shown
$_SESSION["normalHeader"] = $_SESSION["loggedIn"]["status"] === true ? "hidden" : "visible";
$_SESSION["profileHeader"] = $_SESSION["loggedIn"]["status"] === false ? "hidden" : "visible";
$_SESSION["profileHeaderBox"] = $_SESSION["loggedIn"]["status"] === true ? $profile_header_box : "";

$_SESSION["Host"] = $_SESSION["Host"] ?? "";
$_SESSION["delete"] = $_SESSION["delete"] ?? "";
$_SESSION["token"] = $_SESSION["token"] ?? "";
$_SESSION["hintField"] = $_SESSION["hintField"] ?? array("showAlways" => false, "message" => "", "visibility" => "", "button" => "hidden");

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               post methods                                                         */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * If a user clicks on logout or on Sign up
 */
if (isset($_POST["reset"])) {
    reset_variables();
}

/**
 * If a user clicks on register
 */
if (isset($_POST["register"])) {
    try {
        if ($password === $repeat_password) {
            // puts post requests in user object
            $_SESSION["user"] = update_user_variable($_SESSION["user"]);

            // sets password and dsr in user object
            $_SESSION["user"]->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $_SESSION["user"]->setDsr("y");

            // creates user and address in store
            $_SESSION["user"] = $userStore->create($_SESSION["user"]);

            // sets the loggedIn session variable with user and profile picture for header
            $image = getImage($_SESSION["user"]->getUserID(), "profile_small", "../resources/images/profile/default/defaultSmall.png", false);
            $_SESSION["loggedIn"]["status"] = true;
            $_SESSION["loggedIn"]["user"] = $_SESSION["user"];
            $_SESSION["loggedIn"]["profile_small"] = $image;
            $_SESSION["loggedIn"]["Musician"] = $_SESSION["user"]->getMusicianCheckBox();
            $_SESSION["loggedIn"]["Host"] = $_SESSION["user"]->getHostCheckBox();

            unset($_SESSION["user"]);

            $_SESSION["success_message"] = "Success! Welcome to our Team.";
            $_SESSION["hintField"]["show"] = true;
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
if (isset($_POST["login"])) {
    try {
        // puts post requests in user object
        $_SESSION["user"] = update_user_variable($_SESSION["user"]);

        // gets user and address from store
        $_SESSION["user"] = $userStore->login($_SESSION["user"]->getEmail(), $password);

        // sets the loggedIn session variable with user and profile picture for header
        $image = getImage($_SESSION["user"]->getUserID(), "profile_small", "../resources/images/profile/default/defaultSmall.png", false);
        $_SESSION["loggedIn"]["status"] = true;
        $_SESSION["loggedIn"]["user"] = $_SESSION["user"];
        $_SESSION["loggedIn"]["profile_small"] = $image;
        $_SESSION["loggedIn"]["Musician"] = $_SESSION["user"]->getMusicianCheckBox();
        $_SESSION["loggedIn"]["Host"] = $_SESSION["user"]->getHostCheckBox();

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
if (isset($_POST["logout"]) && $_POST["token"] === $_SESSION["token"]) {
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
 *  if a user wants to delete the account a popup is displayed
 */
if (isset($_POST["onDeleteClicked"]) && $_POST["token"] === $_SESSION["token"]) {
    if ($_SESSION["delete"] === "") {
        $_SESSION["delete"] = "visible";
    } else {
        $_SESSION["delete"] = "";

    }
}

/**
 * If a user then clicks on delete account
 */
if (isset($_POST["delete"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        // deletes user information
        $userStore->delete($_SESSION["loggedIn"]["user"]->getUserID());

        // deletes all images from user
        try {
            $ids = $blobObj->queryOwnIDs($_SESSION["loggedIn"]["user"]->getUserID());
            foreach ($ids as $image) {
                $blobObj->delete($image[0]);
            }
        } catch (Exception) {
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
if (isset($_POST["change_password"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        if ($new_password !== $repeat_new_password) throw new Exception("Passwords must be the same.");

        // changes password in store
        $_SESSION["loggedIn"]["user"] = $userStore->changePassword($_SESSION["user"], $old_password, $new_password);

        // redirect to homepage
        header("Location: profile.php");
        exit();
    } catch (Exception $ex) {
        $old_password = "";
        $new_password = "";
        $repeat_new_password = "";
        $error_message = $ex->getMessage();
    }
}

/**
 *   If a user wants to change user data
 */
if (isset($_POST["update_profile"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        // puts post requests in user object
        $_SESSION["user"] = update_user_variable($_SESSION["user"]);

        isset($_POST["dsr"]) && is_string($_POST["dsr"]) ? $_SESSION["user"]->setDsr("y") : $_SESSION["user"]->setDsr("n");

        // check address
        if ($geoLocApi->validateAddress($_SESSION["user"])) {
            $_SESSION["user"] = $userStore->update($_SESSION["user"]);
            $_SESSION["loggedIn"]["user"] = $_SESSION["user"];
            $_SESSION["loggedIn"]["Musician"] = $_SESSION["user"]->getMusicianCheckBox();
            $_SESSION["loggedIn"]["Host"] = $_SESSION["user"]->getHostCheckBox();

            // redirect to homepage
            header("Location: profile.php");
            exit();
        }
    } catch (Exception) {
        $error_message = "Sorry. Could not update information. Please try again";
    }
}

/**
 *  if a user opens and closes the hints field
 */
if (isset($_POST["show_hint"]) && $_POST["token"] === $_SESSION["token"]) {
    if ($_SESSION["hintField"]["visibility"] === "") {
        $_SESSION["hintField"]["message"] = $_POST["show_hint"];
        $_SESSION["hintField"]["visibility"] = "hintVisible";
    } else {
        $_SESSION["hintField"]["visibility"] = "";
        $_SESSION["hintField"]["show"] = false;
    }
}

/**
 * if a user puts in an address and name in register and clicks on next step
 */
if (isset($_POST["check_address"])) {
    // puts post requests in user object
    update_user_variable($_SESSION["user"]);

    // check address
    if ($geoLocApi->validateAddress($_SESSION["user"])) {
        // redirect to next step
        header("Location: ".getNextUrl($step));
        exit();
    }
}

/**
 * if a user clicks on next step in register
 */
if (isset($_POST["toStep3"])) {
    // puts post requests in user object
    update_user_variable($_SESSION["user"]);

    // redirect to next step
    header("Location: " . getNextUrl($step));
    exit();
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              view posts                                                            */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * If a user wants to view a profile page
 * $_POST["viewProfile"] contains the user_ID of the profile

 */
if (isset($_POST["viewProfile"])) {
    try {
        if ($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewProfile"]) {
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

        // removes the hint button
        $_SESSION["hintField"]["button"] = "hidden";

        // sets the images of the profile via user_ID
        setProfileImages($_POST["viewProfile"], false);

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
if (isset($_POST["viewEditProfile"]) && $_POST["token"] === $_SESSION["token"]) {
    if ($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewEditProfile"]) {
        // sets the user variable to the loggedInUser (user variable is displayed in profile)
        $_SESSION["user"] = $_SESSION["loggedIn"]["user"];

        // sets the profile navigation to private -> with navigation buttons
        $_SESSION["navigation"] = "../php/includes/navigation/profile/private.php";

        // sets the images of the profile via user_ID
        setProfileImages($_POST["viewEditProfile"], true);

        // adds the hint field only if registered
        $_SESSION["hintField"]["button"] = "visible";
        if ($_SESSION["hintField"]["show"] === true) {
            $_SESSION["hintField"]["visibility"] = "hintVisible";
            $_SESSION["hintField"]["message"] = 'Hint: To Change Images in Profile hover on an image and select "Edit Image".';
        }

        // hides flickr box if visible before
        $_SESSION["ImageBox"] = "";

        // redirect to edit profile page
        header("Location: editProfile.php");
        exit();
    }
}

/**
 * If a user wants to view the change password page
 * $_POST["viewChangePassword"] contains the user_ID of the profile
 */
if (isset($_POST["viewChangePassword"]) && $_POST["token"] === $_SESSION["token"]) {
    if ($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewChangePassword"]) {
        // sets the user variable to the loggedInUser (user variable is displayed in profile)
        $_SESSION["user"] = $_SESSION["loggedIn"]["user"];

        // sets the profile navigation to private -> with navigation buttons
        $_SESSION["navigation"] = "../php/includes/navigation/profile/private.php";

        // sets the images of the profile via user_ID
        setProfileImages($_POST["viewChangePassword"], false);

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
    if (isset($_POST["type"]) && is_string($_POST["type"])) { $user->setType($_POST["type"]); }
    if (isset($_POST["name"]) && is_string($_POST["name"])) { $user->setName($_POST["name"]); }
    if (isset($_POST["surname"]) && is_string($_POST["surname"])) { $user->setSurname($_POST["surname"]); }
    if (isset($_POST["phone_number"]) && is_string($_POST["phone_number"])) { $user->setPhoneNumber($_POST["phone_number"]); }
    if (isset($_POST["email"]) && is_string($_POST["email"])) { $user->setEmail($_POST["email"]); }
    if (isset($_POST["genre"]) && is_string($_POST["genre"])) { $user->setGenre($_POST["genre"]); }
    if (isset($_POST["members"]) && is_string($_POST["members"])) { $user->setMembers($_POST["members"]); }
    if (isset($_POST["other_remarks"]) && is_string($_POST["other_remarks"])) { $user->setOtherRemarks($_POST["other_remarks"]); }
    if (isset($_POST["user_street_name"])&& is_string($_POST["user_street_name"])) { $user->setStreetName($_POST["user_street_name"]); }
    if (isset($_POST["user_house_number"]) && is_string($_POST["user_house_number"])) { $user->setHouseNumber($_POST["user_house_number"]); }
    if (isset($_POST["user_postal_code"]) && is_string($_POST["user_postal_code"])) { $user->setPostalCode($_POST["user_postal_code"]); }
    if (isset($_POST["user_city"]) && is_string($_POST["user_city"])) { $user->setCity($_POST["user_city"]); }
    return $user;
}

/**
 * unsets all the session variables
 */
function reset_variables(): void {
    session_destroy();
}


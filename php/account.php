<?php
global $userStore, $addressStore, $blobObj, $images, $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $db, $success_message;

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               loggedIn changes                                                     */
/* ------------------------------------------------------------------------------------------------------------------ */

// init loggedIn session variable
$_SESSION["loggedIn"] = $_SESSION["loggedIn"] ?? array("status" => false);

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
$password = isset($_POST["password"]) && is_string($_POST["password"])   ?   htmlspecialchars($_POST["password"])   :   "";
$repeat_password = isset($_POST["repeat_password"]) && is_string($_POST["repeat_password"])   ?   htmlspecialchars($_POST["repeat_password"])   :   "";
$old_password = isset($_POST["old_password"]) && is_string($_POST["old_password"])   ?   htmlspecialchars($_POST["old_password"])   :   "";
$new_password = isset($_POST["new_password"]) && is_string($_POST["new_password"])   ?   htmlspecialchars($_POST["new_password"])   :   "";
$repeat_new_password = isset($_POST["repeat_new_password"]) && is_string($_POST["repeat_new_password"])   ?   htmlspecialchars($_POST["repeat_new_password"])   :   "";

// for the checkbox in profile
$_SESSION["Musician"] = ($_SESSION["user"]->getType() === "Musician") ? "checked" : "";
$_SESSION["Host"] = ($_SESSION["user"]->getType() === "Host") ? "checked" : "";

// Which header should be shown
$_SESSION["normalHeader"] = $_SESSION["loggedIn"]["status"] === true ? "hidden" : "visible";
$_SESSION["profileHeader"] = $_SESSION["loggedIn"]["status"] === false ? "hidden" : "visible";
$_SESSION["profileHeaderBox"] = $_SESSION["loggedIn"]["status"] === true ? $profile_header_box : "";

$_SESSION["selectImageBox"] = "";

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
            $user = $_SESSION["user"];
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

            $user = $userStore->create($user);

            $image = getProfilePictureSmall($user->getUserID(), false);
            $_SESSION["loggedIn"] = array("status" => true, "user" => $user, "profile_picture_small" => $image);
            
            $_SESSION["success_message"] = "Success! Welcome to our Team.";

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
        $user = $_SESSION["user"];

        $user = $userStore->login($user->getEmail(), $password);
        $image = getProfilePictureSmall($user->getUserID(), false);
        $_SESSION["loggedIn"] = array("status" => true, "user" => $user, "profile_picture_small" => $image);

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
        $userStore->delete($_SESSION["loggedIn"]["user"]->getUserID());
        $blobObj->delete($_SESSION["loggedIn"]["user"]->getUserID());
        
        reset_variables();

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
        if($new_password === $repeat_new_password) {
            $_SESSION["loggedIn"]["user"] = $userStore->changePassword($_SESSION["loggedIn"]["user"], $old_password, $new_password);

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
if(isset($_POST["update_profile"])) {
    try {
        $user = update_user_variable($_SESSION["loggedIn"]["user"]);
        $_SESSION["loggedIn"]["user"] = $userStore->update($user);

        header("Location: profile.php");
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
    }

}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              view posts                                                            */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * If a user wants to view a profile page
 * $_POST["viewProfile"] contains the user_ID of the profile

 */
if(isset($_POST["viewProfile"])) {
    try {
        if($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewProfile"]) {
            $_SESSION["user"] = $_SESSION["loggedIn"]["user"];
            $_SESSION["navigation"] = "../php/navigation/profile/private.php";
        } else {
            $_SESSION["user"] = $userStore->findOne($_POST["viewProfile"]);
            $_SESSION["navigation"] = "../php/navigation/profile/public.php";
        }
        setImages($_POST["viewProfile"], false);
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
if(isset($_POST["viewEditProfile"])) {
    if ($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewEditProfile"]) {
        $_SESSION["navigation"] = "../php/navigation/profile/private.php";
        setImages($_POST["viewEditProfile"], true);
        header("Location: editProfile.php");
        exit();
    }
}

/**
 * If a user wants to view the change password page
 * $_POST["viewChangePassword"] contains the user_ID of the profile
 */
if(isset($_POST["viewChangePassword"])) {
    if ($_SESSION["loggedIn"]["status"] === true && $_SESSION["loggedIn"]["user"]->getUserID() == $_POST["viewChangePassword"]) {
        $_SESSION["navigation"] = "../php/navigation/profile/private.php";
        setImages($_POST["viewChangePassword"], false);
        header("Location: changePassword.php");
        exit();
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                                                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 *  If a user wants to change any image in the profile a box appears where you can select an image
 */
if (isset($_POST["onEditProfilePicture"])) {
    if(isset($_SESSION["selectImageBox"])) {
        unset($_SESSION["selectImageBox"]);
    } else {
        $_SESSION["selectImageBox"] = "visible";
    }
}

if (isset($_POST["postImage"])) {
    try {
        $path = "../resources/images/profile/custom/".verifyImage($_POST["onSelectImageClick"], "profile/custom");

        $blobObj->insertBlob($_SESSION["loggedIn"]["user"]->getUserID(), $_POST["onSelectImageClick"], $path, "image/gif");

        if($_POST["onSelectImageClick"] === "profile_picture_small") {
            $image = getProfilePictureSmall($_SESSION["loggedIn"]["user"]->getUserID(), true);
            $_SESSION["profile_picture_small"] = $image;
            $_SESSION["loggedIn"]["profile_picture_small"] = $image;

        } elseif ($_POST["onSelectImageClick"] === "profile_picture_large") {
            $_SESSION["profile_picture_large"] = getProfilePictureLarge($_SESSION["loggedIn"]["user"]->getUserID(), true);

        } elseif ($_POST["onSelectImageClick"] === "newImage") {
            $_SESSION["image_gallery"] = getImageGallery($_SESSION["loggedIn"]["user"]->getUserID(), true);

        }
    } catch (RuntimeException $e) {
        $error_message = $e->getMessage();
    }
}

if (isset($_POST["onImageGalleryClick"])) {
    try {
        $blobObj->delete($_POST["onImageGalleryClick"]);
        $_SESSION["image_gallery"] = getImageGallery($_SESSION["loggedIn"]["user"]->getUserID(), true);
        header("Location: editProfile.php");
        exit();
    } catch (RuntimeException $e) {
        $error_message = $e->getMessage();

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
/*                                       functions to switch urls in register                                         */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * gets the url for the next step in the register progressbar
 * @param $var
 * @return String
 */
function getNextUrl($var): String {
    $var++;
    return "register.php?step=" . $var;
}

/**
 * gets the url for the last step in the register progressbar
 * @param $var
 * @return String
 */
function getLastUrl($var): String {
    $var--;
    return "register.php?step=" . $var;
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               image functions                                                      */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * @param $id
 * @param $isEdit
 * @return void
 */
function setImages($id, $isEdit) : void {
    $_SESSION["profile_picture_small"] = getProfilePictureSmall($id, $isEdit);
    $_SESSION["profile_picture_large"] = getProfilePictureLarge($id, $isEdit);
    $_SESSION["image_gallery"] = getImageGallery($id, $isEdit);
}

/**
 * @param $id
 * @param $isEdit
 * @return string
 */
function getProfilePictureSmall($id, $isEdit): string {
    global $blobObj;
    try {
        $ids = $blobObj->queryID($id, "profile_picture_small");
        $a = $blobObj->selectBlob($ids[0][0]);

        return "data:" . $a['mime'] . ";base64," . base64_encode( $a['data'] );
    } catch (RuntimeException $e) {
        return "../resources/images/profile/default/defaultSmall.png";
    }
}

/**
 * @param $id
 * @param $isEdit
 * @return string
 */
function getProfilePictureLarge($id, $isEdit): string {
    global $blobObj;

    try {
        $ids = $blobObj->queryID($id, "profile_picture_large");
        $a = $blobObj->selectBlob($ids[0][0]);

        return "data:" . $a['mime'] . ";base64," . base64_encode( $a['data'] );
    } catch (RuntimeException $e) {
        return "../resources/images/profile/default/defaultLarge.jpeg";
    }
}

/**
 * @param $id
 * @param $isEdit
 * @return string
 */
function getImageGallery($id, $isEdit): string {
    global $blobObj;

    try {
        $ids = $blobObj->queryID($id, "image_gallery");

        $string = "";
        foreach ($ids as $image) {
            $a = $blobObj->selectBlob($image[0]);

            if($isEdit) {
                $string = $string.
                    '<div id="imageGallery" class="imageGalleryEdit">                                                                               '.
                    '    <img src="data:' . $a['mime'] . ';base64,' . base64_encode($a['data']) . '" alt="could not load image"/>                                  '.
                    '    <label id="exit">X                                                                                                                        '.
                    '         <input type="submit" name="onImageGalleryClick" value="' . $image[0] . '">                                                              '.
                    '    </label>                                                                                                                                  '.
                    '</div>                                                                                                                                       ';
            } else {
                $string = $string.'<img src="data:' . $a['mime'] . ';base64,' . base64_encode($a['data']) . '" alt="could not load image" id="imageGallery" />';
            }

        }
        return $string;
    } catch (RuntimeException $e) {
        return "No Images were Uploaded.";
    }
}

/**
 * @param $name
 * @param $type
 * @return String
 */
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


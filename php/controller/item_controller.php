<?php

global $type, $bandStore, $eventStore, $addressStore, $blobObj, $db, $showEventOptions;
//include_once "../php/includes/includes.php";

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                  item variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

use Item\User;
use Item\Event;

$_SESSION["event"] = $_SESSION["event"] ?? new Event();

$_SESSION["status"] =  (isset($_GET["status"]) && is_string($_GET["status"])) ? "edit" : "create";

$_SESSION["events"] = $_SESSION["events"] ?? null;
$_SESSION["bands"] = $_SESSION["bands"] ?? null;

$_SESSION["search"] = $_POST["search"] ?? "";
$_SESSION["searchDate"] = $_POST["searchDate"] ?? "";

isset($_POST["event_name"]) && is_string($_POST["event_name"])   ?   $_SESSION["event"]->setName($_POST["event_name"])   :   "";
isset($_POST["description"]) && is_string($_POST["description"])   ?   $_SESSION["event"]->setDescription($_POST["description"])   :   "";
isset($_POST["requirements"]) && is_string($_POST["requirements"])   ?   $_SESSION["event"]->setRequirements($_POST["requirements"])   :   "";
isset($_POST["date"]) && is_string($_POST["date"])   ?   $_SESSION["event"]->setDate($_POST["date"])   :   "";
isset($_POST["startTime"]) && is_string($_POST["startTime"])   ?   $_SESSION["event"]->setStartTime($_POST["startTime"])   :   "";
isset($_POST["endTime"]) && is_string($_POST["endTime"])   ?   $_SESSION["event"]->setEndTime($_POST["endTime"])   :   "";
isset($_POST["event_street_name"]) && is_string($_POST["event_street_name"])   ?   $_SESSION["event"]->setStreetName($_POST["event_street_name"])   :   "";
isset($_POST["event_house_number"]) && is_string($_POST["event_house_number"])   ?   $_SESSION["event"]->setHouseNumber($_POST["event_house_number"])  :   "";
isset($_POST["event_postal_code"]) && is_string($_POST["event_postal_code"])   ?   $_SESSION["event"]->setPostalCode($_POST["event_postal_code"])   :   "";
isset($_POST["event_city"]) && is_string($_POST["event_city"])   ?   $_SESSION["event"]->setCity($_POST["event_city"])   :   "";

if(isset($_GET["type"]) && is_string($_GET["type"])) {
    $type = $_GET["type"];
    $_SESSION["itemList"] = getAllItems();
}
$_SESSION["itemList"] = (isset($_GET["type"]) && is_string($_GET["type"])) ? getAllItems() : "";
$_SESSION["itemDetail"] = $_SESSION["itemDetail"] ?? null;
$_SESSION["showEventOptions"] = isset($_SESSION["loggedIn"]["status"]) && $_SESSION["loggedIn"]["status"] === false ? "hidden" : "visible";

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * Creates a new items\Event in the Eventstore
 */
if (isset($_POST["submit"])) {
    try {
        if ($_SESSION["status"] === "create") {
            $_SESSION["event"]->setUserID($_SESSION["loggedIn"]["user"]->getUserID());
            $_SESSION["event"] = $eventStore->create($_SESSION["event"]);
        } else {
            $_SESSION["event"] = $eventStore->update($_SESSION["event"]);
        }


        // if an image was uploaded insert it in the files table
        $_POST["image"] ?? $path = "../resources/images/events/" . verifyImage("image", "events");
        $blobObj->insertBlob($_SESSION["event"]->getEventID(), "event", $path, "image/gif");

        header("Location: events.php?type=events");
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

/**
 *  If a user clicks on an event item a larger version is displayed at the top of the page
 */
if (isset($_POST["onItemClick"])) {
    foreach ($_SESSION["events"] as $event) {
        if ($_POST["onItemClick"] == $event->getEventID()) {
            if ($_SESSION["itemDetail"] === null) {
                $_SESSION["itemDetail"] = getDetail($event);
            } else {
                $_SESSION["itemDetail"] = null;
            }
        }
    }
}

/**
 * Deletes an items\Event from the Eventstore
 */
if (isset($_POST["onDelete"])) {
    $eventStore->delete($_POST["onDelete"]);
    unset($_POST["onDelete"]);
}

/**
 * Sets the current session event to the event the user wants to edit.
 * That means all fields in createEvent are filled with the data of the specific event
 */
if (isset($_POST["onEdit"])){
    $_SESSION["event"] = $eventStore->findOne($_POST["onEdit"]);

    header("Location: createEvent.php?status=Edit");
    exit();
}

/**
 * if a user clicks on get all events, all events are displayed
 */
if (isset($_POST["onGetAllEvents"])) {
    $_SESSION["itemList"] = getAllItems();
}

/**
 * if a user clicks on get all events, all events created by the loggedIn user are displayed
 */
if (isset($_POST["onGetMyEvents"])) {
    $_SESSION["itemList"] = getMyEvents($_SESSION["user_ID"]);
}

/**
 * if a user submits a search, all events with the statement are displayed
 */
if (isset($_POST["submitSearch"])) {
    if($type === "events") {
        if(isset($_POST["searchDate"]) && $_POST["search"] === "") {
            $_SESSION["itemList"] = getAnyItems($_POST["searchDate"]);
        } elseif (isset($_POST["search"]) && $_POST["searchDate"] === "") {
            $_SESSION["itemList"] = getAnyItems($_POST["search"]);
        } elseif(isset($_POST["search"]) && isset($_POST["searchDate"])) {
            $itemDate = getAnyItems($_POST["searchDate"]);
            $itemSearch = getAnyItems($_POST["search"]);
            $_SESSION["itemList"] = $itemDate.$itemSearch;
        }
    } elseif ($type === "bands") {
        $_SESSION["itemList"] = getAnyItems($_POST["search"]);
    }
}


/**
 * method for ajax
 */
if (isset($_GET["submitSearchJavaScript"])) {
    initDatabase();
    echo htmlspecialchars(getAnyItems($_GET["submitSearchJavaScript"]));
}


/**
 * switches from ascending sort to descending sort.
 */
if (isset($_POST["sort"])) {
    $list = ($type === "bands" ? $_SESSION["bands"] : ($type === "events" ? $_SESSION["events"] : ""));

    try {
        if(!isset($_SESSION["sort"]) || $_SESSION["sort"] === SORT_DESC) {
            $list = sortArray($list, $_POST["sort"], SORT_ASC);
        } elseif ($_SESSION["sort"] === SORT_ASC) {
            $list = sortArray($list, $_POST["sort"], SORT_DESC);
        }

        $_SESSION["itemList"] = buildItemList($list, "could not sort", false);
    } catch (Exception $ex) {
       $error_message = $ex;
    }
}

/**
 * search algorithm
 * @param array $array
 * @param $attribute
 * @param $dir
 * @return array
 */
function sortArray(array $array, $attribute, $dir) : array {
    $_SESSION["sort"] = $dir;

    foreach ($array as $key => $value) {
        if($attribute === "Name") {
            $column[] = $value->getName();
        } elseif ($attribute === "Date") {
            $column[] = $value->getDate();
        } elseif ($attribute === "Genre") {
            $column[] = $value->getGenre();
        }
    }
    array_multisort($column, $dir, $array);
    return $array;
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              get items\Event and get Bands method                                        */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * Loads all event from the eventsstore and prints (echos) the html data to the page
 * @return string
 * @throws Exception
 */
function getAllItems(): string {
    global $eventStore, $error_message, $type, $userStore;
    $list = ""; $msg = "";
    try {
        if($type === "bands") {
            $_SESSION["bands"] = $userStore->findAll();
            $list = $_SESSION["bands"];
            $msg = "There are no Musicians currently!";
        } elseif ($type === "events") {
            $_SESSION["events"] = $eventStore->findAll();
            $list = $_SESSION["events"];
            $msg = "There are no Events uploaded currently!";
        }
        return buildItemList($list, $msg, false);
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        return "";
    }
}

/**
 * @param $stmt
 * @return string
 */
function getAnyItems($stmt): string {
    global $eventStore, $error_message, $type, $userStore;

    try {
        if($type === "bands") {
            $_SESSION["bands"] = $userStore->findAny($stmt);
            $list = $_SESSION["bands"];
            $msg = 'There are no Bands with: "'.$stmt.'".';
        } elseif ($type === "events") {
            $_SESSION["events"] = $eventStore->findAny($stmt);
            $list = $_SESSION["events"];
            $msg = 'There are no Events with: "'.$stmt.'".';
        }
        return buildItemList($list, $msg, false);
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        return "";
    }
}


/**
 * @param $user_ID
 * @return string
 */
function getMyEvents($user_ID): string {
    global $eventStore, $error_message;

    try {
        $_SESSION["events"] = $eventStore->findMy($user_ID);

        return buildItemList($_SESSION["events"], "You have not created an Event!", true);
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        return "";
    }
}

/**
 * @throws Exception
 */
function buildItemList($list, $msg, $editVisible) : string {
    global $type;
    if (!empty($list)) {
        $return = "";

        foreach ($list as $item) {
            if($type === "bands") {
                $return = $return . $item->getBandHTML();
            } elseif ($type === "events") {
                if ($editVisible) {
                    $return = $return . $item->getEditableEventHTML(); // adds the "Delete" and "Edit" Button
                } else {
                    $return = $return . $item->getEventHTML();
                }
            }

        }
        return $return;
    } else {
        throw new Exception($msg);
    }
}

/**
 * The larger box which will be displayed if a user clicks on an event item in events
 * @param Object $item
 * @return string
 */
function getDetail(Object $item) : string {
    return $string =
        '<form method="post" id="item_details">                                                                '.
        '    <div id="item">                                                                                   '.
        '        <div id="item_image">                                                                         '.
        '            <img src="' . $item->getImageSource() . '" alt="bandImage"/>                              '.
        '        </div>                                                                                        '.
        '        <div id="item_short_description" class="text-line-pre">                                       '.
        '            <span>' . $item->getName() . '</span>                                                     '.
        '            <br>                                                                                      '.
        '            <span>Address: '.$item->getAddressAttributesAsList("value", false).'</span>               ' .
        '            <br>                                                                                      '.
        '            <span> ' . $item->getTime() . '</span>                                                    '.
        '        </div>                                                                                        '.
        '        <label id="exit">X                                                                            '.
        '             <input type="submit" name="onItemClick" value="' . $item->getEventID() . '">             '.
        '        </label>                                                                                      '.
        '    </div>                                                                                            '.
        '    <div id="detail">                                                                                 '.
        '        <div id="item_description">                                                                   '.
        '            <h2>Further Information</h2>                                                              '.
        '            <p>' . $item->getDescription() . '</p>                                                    '.
        '        </div>                                                                                        '.
        '        <div class="item_requirements">                                                               '.
        '            <h2>What we are looking for</h2>                                                          '.
        '            <p>' . $item->getRequirements() . '</p>                                                   '.
        '        </div>                                                                                        '.
        '        <div id="item_contact">                                                                       '.
        '            <h2>Contact Us</h2>                                                                       '.
        '            <label id="profile_Link">link to profile                                                  '.
        '                <input type="submit" name="viewProfile" value="' . $item->getUserID() . '">           '.
        '            </label>                                                                                  '.
        '        </div>                                                                                        '.
        '    </div>                                                                                            '.
        ' </form>                                                                                              ';
}
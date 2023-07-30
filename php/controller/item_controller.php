<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                            import and autoload classes                                             */
/* ------------------------------------------------------------------------------------------------------------------ */

namespace php\controller;

global $type, $eventStore, $blobObj, $geoLocApi, $map, $map_events, $map_loggedInUser, $itemList;

use Exception;
use php\includes\items\Event;
use php\includes\items\User;
use function php\initDatabase;

include $_SERVER['DOCUMENT_ROOT'] . '/autoloader.php';

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                  item variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

$_SESSION["event"] = $_SESSION["event"] ?? new Event();

$_SESSION["currentEvents"] = $_SESSION["currentEvents"] ?? null;
$_SESSION["events"] = $_SESSION["events"] ?? null;
$_SESSION["bands"] = $_SESSION["bands"] ?? null;

$_SESSION["status"] = $_SESSION["status"] ?? "";

$_SESSION["search"] = $_POST["search"] ?? "";
$_SESSION["searchDate"] = $_POST["searchDate"] ?? "";

$map  = '<span>If you want to see the content of Third party companies accept the ';
$map .= '<a id="agreementLinks" href="impressum.php">Legal Disclosure</a>, ';
$map .= '<a id="agreementLinks" href="nutzungsbedingungen.php">Terms of Use</a> and the ';
$map .= '<a id="agreementLinks" href="datenschutz.php">Privacy Policy.</span>';

if(isset($_POST["event_name"]) && is_string($_POST["event_name"])) { $_SESSION["event"]->setName($_POST["event_name"]); }
if(isset($_POST["description"]) && is_string($_POST["description"])) { $_SESSION["event"]->setDescription($_POST["description"]); }
if(isset($_POST["requirements"]) && is_string($_POST["requirements"])) { $_SESSION["event"]->setRequirements($_POST["requirements"]); }
if(isset($_POST["date"]) && is_string($_POST["date"])) { $_SESSION["event"]->setDate($_POST["date"]); }
if(isset($_POST["startTime"]) && is_string($_POST["startTime"])) { $_SESSION["event"]->setStartTime($_POST["startTime"]); }
if(isset($_POST["endTime"]) && is_string($_POST["endTime"])) { $_SESSION["event"]->setEndTime($_POST["endTime"]); }
if(isset($_POST["event_street_name"]) && is_string($_POST["event_street_name"])) { $_SESSION["event"]->setStreetName($_POST["event_street_name"]); }
if(isset($_POST["event_house_number"]) && is_string($_POST["event_house_number"])) { $_SESSION["event"]->setHouseNumber($_POST["event_house_number"]); }
if(isset($_POST["event_postal_code"]) && is_string($_POST["event_postal_code"])) { $_SESSION["event"]->setPostalCode($_POST["event_postal_code"]); }
if(isset($_POST["event_city"]) && is_string($_POST["event_city"])) { $_SESSION["event"]->setCity($_POST["event_city"]); }

$map_events = array();
$map_loggedInUser = array();
$_SESSION["radius"] = $_SESSION["radius"] ?? 1000;

$_SESSION["itemDetail"] = $_SESSION["itemDetail"] ?? null;
$_SESSION["showEventOptions"] = isset($_SESSION["loggedIn"]["status"]) && $_SESSION["loggedIn"]["status"] === false ? "hidden" : "visible";

$_SESSION["selectMyEvents"] = $_SESSION["selectMyEvents"] ?? "";
$_SESSION["selectAllEvents"] = $_SESSION["selectAllEvents"] ?? "";

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               http request functions                                               */
/* ------------------------------------------------------------------------------------------------------------------ */

if(isset($_GET["type"]) && is_string($_GET["type"])) {
    $type = $_GET["type"];

    if($type === "closeToMe" && $_SESSION["loggedIn"]["user"]->getDsr() === "y") {
        // necessary for leaflet
        $map = '<div id="map"></div>';

        if (isset($_POST["init"]) && $_POST["init"] === "false") {
            $events = $_SESSION["events"];
            onItemClicked($events);
        } else {
            $_SESSION["itemDetail"] = null;
            $_SESSION["events"] = $eventStore->findAll();
            $events = $_SESSION["events"];
        }

        // converts objects to json array
        if (!empty($events)) {
            foreach ($events as $event) {
                $map_events[] = Event::EventToArray($event);
            }
        }

        // if loggedInUser has an address convert to javascript variable
        if ($_SESSION["loggedIn"]["user"]->hasAddressInputs()) {
            $map_loggedInUser["street_name"] = $_SESSION["loggedIn"]["user"]->getStreetName();
            $map_loggedInUser["house_number"] = $_SESSION["loggedIn"]["user"]->getHouseNumber();
            $map_loggedInUser["postal_code"] = $_SESSION["loggedIn"]["user"]->getPostalCode();
            $map_loggedInUser["city"] = $_SESSION["loggedIn"]["user"]->getCity();
        }
    } elseif ($type === "events") {
        $_SESSION["selectAllEvents"] = "selected";
        $_SESSION["selectMyEvents"] = "";
        $itemList = getAllItems($type);
    } else {
        $itemList = getAllItems($type);
    }
}

if (isset($_GET["status"]) && is_string($_GET["status"])) {
    $_SESSION["status"] = $_GET["status"];
}

/**
 * Creates a new items\Event in the Eventstore
 */
if (isset($_POST["submit"]) && $_POST["token"] === $_SESSION["token"]) {
    try {
        if($geoLocApi->validateAddress($_SESSION["user"]) === false)
            throw new Exception("Address does not exist! Please type in an existing Address.");

        if ($_SESSION["status"] === "create") {
            $_SESSION["event"]->setUserID($_SESSION["loggedIn"]["user"]->getUserID());
            $_SESSION["event"] = $eventStore->create($_SESSION["event"]);
            $blobObj->create($_SESSION["event"]->getEventID(), "event", $_SESSION["event"]->getImage(), "image/gif");
        } else {
            $blobObj->update($_SESSION["event"]->getEventID(), "event", $_SESSION["event"]->getImage(), "image/gif");
            $_SESSION["event"] = $eventStore->update($_SESSION["event"]);
        }

        header("Location: events.php?type=events");
        exit();
    } catch (Exception $e) {
        echo $error_message = $e->getMessage();
    }
}


/**
 *  If a user clicks on an event item a larger version is displayed at the top of the page
 */
if (isset($_POST["onItemClick"]) && $type === "events") {
    onItemClicked($_SESSION["events"]);
}

function onItemClicked($list): void {
    foreach ($list as $event) {
        if ($_POST["onItemClick"] === $event->getEventID()) {
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
if (isset($_POST["onDelete"]) && $_POST["token"] === $_SESSION["token"]) {
    $eventStore->delete($_POST["onDelete"]);
    unset($_POST["onDelete"]);

    $itemList = getMyEvents($_SESSION["loggedIn"]["user_ID"]);
    $_SESSION["itemDetail"] = null;
    $_SESSION["selectMyEvents"] = "selected";
    $_SESSION["selectAllEvents"] = "";
}

/**
 * Sets the current session event to the event the user wants to edit.
 * That means all fields in createEvent are filled with the data of the specific event
 */
if (isset($_POST["onEdit"]) && $_POST["token"] === $_SESSION["token"]){
    $_SESSION["event"] = $eventStore->findOne($_POST["onEdit"]);
    try {
        $imageID = $blobObj->queryID($_POST["onEdit"], "event");
        $image = $blobObj->findOne($imageID[0]["id"]);
        $_SESSION["event"]->setImage($image);
    } catch (Exception) {
    }

    header("Location: createEvent.php?status=edit");
    exit();
}

/**
 * if a user clicks on get all events, all events are displayed
 */
if (isset($_POST["onGetAllEvents"])) {
    $itemList = getAllItems("events");
    $_SESSION["itemDetail"] = null;
    $_SESSION["selectAllEvents"] = "selected";
    $_SESSION["selectMyEvents"] = "";
}

/**
 * if a user clicks on get all events, all events created by the loggedIn user are displayed
 */
if (isset($_POST["onGetMyEvents"])) {
    $itemList = getMyEvents($_SESSION["loggedIn"]["user_ID"]);
    $_SESSION["itemDetail"] = null;
    $_SESSION["selectMyEvents"] = "selected";
    $_SESSION["selectAllEvents"] = "";

}

/**
 * if a user submits a search, all events with the statement are displayed
 */
if (isset($_POST["submitSearch"])) {
    if($type === "events") {
        if(isset($_POST["searchDate"]) && $_POST["search"] === "") {
            $itemList = getAnyItems($_POST["searchDate"], "events");
        } elseif (isset($_POST["search"]) && $_POST["searchDate"] === "") {
            $itemList = getAnyItems($_POST["search"], "events");
        } elseif(isset($_POST["search"]) && isset($_POST["searchDate"])) {
            $itemDate = getAnyItems($_POST["searchDate"], "events");
            $itemSearch = getAnyItems($_POST["search"], "events");
            $itemList = $itemDate.$itemSearch;
        }
        $_SESSION["itemDetail"] = null;
    } elseif ($type === "bands") {
        $itemList = getAnyItems($_POST["search"], "bands");
    }
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

        $itemList = buildItemList($list, false, false);
    } catch (Exception $ex) {
       $error_message = "could not sort";
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

    foreach ($array as $value) {
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
/*                                                 ajax methods                                                       */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * method for ajax
 */
if (isset($_GET["submitSearchJavaScript"])) {
    initDatabase();
    echo htmlspecialchars(getAnyItems($_GET["submitSearchJavaScript"], $type));
}

/**
 * method for ajax
 */
if (isset($_POST["range_update"])) {
    include $_SERVER['DOCUMENT_ROOT'] . "/php/settings.php";

    $range_update = json_decode($_POST["range_update"], true);

    // converts array back to object
    $list = [];
    foreach ($range_update["list"] as $value) {
        $event = Event::create($value);
        $event->setImage($value["image"]);
        $list[] = $event;
    }

    $_SESSION["currentEvents"] = $list;
    $_SESSION["radius"] = $range_update["radius"];

    try {
        echo buildItemList($_SESSION["currentEvents"], false, true);
    } catch (Exception) {
        echo "There are no nearby Events within an " . $range_update["radius"] . " Km Range.";
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              get items\Event and get Bands method                                        */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * Loads all event from the EventStore and prints (echos) the html data to the page
 * @param $type
 * @return string
 */
function getAllItems($type): string {
    global $eventStore, $error_message, $type, $userStore;
    $msg = "";

    try {
        if($type === "bands") {
            $_SESSION["bands"] = $userStore->findAll();
            $list = $_SESSION["bands"];
            $msg = "There are no Musicians currently!";
        } else {
            $_SESSION["events"] = $eventStore->findAll();
            $list = $_SESSION["events"];
            $msg = "There are no Events uploaded currently!";
        }
        return buildItemList($list, false, false);
    } catch (Exception) {
        $error_message = $msg;
        return "";
    }
}

/**
 * @param $stmt
 * @param $type
 * @return string
 */
function getAnyItems($stmt, $type): string {
    global $eventStore, $error_message, $type, $userStore;
    $list = null; $msg = "";

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
        return buildItemList($list, false, false);
    } catch (Exception $e) {
        $error_message = $msg;
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

        return buildItemList($_SESSION["events"], true, false);
    } catch (Exception $e) {
        $error_message = "You have not created an Event!";
        return "";
    }
}

/**
 * @throws Exception
 */
function buildItemList($list, $editVisible, $isCloseToMe) : string {
    if (!empty($list)) {
        $return = "";

        foreach ($list as $item) {
            if($item instanceof User || (is_array($item) && in_array("type", $item)))
                $return = $return . $item->getBandHTML();
            if ($item instanceof Event || (is_array($item) && in_array("event_ID", $item)))
                $return = $return . $item->getEventHTML($editVisible, $isCloseToMe);
        }
        return $return;
    } else {
        throw new Exception();
    }
}

/**
 * The larger box which will be displayed if a user clicks on an event item in events
 * @param Object $item
 * @return string
 */
function getDetail(Object $item) : string {
    global $type;

    $html =
        '<form method="post" id="item_details">                                                            ' .
        '    <div id="item">                                                                               ' .
        '        <div id="item_image">                                                                     ' .
        '            <img src="' . $item->getImage() . '" alt="bandImage"/>                                ' .
        '        </div>                                                                                    ' .
        '        <div id="item_short_description" class="text-line-pre">                                   ' .
        '            <span>' . $item->getName() . '</span>                                                 ' .
        '            <br>                                                                                  ' .
        '            <span>Address: '.$item->getAddressAttributesAsList("value", false).'</span>           ' .
        '            <br>                                                                                  ' .
        '            <span> ' . $item->getTime() . '</span>                                                ' .
        '        </div>                                                                                    ' .
        '        <label id="exit">X                                                                        ' ;
    if($type === "closeToMe")
        $html .=
            '         <input type="hidden" name="init" value="false">                                      ' ;
    $html .=
        '             <input type="submit" name="onItemClick" value="' . $item->getEventID() . '">         ' .
        '        </label>                                                                                  ' .
        '    </div>                                                                                        ' .
        '    <div id="detail">                                                                             ' .
        '        <div id="item_description">                                                               ' .
        '            <h2>Further Information</h2>                                                          ' .
        '            <p>' . $item->getDescription() . '</p>                                                ' .
        '        </div>                                                                                    ' .
        '        <div class="item_requirements">                                                           ' .
        '            <h2>What we are looking for</h2>                                                      ' .
        '            <p>' . $item->getRequirements() . '</p>                                               ' .
        '        </div>                                                                                    ' .
        '        <div id="item_contact">                                                                   ' .
        '            <h2>Contact Us</h2>                                                                   ' .
        '            <label id="profile_Link">link to profile                                              ' .
        '                <input type="submit" name="viewProfile" value="' . $item->getUserID() . '">       ' .
        '            </label>                                                                              ' .
        '        </div>                                                                                    ' .
        '    </div>                                                                                        ' .
        ' </form>                                                                                          ' ;
    return $html;
}



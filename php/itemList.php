<?php

global $type, $bandStore, $eventStore, $addressStore, $blobObj, $db, $showEventOptions;


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                  item variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

$_SESSION["event"] = $_SESSION["event"] ?? new Event();

$_SESSION["CreateOrUpdateWord"] = $_SESSION["event"]->getEventID() === null ? "Create" : "Update";



$_SESSION["events"] = $_SESSION["events"] ?? null;
$_SESSION["bands"] = $_SESSION["bands"] ?? null;

$_SESSION["search"] = $_POST["search"] ?? "";
$_SESSION["searchDate"] = $_POST["searchDate"] ?? "";

isset($_POST["event_name"]) && is_string($_POST["event_name"])   ?   $_SESSION["event"]->setName(htmlspecialchars($_POST["event_name"]))   :   "";
isset($_POST["description"]) && is_string($_POST["description"])   ?   $_SESSION["event"]->setDescription(htmlspecialchars($_POST["description"]))   :   "";
isset($_POST["requirements"]) && is_string($_POST["requirements"])   ?   $_SESSION["event"]->setRequirements(htmlspecialchars($_POST["requirements"]))   :   "";
isset($_POST["date"]) && is_string($_POST["date"])   ?   $_SESSION["event"]->setDate(htmlspecialchars($_POST["date"]))   :   "";
isset($_POST["startTime"]) && is_string($_POST["startTime"])   ?   $_SESSION["event"]->setStartTime(htmlspecialchars($_POST["startTime"]))   :   "";
isset($_POST["endTime"]) && is_string($_POST["endTime"])   ?   $_SESSION["event"]->setEndTime(htmlspecialchars($_POST["endTime"]))   :   "";
isset($_POST["event_street_name"]) && is_string($_POST["event_street_name"])   ?   $_SESSION["event"]->setStreetName(htmlspecialchars($_POST["event_street_name"]))   :   "";
isset($_POST["event_house_number"]) && is_string($_POST["event_house_number"])   ?   $_SESSION["event"]->setHouseNumber(htmlspecialchars($_POST["event_house_number"]))  :   "";
isset($_POST["event_postal_code"]) && is_string($_POST["event_postal_code"])   ?   $_SESSION["event"]->setPostalCode(htmlspecialchars($_POST["event_postal_code"]))   :   "";
isset($_POST["event_city"]) && is_string($_POST["event_city"])   ?   $_SESSION["event"]->setCity(htmlspecialchars($_POST["event_city"]))   :   "";

$_SESSION["itemList"] = (isset($_GET["type"]) && is_string($_GET["type"])) ? getItems($_GET["type"]) : "";
$_SESSION["itemDetail"] = $_SESSION["itemDetail"] ?? null;
$_SESSION["showEventOptions"] = $_SESSION["loggedIn"]["status"] === false ? "hidden" : "visible";

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * Creates a new Event in the Eventstore
 */
if (isset($_POST["submit"])) {
    try {
        if ($_SESSION["CreateOrUpdateWord"] == "Create") {
            var_dump("aaa");
            $_SESSION["event"]->setUserID($_SESSION["loggedIn"]["user"]->getUserID());
            $_SESSION["event"] = $eventStore->create($_SESSION["event"]);
        } else {
            $_SESSION["event"] = $eventStore->update($_SESSION["event"]);
        }

        // if an image was uploaded insert it in the files table
            $_POST["image"] ?? $path = "../resources/images/events/" . verifyImage("image", "events");
        $blobObj->insertBlob($_SESSION["event"]->getEventID(), "event", $path, "image/gif");
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
 * Deletes an Event from the Eventstore
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
    unset($_POST["onEdit"]);
}

/**
 * if a user clicks on get all events, all events are displayed
 */
if (isset($_POST["onGetAllEvents"])) {
    $_SESSION["itemList"] = getAllEvents();
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
    if(isset($_POST["searchDate"]) && $_POST["search"] === "") {
        $_SESSION["itemList"] = getAnyEvents($_POST["searchDate"]);
    } elseif (isset($_POST["search"]) && $_POST["searchDate"] === "") {
        $_SESSION["itemList"] = getAnyEvents($_POST["search"]);
    } else {
        $itemDate = getAnyEvents($_POST["searchDate"]);
        $itemSearch = getAnyEvents($_POST["search"]);
        $_SESSION["itemList"] = $itemDate.$itemSearch;
    }
}

/**
 * switches from ascending sort to descending sort.
 */
if (isset($_POST["sort"])) {
    try {
        if(!isset($_SESSION["sort"]) || $_SESSION["sort"] === "desc") {
            $_SESSION["events"] = sortArray($_SESSION["events"], $_POST["sort"], SORT_ASC);
        } elseif ($_SESSION["sort"] === "asc") {
            $_SESSION["events"] = sortArray($_SESSION["events"], $_POST["sort"], SORT_DESC);
        }

        $_SESSION["itemList"] = buildItemList($_SESSION["events"], "could not sort");
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
    $_SESSION["sort"] = ($dir === SORT_ASC) ? "asc" : "desc";

    foreach ($array as $key => $value) {
        if($attribute === "Name") {
            $column[] = $value->getName();
        } elseif ($attribute === "Date") {
            $column[] = $value->getDate();
        }
    }
    array_multisort($column, $dir, $array);
    return $array;
}



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              get Event and get Bands method                                        */
/* ------------------------------------------------------------------------------------------------------------------ */



/**
 * Checks if the page shows events or bands and delegates to the method that fits for the page
 * @param $type
 * @return string
 * @throws Exception
 */
function getItems($type): string {
    switch ($type) {
        case 'bands': {
            $_SESSION["itemDetail"] =  null;
            $result = getBands();
            break;
        }
        default: {
            $result = getAllEvents();
            break;
        }
    }
    return $result;
}



/**
 * Loads all event from the eventsstore and prints (echos) the html data to the page
 * @return string
 * @throws Exception
 */
function getAllEvents(): string {
    global $eventStore, $error_message;

    $loggedIn = false;
    if ($_SESSION["loggedIn"]["status"] === true) {
        $loggedIn = true;
    }

    try {
        $_SESSION["events"] = $eventStore->findAll();

        return buildItemList($_SESSION["events"], "there are no Events uploaded currently!");
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        return "";
    }
}


function getMyEvents($user_ID): string {
    global $eventStore, $error_message;

    try {
        $_SESSION["events"] = $eventStore->findMy($user_ID);
        
        return buildItemList($_SESSION["events"], "You have not created an Event!");
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        return "";
    }
}



function getAnyEvents($stmt): string {
    global $eventStore, $error_message;

    try {
        $_SESSION["events"] = $eventStore->findAny($stmt);

        return buildItemList($_SESSION["events"], 'There are no Events with: "'.$stmt.'".');
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        return "";
    }
}



/**
 * loads all User that are the type musician from the userStore and print the html data to the page
 * @return string
 */
function getBands(): string {
    global $userStore, $error_message;

    try {
        $_SESSION["bands"] = $userStore->findAll();

        if (!empty($_SESSION["bands"])) {
            $return = "";
            foreach ($_SESSION["bands"] as $band) {
                $return = $return . $band->getBandHTML();
            }
            return $return;
        } else {
            throw new Exception("there are no Bands currently!");
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        return "";
    }
}


/**
 * @throws Exception
 */
function buildItemList($events, $msg) : string {
    if (!empty($events)) {
        $return = "";
        foreach ($events as $event) {
            if (($_SESSION["user_ID"] == $event->getUserID())) {
                $return = $return . $event->getEditableEventHTML(); //add the "Delete" and "Edit" Button
            } else {
                $return = $return . $event->getEventHTML();
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
        '            <span>Address: ' . $item->printAddress() . '</span>                                       '.
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
<?php
include 'classes.php';

global $type, $items, $decodedFile, $currentItem, $newEvent, $itemListManager;

$itemListManager = new FileItemListDAO("../resources/json/Bands.json", "../resources/json/Events.json");



$newEvent["image"] = "";
$newEvent["description"] = "";
$newEvent["name"] = "";

$newEvent["street"] = "";
$newEvent["houseNr"] = "";
$newEvent["postalCode"] = "";
$newEvent["city"] = "";
$newEvent["date"] = "";
$newEvent["startTime"] = "";
$newEvent["endTime"] = "";
$newEvent["requirements"] = "";



$type = (isset($_GET["type"]) && is_string($_GET["type"])) ? $_GET["type"] : "";

if (isset($_POST["submit"])) {

    if (isset($_FILES["image"])) {
        $eventImage = "../resources/images/events/" . verifyImage("image", "events");
    }
    /*
    $newEvent["description"] = checkValue("description");
    $newEvent["name"] = checkValue("name");

    $newEvent["street"] = checkValue("street");
    $newEvent["city"] = checkValue("city");
    $newEvent["houseNr"] = checkValue("houseNr");
    $newEvent["postalCode"] = checkValue("postalCode");


    $newEvent["date"] = checkValue("date");
    $newEvent["startTime"] = checkValue("startTime");
    $newEvent["endTime"] = checkValue("endTime");
    $newEvent["requirements"] = checkValue("requirements");
    */
    $event = new EventItem(
        $eventImage,
        "event",
        checkValue("description"),
        checkValue("name"),
        checkValue("street"),
        checkValue("city"),
        checkValue("date"),
        checkValue("startTime"),
        checkValue("endTime"),
        checkValue("requirements"),
        (int)checkValue("houseNr"),
        (int)checkValue("postalCode")
    );
    If (createNewEvent($event)){}
    else{
        // throw exception ?
    }
}

/**
 * @param EventItem $newEvent
 * @return false|void
 */
function createNewEvent(EventItem $newEvent) : bool
{
    //global $itemListManager;
    //$allEvents = $itemListManager->loadItems("events");
    $allEvents = array();
    foreach ($allEvents as $event){ // checks if there is another event with same id
        if($event->getId() == $newEvent->getId()){
            return false;
        }
    }
    return true;
    //return $itemListManager->storeItem($newEvent);
}

function checkValue($var): string
{
    if (isset($_POST["$var"]) && is_string($_POST["$var"])) {
        return htmlspecialchars($_POST["$var"]);
    } /*elseif (isset($newEvent["$var"]) && is_string($newEvent["$var"])) {
        return $newEvent["$var"];
    } */ else {
        return "";
    }
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              getItems                                                              */
/* ------------------------------------------------------------------------------------------------------------------ */

function getItems()
{
    global $type;
    switch ($type) {
        case 'bands':
        {
            return getBands();
        }
        default:
        {
            return getEvents();
        }
    }
}

function getBands(): void
{
    global $itemListManager;
    $items = $itemListManager->loadItems("bands");
    //$file = file_get_contents("../resources/json/Bands.json", true);
    //$item = json_decode($file, false);
    //$itemA = $item[0];

    echo ' <section id="item-list">';
    foreach ($items as $band) {
        $members = '';
        foreach ($band->getMembers() as $member) {
            $members = $members . $member . '<br>';
        }
        $links = '';
        foreach ($band->getLinks() as $link) {
            $links = $links . $link . '<br>';
        }
        echo '
         <div id="item">
            <label class="item-head">
                <img id="item-image" src="' . $band->getImage() . '" alt="bandImage"/>
                <div id="item-description" class="text-line-pre">
                    <span>Name: ' . $band->getName() . '</span>
                    <br>
                    <span>Genre: ' . $band->getGenre() . '</span>
                    <br>
                    <span>' . count($band->getMembers()) . ' Members</span>
                    <br>
                    <span>' . $band->getCosts() . '</span>
                    <input type="checkbox" id="item-click">
                </div>
            </label>
            <div id="item-m-details">
                <div id="item-details-title">
                    <img id="item-image" src="' . $band->getImage() . '" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $band->getName() . ' </h2>
                </div>
                <div>
                    <p>
                        ' . $members . '
                        ' . $band->getEmail() . ' <br>
                        <br>
                        ' . $band->getCosts() . '<br>
                        <br>
                        ' . $band->getRegion() . ' <br>
                    </p>
                </div>
                <div id="item-details-foot">
                    <p class="text-pre-line">
                        Hits <br>
                        ' . $links . '
                    </p>
                </div>
            </div>
        </div> ';
    }

    //todo: fix that...
    $members = '';
    foreach ($items[0]->getMembers() as $member) {
        $members = $members . $member . '<br>';
    }
    $links = '';
    foreach ($items[0]->getLinks() as $link) {
        $links = $links . $link . '<br>';
    }
    echo '</section>';
    echo '
    <section id="item-details">
        <div id="item-details-title">
                    <img id="item-image" src="' . $items[0]->getImage() . '" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $items[0]->getName() . ' </h2>
                </div>
        <div class="item-details-description">
                    <p>
                        ' . $members . '
                        ' . $items[0]->getEmail() . ' <br>
                        <br>
                        ' . $items[0]->getCosts() . '<br>
                        <br>
                        ' . $items[0]->getRegion() . ' <br>
                    </p>
                </div>
                <div id="item-details-foot">
                    <p class="text-pre-line">
                        Hits <br>
                        ' . $links . '
                    </p>
                </div>
    </section>';
}

function getEvents(): void
{
    global $itemListManager;
    $items = $itemListManager->loadItems("events");
    echo ' <section id="item-list">';
    foreach ($items as $event) {
        $address = $event->getStreet() . " " . $event->getHouseNr() . "\n" . $event->getPostalCode() . " " . $event->getCity();
        $time = $event->getStartTime() . " - " . $event->getEndTime();

        echo '
         <div id="item">
            <label class="item-head">
                <img id="item-image" src="' . $event->getImage() . '" alt="bandImage"/>
                <div id="item-description" class="text-line-pre">
                    <span>' . $event->getName() . '</span>
                    <br>
                    <span>Address: ' . $address . '</span>
                    <br>
                    <span> ' . $time . '</span>
                    <input type="checkbox" id="item-click">
                </div>
            </label>
            <div id="item-m-details">
                <div id="item-details-title">
                    <img id="item-image" src="' . $event->getImage() . '" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $event->getName() . ' </h2>
                </div>
                <div class="item-details-description">
                    <p>' . $event->getDescription() . '</p>
                </div>
                <div id="item-details-foot">
                    <p class="text-line-pre">
                        Requirements <br>
                        ' . $event->getRequirements() . '
                    </p>
                </div>
            </div>
         </div> ';
    }

    //todo: fix this...
    echo '</section>';
    echo '
    <section id="item-details">
         <div id="item-details-title">
                    <img id="item-image" src="' . $items[0]->getImage() . '" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $items[0]->getName() . ' </h2>
                </div>
                <div class="item-details-description">
                    <p>' . $items[0]->getDescription() . '</p>
                </div>
                <div id="item-details-foot">
                    <p class="text-line-pre" ">
                        Requirements <br>
                        ' . $items[0]->getRequirements() . '
                    </p>
                </div>
    </section>';
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              getter                                                                */
/* ------------------------------------------------------------------------------------------------------------------ */



<?php

global $type, $items, $decodedFile, $currentItem, $newEvent;

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
$items = [];


$file = file_get_contents($type === 'bands' ? "Bands.json" : "Events.json", true);
$items = json_decode($file, false);

if (isset($_POST["submit"])) {
    $newEvent["image"] = checkValue("image");
    $newEvent["description"] = checkValue("description");
    $newEvent["name"] = checkValue("name");

    $newEvent["street"] = checkValue("street");
    $newEvent["houseNr"] = checkValue("houseNr");
    $newEvent["postalCode"] = checkValue("postalCode");
    $newEvent["city"] = checkValue("city");

    $newEvent["date"] = checkValue("date");
    $newEvent["startTime"] = checkValue("startTime");
    $newEvent["endTime"] = checkValue("endTime");
    $newEvent["requirements"] = checkValue("requirements");
    if ($items[count($items) - 1]->name !== $newEvent["name"]) {
        echo $newEvent["name"];
        createNewEvent($newEvent);
    }
}
function createNewEvent($newEvent)
{
    global $items, $type;
    $items[count($items)] = getEventAsJson($newEvent);

}

function getEventAsJson($newEvent)
{
    return json_encode($newEvent);
}


function checkValue($var): string
{
    if (isset($_POST["$var"]) && is_string($_POST["$var"])) {
        return htmlspecialchars($_POST["$var"]);
    } elseif (isset($newEvent["$var"]) && is_string($newEvent["$var"])) {
        return $newEvent["$var"];
    } else {
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
    global $items, $selectedItem;
    echo ' <section id="item-list">';
    foreach ($items as $band) {
        $members = '';
        foreach ($band->members as $member) {
            $members = $members . $member . '<br>';
        }
        $links = '';
        foreach ($band->links as $link) {
            $links = $links . $link . '<br>';
        }
        echo '
         <div id="item">
            <label class="item-head" pn>
                <img id="item-image" src="../../resources/images/bands/band.jpg" alt="bandImage"/>
                <div id="item-description" class="text-line-pre">
                    <span>Name: ' . $band->name . '</span>
                    <br>
                    <span>Genre: ' . $band->genre . '</span>
                    <br>
                    <span>' . count($band->members) . ' Members</span>
                    <br>
                    <span>' . $band->costs . '</span>
                    <input type="checkbox" id="item-click">
                </div>
            </label>
            <div id="item-m-details">
                <div id="item-details-title">
                    <img id="item-image" src="../../resources/images/bands/band.jpg" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $band->name . ' </h2>
                </div>
                <div>
                    <p>
                        ' . $members . '
                        ' . $band->email . ' <br>
                        <br>
                        ' . $band->costs . '<br>
                        <br>
                        ' . $band->region . ' <br>
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
    echo '</section>';
    echo '
    <section id="item-details">
        <div id="item-details-title">
                    <img id="item-image" src="../../resources/images/bands/band.jpg" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $band->name . ' </h2>
                </div>
        <div class="item-details-description">
                    <p>
                        ' . $members . '
                        ' . $band->email . ' <br>
                        <br>
                        ' . $band->costs . '<br>
                        <br>
                        ' . $band->region . ' <br>
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
    global $items, $currentItem;
    echo ' <section id="item-list">';
    foreach ($items as $event) {
        $address = $event->street . " " . $event->houseNr . "\n" . $event->postalCode . " " . $event->city;
        $time = $event->startTime . " - " . $event->endTime;

        echo '
         <div id="item">
            <label class="item-head">
                <img id="item-image" src="../../resources/images/events/event.jpg" alt="bandImage"/>
                <div id="item-description" class="text-line-pre">
                    <span>' . $event->name . '</span>
                    <br>
                    <span>Address: ' . $address . '</span>
                    <br>
                    <span>' . $time . '</span>
                    <input type="checkbox" id="item-click">
                </div>
            </label>
            <div id="item-m-details">
                <div id="item-details-title">
                    <img id="item-image" src="../../resources/images/events/event.jpg" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $event->name . ' </h2>
                </div>
                <div class="item-details-description">
                    <p>' . $event->description . '</p>
                </div>
                <div id="item-details-foot">
                    <p style="white-space: pre-line">
                        Hits <br>
                        ' . $event->requirements . '
                    </p>
                </div>
            </div>
         </div> ';
    }
    echo '</section>';
    echo '
    <section id="item-details">
         <div id="item-details-title">
                    <img id="item-image" src="../../resources/images/events/event.jpg" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $event->name . ' </h2>
                </div>
                <div class="item-details-description">
                    <p>' . $event->description . '</p>
                </div>
                <div id="item-details-foot">
                    <p style="white-space: pre-line">
                        Hits <br>
                        ' . $event->requirements . '
                    </p>
                </div>
    </section>';
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              getter                                                                */
/* ------------------------------------------------------------------------------------------------------------------ */




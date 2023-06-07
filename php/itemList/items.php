<?php
include 'classes.php';

global $decodedFile, $currentItem, $newEvent, $itemListManager, $eventStore;

$eventStore = new FileEventsStore("../resources/json/Events.json");

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
    $itemEvent = array(

        "id" => "kjsadflkjdsa",
        "authorId" => "asdadsjf",
        "image" => $eventImage,
        "description" => checkValue("description"),
        "name" =>checkValue("name"),
        "adress_ID" => "asjdshf",
        "street" => checkValue("street"),
        "city" => checkValue("city"),
        "Date" => checkValue("date"),
        "startTime" => checkValue("startTime"),
        "endTime" => checkValue("endTime"),
        "requirements" => checkValue("requirements"),
        "houseNr" => (int)checkValue("houseNr"),
        "postalCode" => (int)checkValue("postalCode")
    );
    $event = new Event($itemEvent);
    createNewEvent($event);
}

/**
 * @param Event $newEvent
 * @return false|void
 */
function createNewEvent(Event $newEvent) : bool
{
    global $eventStore;
    try {
        return $eventStore->store($newEvent);
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
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



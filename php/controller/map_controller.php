<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                            import and autoload classes                                             */
/* ------------------------------------------------------------------------------------------------------------------ */

namespace php\controller;

global $step, $geoLocApi, $error_message;

use php\includes\items\Event;

include $_SERVER['DOCUMENT_ROOT'] . '/autoloader.php';

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               http request functions                                               */
/* ------------------------------------------------------------------------------------------------------------------ */

$events = "";
$locations = "";

if (isset($_GET["map"]) && $_GET["map"] === "init") {
    if ($_SESSION["loggedIn"]["user"]->getDsr() === "y") {
        $_SESSION["map"] = '<div id="map"></div>';

        $_SESSION["itemList"] = getAllItems("events");

        // converts objects to json array
        // this is necessary for data transfer in ajax
        $events = array(); $locations = array();
        foreach ($_SESSION["events"] as $event) {
            $events[] = Event::toArrayForJsonEntry($event);
            $locations[] = $geoLocApi->getCoordinates($event->getStreetName(), $event->getHouseNumber(), $event->getPostalCode(), $event->getCity());
        }
        $events = json_encode($events);
        $locations = json_encode($locations);

    } else {
        $_SESSION["map"] = '<span>If you want to see the content of Third party companies accept the '.
            '<a id="agreementLinks" href="impressum.php">Legal Disclosure</a>, '.
            '<a id="agreementLinks" href="nutzungsbedingungen.php">Terms of Use</a> and the '.
            '<a id="agreementLinks" href="datenschutz.php">Privacy Policy.</span>';
    }
}

function check_address($item) : bool {
    global $geoLocApi, $error_message;

    if ($item->hasAddressInputs()) {

        if ($geoLocApi->validateAddress(
            $item->getStreetName(),
            $item->getHouseNumber(),
            $item->getPostalCode(),
            $item->getCity())) {
            return true;
        } else {
            $error_message = "Address does not exist! Please type in an existing Address.";
            $item->setStreetName("");
            $item->setHouseNumber("");
            $item->setPostalCode("");
            $item->setCity("");
            return false;
        }
    } else {
        return true;
    }
}

if (isset($_POST["check_address"])) {
    if (check_address($_SESSION["user"])) {
        // redirect to next sep
        header("Location: ".getNextUrl($step));
        exit();
    }
}

?>
<script>
    const list = <?php echo $events ?>;
    const event_locations = <?php echo $locations ?>;
</script>

                                    
    
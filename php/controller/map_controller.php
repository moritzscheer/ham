<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                            import and autoload classes                                             */
/* ------------------------------------------------------------------------------------------------------------------ */

namespace php;

global $geoLocApi;

use php\includes\items\Event;

include $_SERVER['DOCUMENT_ROOT'] . '/autoloader.php';

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               http request functions                                               */
/* ------------------------------------------------------------------------------------------------------------------ */

if(isset($_GET["map"]) && $_GET["map"] === "init") {
        if($_SESSION["loggedIn"]["user"]->getDsr() === "y") {
            $_SESSION["map"] = '<div id="map"></div>';
            
            $_SESSION["itemList"] = getAllItems("events");

            // converts objects to json array
            // this is necessary for data transfer in ajax
            $list = array();
            foreach ($_SESSION["events"] as $event) {
                $list[] = Event::toArrayForJsonEntry($event);
            }
            $_SESSION["events"] = $list;
        } else {
            $_SESSION["map"] = '<span>If you want to see the content of Third party companies accept the '.
                '<a id="agreementLinks" href="impressum.php">Legal Disclosure</a>, '.
                '<a id="agreementLinks" href="nutzungsbedingungen.php">Terms of Use</a> and the '.
                '<a id="agreementLinks" href="datenschutz.php">Privacy Policy.</span>';
        }
    }

    if(isset($_POST["check_address"])) {
        if($geoLocApi->validateAddress(
            $_SESSION["user"]->getStreetName(),
            $_SESSION["user"]->getHouseNumber(),
            $_SESSION["user"]->getPostalCode(),
            $_SESSION["user"]->getCity()))
        {
            // redirect to next sep
            header("Location: ".getNextUrl($step));
            exit();
        } else {
            $error_message = "Address does not exist! Please type in an existing Address.";
        }
    }

                                    
    
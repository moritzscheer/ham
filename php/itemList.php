<?php

global $type, $bandStore, $eventStore, $addressStore, $blobObj;


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                  item variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */



$_SESSION["event"] = $_SESSION["event"] ?? new Event();
$_SESSION["event_address"] = $_SESSION["event_address"] ?? new Address();

isset($_POST["event_name"]) && is_string($_POST["event_name"])   ?   $_SESSION["event"]->setName(htmlspecialchars($_POST["event_name"]))   :   "";
isset($_POST["description"]) && is_string($_POST["description"])   ?   $_SESSION["event"]->setDescription(htmlspecialchars($_POST["description"]))   :   "";
isset($_POST["requirements"]) && is_string($_POST["requirements"])   ?   $_SESSION["event"]->setRequirements(htmlspecialchars($_POST["requirements"]))   :   "";
isset($_POST["date"]) && is_string($_POST["date"])   ?   $_SESSION["event"]->setDate(htmlspecialchars($_POST["date"]))   :   "";
isset($_POST["startTime"]) && is_string($_POST["startTime"])   ?   $_SESSION["event"]->setStartTime(htmlspecialchars($_POST["startTime"]))   :   "";
isset($_POST["endTime"]) && is_string($_POST["endTime"])   ?   $_SESSION["event"]->setEndTime(htmlspecialchars($_POST["endTime"]))   :   "";
isset($_POST["event_street_name"]) && is_string($_POST["event_street_name"])   ?   $_SESSION["event_address"]->setStreetName(htmlspecialchars($_POST["event_street_name"]))   :   "";
isset($_POST["event_house_number"]) && is_string($_POST["event_house_number"])   ?   $_SESSION["event_address"]->setHouseNumber(htmlspecialchars($_POST["event_house_number"]))  :   "";
isset($_POST["event_postal_code"]) && is_string($_POST["event_postal_code"])   ?   $_SESSION["event_address"]->setPostalCode(htmlspecialchars($_POST["event_postal_code"]))   :   "";
isset($_POST["event_city"]) && is_string($_POST["event_city"])   ?   $_SESSION["event_address"]->setCity(htmlspecialchars($_POST["event_city"]))   :   "";

$itemList = (isset($_GET["type"]) && is_string($_GET["type"])) ? getItems($_GET["type"]) : "";



/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               account variables                                                    */
/* ------------------------------------------------------------------------------------------------------------------ */



if (isset($_POST["submit"])) {
    try {
        // if any address attribute is typed in an entry in the address table is created
        $_SESSION["event_address"] = $addressStore->create($_SESSION["event_address"]);
        $_SESSION["event"]->setAddressID($_SESSION["event_address"]->getAddressID());
        
        $_SESSION["event"] = $eventStore->create($_SESSION["event"]);
        
          // if an image was uploaded insert it in the files table
          $_FILES["image"] ?? $path = "../resources/images/events/" . verifyImage("image", "events");
          $blobObj->insertBlob($_SESSION["event"]->getEventID(), "event", $path, "image/gif");
            
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
}

/**
 *
 * Checks if the page shows events or bands and delegates to the method that fits for the page
 * @param $type
 * @return string
 */
function getItems($type): string {
    switch ($type) {
        case 'bands':
        {
            $result = getBands();
            break;
        }
        default:
        {
            $result = getEvents();
            break;
        }
    }
    return $result;
}




/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              get Event and get Bands method                                        */
/* ------------------------------------------------------------------------------------------------------------------ */



/**
 * Loads all event from the eventsstore and prints (echos) the html data to the page
 * @return string
 */
function getEvents(): string
{
    global $eventStore;

    $return = "";
    try {
        $events = $eventStore->findAll();

        foreach ($events as $event) {
            $return = $return . $event->getEventHTML($events);
        }
        return $return.getItemDetailHTML($events[0]);
    }
    catch (Exception $e){
        return $e->getMessage();
    }
}

/**
 * @param $item
 * @return string
 */
function getItemDetailHTML($item) : string {

    return $string =
        '<section id="item-details">                                                                           '.
        '    <div id="item-details-title">                                                                     '.
        '        <img id="item-image" src="' . $item->getImageSource() . '" alt="bandImage"/>                  '.
        '        <h2 id="item-details-name"> ' . $item->getName() . ' </h2>                                    '.
        '    </div>                                                                                            '.
        '    <div class="item-details-description">                                                            '.
        '        <p>' . $item->getDescription() . '</p>                                                        '.
        '    </div>                                                                                            '.
        '    <div id="item-details-foot">                                                                      '.
        '        <p class="text-line-pre" ">                                                                   '.
        '            Requirements <br>                                                                         '.
        '            ' . $item->getRequirements() . '                                                          '.
        '        </p>                                                                                          '.
        '    </div>                                                                                            '.
        ' </section>                                                                                           ';
}

/**
 * loads all Bands from the bandsstore and print (echos) the html data to the page
 * @return void
 */
function getBands(): string
{
    global $bandStore;
    $items = $bandStore->loadAll();

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


?>
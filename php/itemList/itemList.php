<?php

global $type, $bandStore, $eventStore;


$type = (isset($_GET["type"]) && is_string($_GET["type"])) ? $_GET["type"] : "";


/**
 *
 * Checks if the page shows events or bands and delegates to the method that fits for the page
 * @return void
 */
function getItems(): void
{
    global $type;
    switch ($type) {
        case 'bands':
        {
            getBands();
            break;
        }
        default:
        {
            getEvents();
            break;
        }
    }
}

/**
 * loads all Bands from the bandsstore and print (echos) the html data to the page
 * @return void
 */
function getBands(): void
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


/**
 * Loads all event from the eventsstore and prints (echos) the html data to the page
 * @return void
 */
function getEvents(): void
{
    global $eventStore;
    $items = $eventStore->loadAll();
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
?>
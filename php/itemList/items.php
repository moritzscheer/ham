<?php
global $type, $items, $decodedFile;

$type = (isset($_GET["type"]) && is_string($_GET["type"])) ? $_GET["type"] : "";
$items = [];
fillItems();

function fillItems(): void {
    global $type, $items;
    $file = file_get_contents( $type === 'bands' ? "Bands.json": "Events.json", true);
    $items = json_decode($file, false);
}


function getItems() {
    global $type;
    switch($type) {
        case 'bands': {
            return getBands();
        }
        default: {

        }
    }
}
function getBands(){
    global $items;
    foreach ($items as $band) {
        $members = '';
        foreach ($band -> members as $member) {
           $members = $members . $member .'<br>' ;
        }
        $links = '';
        foreach ($band -> links as $link) {
            $links = $links . $link .'<br>' ;
        }
        echo '<label class="item-head">
                <img id="item-image" src="../../resources/images/bands/band.jpg" alt="bandImage"/>
                <div id="item-description">
                    <span>Name: ' . $band-> name . '</span>
                    <br>
                    <span>Genre: ' . $band-> genre . '</span>
                    <br>
                    <span>' . count($band -> members) . ' Members</span>
                    <br>
                    <span>' . $band-> costs . '</span>
                    <input type="checkbox" id="item-click">
                </div>
            </label>
            <div id="item-m-details">
                <div id="item-details-title">
                    <img id="item-image" src="../../resources/images/bands/band.jpg" alt="bandImage"/>
                    <h2 id="item-details-name"> ' . $band-> name . ' </h2>
                </div>
                <div>
                    <p>
                        ' . $members . '
                        ' . $band-> email . ' <br>
                        <br>
                        ' . $band-> costs . '<br>
                        <br>
                        ' . $band-> region . ' <br>
                    </p>
                </div>
                <div id="item-details-foot">
                    <p style="white-space: pre-line">
                        Hits <br>
                        ' . $links . '
                    </p>
                </div>
            </div>';
    }
}

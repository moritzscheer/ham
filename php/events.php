<?php

/*
 * event structure
 *
 * image
 * description
 * name
 * street
 * houseNr
 * postalCode
 * city
 * Date
 * startTime
 * endTime
 * requirements
 *
 *
 */
/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              store                                                                 */
/* ------------------------------------------------------------------------------------------------------------------ */
global $newEvent;
$newEvent = [];

// dummy data

$newEvent["image"] = '';
$newEvent["description"] = 'Hornbach Bau- und Gartenmarkt eröffnet voraussichtlich im Frühjahr 2023 einen weiteren Markt in Leipzig auf rund 10.000 Quadratmetern und einem Gartenmarkt mit rund 3.000 Quadratmetern.';
$newEvent["name"] = "Hornbach Bau- und Gartenmarkt";
$newEvent["street"] = "Steinweg";
$newEvent["houseNr"] = 2;
$newEvent["postalCode"] = 42275;
$newEvent["city"] = "Wuppertal";

$newEvent["date"] = "2023-04-12";
$newEvent["startTime"] = "14:00";
$newEvent["endTime"] = "17:00";
$newEvent["requirements"] = "Jazzband mit Repertoir für einen Nachmittag (3std)
    Kostenlose Verpflegung
    Bis 2000€";


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              functions                                                             */
/* ------------------------------------------------------------------------------------------------------------------ */


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
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                              parser functions                                                             */
/* ------------------------------------------------------------------------------------------------------------------ */


initialize();

function initialize(): void
{
    global $xmlWriter;
    $xmlWriter = new XMLWriter();
    $xmlWriter->openMemory();
    $xmlWriter->startDocument('1.0', 'UTF-8');
    $xmlWriter->setIndent(true);
    $xmlWriter->startDocument();
    $xmlWriter->startElement('events');

}

function close(): void
{
    global $xmlWriter;
    $xmlWriter->endElement();
    $xmlWriter->endDocument();
    echo htmlspecialchars($xmlWriter->outputMemory());
}


function writeEvent(): void
{
    global $xmlWriter;
    $xmlWriter->startElement('event');

    writeElement('image');
    writeElement('description');
    writeElement('name');
    writeElement('street');
    writeElement('houseNr');
    writeElement('postalCode');
    writeElement('city');
    writeElement('date');
    writeElement('startTime');
    writeElement('endTime');
    writeElement('requirements');
    $xmlWriter->endElement();
}

function writeElement($el)
{
    global $xmlWriter;
    $xmlWriter->startElement($el);
    $xmlWriter->text(checkValue($el));
    $xmlWriter->endElement();
}

function checkValue($var): String {
    if (isset($_POST["$var"]) && is_string($_POST["$var"])) {
        return htmlspecialchars($_POST["$var"]);
    } elseif (isset($newEvent["$var"]) && is_string($newEvent["$var"])) {
        return $newEvent["$var"];
    } else {
        return "";
    }
}


?>
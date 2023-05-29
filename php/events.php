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
    $newEvent["image"] = checkVariable("image");
    $newEvent["description"] = checkVariable("description");
    $newEvent["name"] = checkVariable("name");

    $newEvent["street"] = checkVariable("street");
    $newEvent["houseNr"] = checkVariable("houseNr");
    $newEvent["postalCode"] = checkVariable("postalCode");
    $newEvent["city"] = checkVariable("city");

    $newEvent["date"] = checkVariable("date");
    $newEvent["startTime"] = checkVariable("startTime");
    $newEvent["endTime"] = checkVariable("endTime");
    $newEvent["requirements"] = checkVariable("requirements");
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

    $xmlWriter->startElement('street');
    $xmlWriter->writeAttribute('waehrung', 'Euro');
    $xmlWriter->text('4,80');
    $xmlWriter->endElement();
    $xmlWriter->endElement();
}

function writeElement($el)
{
    global $xmlWriter;
    $xmlWriter->startElement($el);
    $xmlWriter->text(checkVariable($el));
    $xmlWriter->endElement();
}


?>
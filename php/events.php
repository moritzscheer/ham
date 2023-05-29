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
/*                                              functions                                                             */
/* ------------------------------------------------------------------------------------------------------------------ */


initialize();

function initialize(): void {
    global $xmlWriter;
    $xmlWriter = new XMLWriter();
    $xmlWriter->openMemory();
    $xmlWriter->startDocument('1.0', 'UTF-8');
    $xmlWriter->setIndent(true);
    $xmlWriter->startDocument();
    $xmlWriter->startElement('events');

}

function close(): void {
    global $xmlWriter;
    $xmlWriter->endElement();
    $xmlWriter->endDocument();
    echo htmlspecialchars($xmlWriter->outputMemory());
}


function writeEvent(): void {
    global $xmlWriter;
    $xmlWriter->startElement('event');

    $xmlWriter->startElement('street');
    $xmlWriter->writeAttribute('waehrung', 'Euro');
    $xmlWriter->text('4,80');
    $xmlWriter->endElement();
    $xmlWriter->endElement();
}

function writeElement($el) {
    global $xmlWriter;
    $xmlWriter->startElement($el);
    $xmlWriter->text(checkVariable($el));
    $xmlWriter->endElement();
}


function checkVariable($var): String {
    if (isset($_POST["$var"]) && is_string($_POST["$var"])) {
        return htmlspecialchars($_POST["$var"]);
    } elseif (isset($_SESSION["$var"]) && is_string($_SESSION["$var"])) {
        return $_SESSION["$var"];
    } else {
        return "";
    }
}
?>
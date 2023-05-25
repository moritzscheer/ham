<?php
/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                 initialize variables                                               */
/* ------------------------------------------------------------------------------------------------------------------ */


$step1 = "hidden";
$step2 = "hidden";
$step3 = "hidden";
$step4 = "hidden";

$_SESSION["progress2"] = "inActive";
$_SESSION["progress3"] = "inActive";

$_SESSION["musician"] = "";
$_SESSION["host"] = "";

$step = (isset($_GET["step"]) && is_string($_GET["step"])) ? $_GET["step"] : "1";


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                               functions to switch urls                                             */
/* ------------------------------------------------------------------------------------------------------------------ */


function getNextUrl($var): String {
    $var++;
    return "register.php?step=" . $var;
}

function getLastUrl($var): String {
    $var--;
    return "register.php?step=" . $var;
}


/* ------------------------------------------------------------------------------------------------------------------ */
/*                                        setting variables to make steps visible                                     */
/* ------------------------------------------------------------------------------------------------------------------ */


if(!isset($_POST["cancel"])) {
    // different states depending on the $step
    if($step == 1) {
        $step1 = "visible";
    } elseif ($step == 2) {
        $step2 = "visible";
        $_SESSION["progress2"] = "active";
    }  elseif ($step == 3) {
        $step3 = "visible";
        $_SESSION["progress2"] = "active";
        $_SESSION["progress3"] = "active";
    } elseif($step == 4) {
        $step4 = "visible";
        $_SESSION["progress2"] = "active";
        $_SESSION["progress3"] = "active";
    }
}


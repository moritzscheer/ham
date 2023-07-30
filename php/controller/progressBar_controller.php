<?php

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                            import and autoload classes                                             */
/* ------------------------------------------------------------------------------------------------------------------ */

namespace php\controller;

global $step, $step_1, $step_2, $step_3, $step_4, $progress_2, $progress_3, $progressBar;

include $_SERVER['DOCUMENT_ROOT'] . '/autoloader.php';

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                                 initialize variables                                               */
/* ------------------------------------------------------------------------------------------------------------------ */

$step_1 = "hidden";
$step_2 = "hidden";
$step_3 = "hidden";
$step_4 = "hidden";

$progress_2 = "inActive";
$progress_3 = "inActive";

$progressBar = "";

$step = (isset($_GET["step"]) && is_string($_GET["step"])) ? $_GET["step"] : "1";

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                        setting variables to make steps visible                                     */
/* ------------------------------------------------------------------------------------------------------------------ */

if(!isset($_POST["cancel"])) {
    // different states depending on the $step
    if($step == 1) {
        $step_1 = "visible";
    } elseif ($step == 2) {
        $step_2 = "visible";
        $progress_2 = "active";
    }  elseif ($step == 3) {
        $step_3 = "visible";
        $progress_2 = "active";
        $progress_3 = "active";
    } elseif($step == 4) {
        $step_4 = "visible";
        $progressBar = "hidden";
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */
/*                                       functions to switch urls in register                                         */
/* ------------------------------------------------------------------------------------------------------------------ */

/**
 * gets the url for the next step in the register progressbar
 * @param $var
 * @return String
 */
function getNextUrl($var): String {
    $var++;
    return "register.php?step=" . $var;
}

/**
 * gets the url for the last step in the register progressbar
 * @param $var
 * @return String
 */
function getLastUrl($var): String {
    $var--;
    return "register.php?step=" . $var;
}
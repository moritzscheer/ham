<?php                                           
    global $mapApi, $step;

    if(isset($_GET["map"]) && $_GET["map"] === "init") {
        if($_SESSION["loggedIn"]["user"]->getDsr() === "y") {
            $_SESSION["map"] = '<div id="map"></div>';
            
            $_SESSION["itemList"] = getAllItems("");
        } else {
            $_SESSION["map"] = '<span>If you want to see the content of Third party companies accept the '.
                '<a id="agreementLinks" href="impressum.php">Legal Disclosure</a>, '.
                '<a id="agreementLinks" href="nutzungsbedingungen.php">Terms of Use</a> and the '.
                '<a id="agreementLinks" href="datenschutz.php">Privacy Policy.</span>';
        }
    }

    if(isset($_POST["check_address"])) {
        if($mapApi->validateAddress(
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

                                    
    
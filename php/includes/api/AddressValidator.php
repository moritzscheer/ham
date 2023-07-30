<?php

namespace php\includes\api;

use Exception;

class AddressValidator {
    
    private $api_key;

    private float $ACCEPT_LEVEL = 0.95;
    private float $DECLINE_LEVEL = 0.2;

    // Setting up api_key
    public function __construct( $api_key ) {
        $this->api_key = $api_key;
    }

    /**
     * @throws Exception
     */
    private function checkInputFields(object $item) : bool {
        global $error_message, $street_name, $house_number, $city, $postal_code;

        $flag = false;
        if (empty($item->getStreetName())) {
            $_SESSION["user"]->setStreetName("");
            $street_name = "address_error";
            $error_message = "Please fill in remaining Address Fields";
            $flag = true;
        }
        if (empty($item->getHouseNumber())) {
            $_SESSION["user"]->setHouseNumber("");
            $house_number = "address_error";
            $error_message = "Please fill in remaining Address Fields";
            $flag = true;
        }
        if (empty($item->getPostalCode())) {
            $_SESSION["user"]->setPostalCode("");
            $postal_code = "address_error";
            $error_message = "Please fill in remaining Address Fields";
            $flag = true;
        }
        if (empty($item->getCity())) {
            $_SESSION["user"]->setCity("");
            $city = "address_error";
            $error_message = "Please fill in remaining Address Fields";
            $flag = true;
        }
        return $flag;
    }

    /**
     * source: https://www.geoapify.com/validate-addresses-with-api
     * @param object $item
     * @return bool
     * @throws Exception
     */
    public function validateAddress(object $item) : bool {
        global $error_message, $house_number, $city, $postal_code;

        try {
            if (!$item->hasAddressInputs()) return true;

            if ($this->checkInputFields($item)) return false;

            // Construct the url
            $url = 'https://api.geoapify.com/v1/geocode/search?';
            $url .= 'street=' . urlencode($item->getStreetName());
            $url .= '&housenumber=' . urlencode($item->getHouseNumber());
            $url .= '&postcode=' . urlencode($item->getPostalCode());
            $url .= '&city=' . urlencode($item->getCity());
            $url .= '&format=json';
            $url .= '&apiKey=' . $this->api_key;

            // Get search results
            $response = json_decode(file_get_contents($url));

            // if no address was found
            if (count($response->results) === 0) throw new Exception();

            // get data from array
            $result = $response->results[0];

            if ($result->rank->confidence >= $this->ACCEPT_LEVEL && $result->postcode === $item->getPostalCode()) {
                // address is CONFIRMED
                return true;

            } else if ($result->rank->confidence < $this->DECLINE_LEVEL) {
                // address is NOT_CONFIRMED
                $error_message = "address not found";
                return false;

            } else {
                // address is PARTIALLY_CONFIRMED
                if (property_exists($result, "confidence_street_level")) {
                    if ($result->rank->confidence_street_level >= $this->ACCEPT_LEVEL) {
                        // BUILDING_NOT_FOUND
                        $_SESSION["user"]->setHouseNumber(""); // reset field
                        $house_number = "address_error"; // make border red
                        $error_message = "Building not found"; // display error message
                        return false;
                    }
                } else if (property_exists($result, "confidence_city_level")) {
                    if ($result->rank->confidence_city_level >= $this->ACCEPT_LEVEL) {
                        // STREET_LEVEL_DOUBTS

                        $_SESSION["user"]->setCity(""); // reset field
                        $_SESSION["user"]->setPostalCode("");
                        $city = "address_error"; // make border red
                        $postal_code = "address_error";
                        $error_message = "City not found"; // display error message
                        return false;
                    }
                }
                $error_message = "address not found";
                return false;
            }
        } catch (Exception) {
            return false;
        }
    }
}
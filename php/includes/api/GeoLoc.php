<?php

namespace php\includes\api;

use Exception;

class GeoLoc {
    
    private $api_key;

    // Setting up api_key
    public function __construct( $api_key ) {
        $this->api_key = $api_key;
    }

    /**
     * @param object $item
     * @return bool
     * @throws Exception
     */
    public function validateAddress(object $item) : bool
    {
        if ($item->getStreetName() === "" ||
            $item->getHouseNumber() === "" ||
            $item->getPostalCode() === "" ||
            $item->getCity() === "") {
            throw new Exception();
        }

        try {
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

            // Check if the status didn't fail
            if (!property_exists($response->results[0], "street") ||
                !property_exists($response->results[0], "housenumber") ||
                !property_exists($response->results[0], "postcode") ||
                !property_exists($response->results[0], "city")) {
                throw new Exception();
            }
            return true;
        } catch (Exception) {
            return false;
        }
    }
    
    /**
     * @return array|bool
     * @source: https://www.codexworld.com/get-geolocation-country-latitude-longitude-from-ip-address-using-php/
     */
    public function getOwnCoordinates() : array|bool {
        $url = 'https://www.geoplugin.net/php.gp?';
        $url .= 'ip='.$_SERVER['REMOTE_ADDR'];
        $url .= '?access_key=ebd07dc289f9fba78d7dd33bdcb88827';
        $geoIP  = unserialize(file_get_contents($url));
        return array("lon" => $geoIP['geoplugin_longitude'], "lat" => $geoIP['geoplugin_latitude']);
    }

    /**
     * @param $street
     * @param $houseNr
     * @param $postalCode
     * @param $city
     * @return array|bool
     */
    public function getCoordinates($street, $houseNr, $postalCode, $city) : array|bool {
        try {
            // Construct the url
            $url = 'https://api.geoapify.com/v1/geocode/search?';
            $url .= 'street=' . urlencode($street);
            $url .= '&housenumber=' . urlencode($houseNr);
            $url .= '&postcode=' . urlencode($postalCode);
            $url .= '&city=' . urlencode($city);
            $url .= '&format=json';
            $url .= '&apiKey=' . $this->api_key;

            // Get search results
            $response = json_decode(file_get_contents($url));

            // Check if the status didn't fail
            if( !property_exists($response->results[0], "street") ||
                !property_exists($response->results[0], "postcode") ||
                !property_exists($response->results[0], "city")) {
                throw new Exception();
            }
            
            return array("lon" => $response->results[0]->lon, "lat" => $response->results[0]->lat);
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @param $location1
     * @param $location2
     * @return float
     * @source: https://stackoverflow.com/questions/639695/how-to-convert-latitude-or-longitude-to-meters
     */
    public function getDistance($location1, $location2) : float {
        $radius = 6378.137; // Radius of earth in KM
        $dLat = $location2["lat"] * pi() / 180 - $location1["lat"] * pi() / 180;
        $dLon = $location2["lon"] * pi() / 180 - $location1["lon"] * pi() / 180;
        $a = sin($dLat/2) * sin($dLat/2) +
            cos($location1["lat"] * pi() / 180) * cos($location2["lat"] * pi() / 180) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $radius * $c;
        return $d * 1000; // meters
    }
}
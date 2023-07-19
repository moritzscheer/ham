<?php

class GeoLocation {
    
    private $api_key;

    // Setting up api_key
    public function __construct( $api_key ) {
        $this->api_key = $api_key;
    }

    /**
     * @param $street
     * @param $houseNr
     * @param $postalCode
     * @param $city
     * @return bool
     */
    public function validateAddress($street, $houseNr, $postalCode, $city) : bool
    {
        $street = urlencode($street);
        $houseNr = urlencode($houseNr);
        $postalCode = urlencode($postalCode);
        $city = urlencode($city);

        try {
            // Construct the url
            $url = 'https://api.geoapify.com/v1/geocode/search?';
            $url .= '&street=' . $street;
            $url .= '&housenumber=' . $houseNr;
            $url .= '&postcode=' . $postalCode;
            $url .= '&city=' . $city;
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
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * @return array|bool
     * @source: https://www.codexworld.com/get-geolocation-country-latitude-longitude-from-ip-address-using-php/
     */
    public function getOwnCoordinates() : array|bool {
        $url = 'http://www.geoplugin.net/php.gp?';
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
        $street = urlencode($street);
        $houseNr = urlencode($houseNr);
        $postalCode = urlencode($postalCode);
        $city = urlencode($city);

        try {
            // Construct the url
            $url = 'https://api.geoapify.com/v1/geocode/search?';
            $url .= '&street=' . $street;
            $url .= '&housenumber=' . $houseNr;
            $url .= '&postcode=' . $postalCode;
            $url .= '&city=' . $city;
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
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $location1
     * @param $location2
     * @return float
     * @source: https://www.geodatasource.com/resources/tutorials/how-to-calculate-the-distance-between-2-locations-using-php/
     */
    public function getDistance($location1, $location2) : float {
        $theta = $location1["lon"] - $location2["lon"];
        $dist = sin(deg2rad($location1["lat"])) * sin(deg2rad($location2["lat"])) +  cos(deg2rad($location1["lat"])) * cos(deg2rad($location2["lat"])) * cos(deg2rad($theta));
        $dist = acos($dist);
        return rad2deg($dist);
    }
}
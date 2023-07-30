<?php

namespace php\includes\api;

use Exception;

//source: https://stackoverflow.com/questions/19452378/why-wont-the-images-that-are-grabbed-from-flickr-display
class Flickr {

    private $api_key;

    // Setting up flickr_key and flickr_secret
    public function __construct( $api_key ) {
        $this->api_key = $api_key;
    }

    public function searchPhotos($tag, $page) : string {
        try {
            $tag = urlencode($tag);
    
            // Construct the url
            $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
            $url .= '&api_key='.$this->api_key;
            $url .= '&text='.$tag;
            $url .= '&tags='.$tag;
            $url .= '&media=photos';
            $url .= '&safe_search=1';
            $url .= '&per_page=120';
            $url .= '$page='.$page;
            $url .= '&format=json';
            $url .= '&nojsoncallback=1';

            // Get search results
            $response = json_decode(file_get_contents($url));

            // Check if the status didn't fail
            if ($response->stat === "fail") throw new Exception();

            $photo_array = $response->photos->photo;

            $count = 0;
            $string = "";

            foreach($photo_array as $single_photo) {
                $farm_id = $single_photo->farm;
                $server_id = $single_photo->server;
                $photo_id = $single_photo->id;
                $secret_id = $single_photo->secret;
                $size = 'b';

                $title = $single_photo->title;

                $photo_url = 'https://farm' . $farm_id . '.staticflickr.com/' . $server_id . '/' . $photo_id . '_' . $secret_id . '_' . $size . '.' . 'jpg';

                if ($count % 3 === 0) {
                    if ($count % 2 == 0) {
                        $string = $string . ' <div id="flickr_row" class="flickr_row_even"> ';
                    } else {
                        $string = $string . ' <div id="flickr_row" class="flickr_row_odd"> ';
                    }
                }
                $string = $string
                    . ' <label> '
                    . '     <input type=submit name="select_image" value="' . $photo_url . '"> '
                    . '     <img title="' . $title . '" src="' . $photo_url . '" />'
                    . ' </label> ';
                if ($count % 3 === 2) {
                    $string = $string . ' </div> ';
                }
                $count++;
            }
            return $string;
        } catch (Exception) {
            return "Could not load any fotos. Try again.";
        }
    }
}
<?php
global $blobObj;

$api_key = '3b8e15fa98c7850431166704a6ed5be0';

$_SESSION["flickr_search"] = $_SESSION["flickr_search"] ?? "";
$_SESSION["selectImageBox"] = $_SESSION["selectImageBox"] ?? "";

$_SESSION["profile_preview"] = $_SESSION["profile_preview"] ?? array("source" => "", "category" => "");

if (isset($_POST["onEditImage"])) {
    if($_POST["onEditImage"] === "hide") {
        $_SESSION["ImageBox"] = "hidden";
    } else {
        $_SESSION["ImageBox"] = "visible";

        // sets the category of the image
        $_SESSION["profile_preview"]["category"] = $_POST["onEditImage"];
    }
}

/**
 * sets the preview image to the uploaded image
 */
if (isset($_POST["upload_image"])) {
    try {
        $_SESSION["profile_preview"]["source"] = "../resources/images/profile/custom/".verifyImage($_POST["upload_image"], "profile/custom");
        var_dump($_SESSION["profile_preview"]);
    } catch (RuntimeException $ex) {
        $error_message = "could not upload Image";
    }
}

/**
 * sets the preview image to the selected image
 */
if (isset($_POST["select_image"])) {
    $_SESSION["profile_preview"]["source"] =  $_POST["select_image"];
}

/**
 * submits the preview image
 */
if(isset($_POST["submit_image"])) {
    var_dump($_SESSION["profile_preview"]);
    $blobObj->insertBlob($_SESSION["loggedIn"]["user"]->getUserID(), $_SESSION["profile_preview"]["category"], $_SESSION["profile_preview"]["source"], "image/gif");
    unset($_SESSION["profile_preview"]);
}

/**
 * gets flickr images depending on the search tags
 */
if(isset($_POST["flickr_search"])) {
    $tag = $_POST["flickr_search"];

    $perPage = 25;
    $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
    $url.= '&api_key='.$api_key;
    $url.= '&tags='.$tag;
    $url.= '&per_page='.$perPage;
    $url.= '&format=json';
    $url.= '&nojsoncallback=1';

    $response = json_decode(file_get_contents($url));
    $photo_array = $response->photos->photo;

    $_SESSION["flickr_search"] = "";

    foreach($photo_array as $single_photo){
        $farm_id = $single_photo->farm;
        $server_id = $single_photo->server;
        $photo_id = $single_photo->id;
        $secret_id = $single_photo->secret;
        $size = 'm';

        $title = $single_photo->title;

        $photo_url = 'http://farm'.$farm_id.'.staticflickr.com/'.$server_id.'/'.$photo_id.'_'.$secret_id.'_'.$size.'.'.'jpg';

        $_SESSION["flickr_search"] = $_SESSION["flickr_search"]
            . ' <label> '
            . '     <input type=submit name="select_image" value="'.$photo_url.'"> '
            . '     <img title="'.$title.'" src="'.$photo_url.'" />'
            . ' </label> ';
    }
}

function addImage($user_ID, $url, $alturl, $category, $isEdit) : string {
    global $blobObj;
    try {
        $ids = $blobObj->queryID($user_ID, $category);

        $string = "";
        foreach ($ids as $image) {
            $a = $blobObj->selectBlob($image[0]);

            if($isEdit) {
                $string = $string.
                    '<div>                                                                                                         '.
                    '    <img src="data:' . $a['mime'] . ';base64,' . base64_encode($a['data']) . '" alt="could not load image"/>  '.
                    '    <label id="exit">X                                                                                        '.
                    '         <input type="submit" name="onDeleteImage" value="' . $image[0] . '">                                 '.
                    '    </label>                                                                                                  '.
                    '</div>                                                                                                        ';
            } else {
                $string = $string.'<img src="data:' . $a['mime'] . ';base64,' . base64_encode($a['data']) . '" alt="could not load image"/>';
            }
        }
        return $string;
    } catch (RuntimeException $e) {
        return $alturl;
    }
}














//source: https://stackoverflow.com/questions/19452378/why-wont-the-images-that-are-grabbed-from-flickr-display
class Flickr {

    private $flickr_key;
    private $flickr_secret;
    private $format = 'json';

    // Setting up flickr_key and flickr_secret
    public function __construct( $flickr_key ) {

        $this->flickr_key = $flickr_key;
    }

    public function searchPhotos( $query = '', $tags = '' ){

        $urlencoded_tags = array( 'animals', 'design', 'phones');

        if ( !empty( $args )) {

            $tags_r = explode( ',', $tags );
            foreach ( $tags_r as $tag ) {

                $urlencoded_tags[] = urlencode( $tag );
            }
        }

        // Construct the url
        $url  = 'http://api.flickr.com/services/rest/?';
        $url .= 'method=flickr.photos.search';
        $url .= '&text=' . urlencode( $query );
        $url .= '&tags=' . implode( ',', $urlencoded_tags );
        $url .= '&sort=relevance';
        $url .= '&safe_search=1';
        $url .= '&content_type=4';
        $url .= '&api_key=' . $this->flickr_key;
        $url .= '&format=' . $this->format;
        $url .= '&per_page=10';

        // Calling url using curl
        $curl = curl_init();

        curl_setopt_array( $curl, array(

            CURLOPT_TIMEOUT => 120,
            CURLOPT_URL => $url,
        ));

        if ( !curl_exec( $curl )) {

            die ( 'Error: "' . curl_error( $curl ) . '" - Code: ' . curl_errno( $curl ));
        }

        // Get search results
        $result = file_get_contents( $url );

        // Remove the unneccessary strings that wraps the result returned from the API
        $json = substr( $result, strlen( "jsonFlickrApi("), strlen( $result ) - strlen( "jsonFlickrApi(") - 1 );

        $photos = array();
        $data = json_decode( $json, true );

        // Check if the status didn't fail
        if ( $data['stat'] != 'fail' ) {

            /** Return only the data for the photos
            as that's the only thing that we need
             */
            $photos = $data['photos']['photo'];
            return $photos;
        } else {
            return false;
        }
    }

}



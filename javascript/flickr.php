<?php

$api_key = '3b8e15fa98c7850431166704a6ed5be0';

$_SESSION["flickr_search"] = "";
$tag = "";

if(isset($_POST["flickr_search"]) && is_string($_POST["flickr_search"])) {
    $tag = $_POST["flickr_search"];
}

$perPage = 25;
$url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
$url.= '&api_key='.$api_key;
$url.= '&tags='.$tag;
$url.= '&per_page='.$perPage;
$url.= '&format=json';
$url.= '&nojsoncallback=1';

$response = json_decode(file_get_contents($url));
$photo_array = $response->photos->photo;

foreach($photo_array as $single_photo){

    $farm_id = $single_photo->farm;
    $server_id = $single_photo->server;
    $photo_id = $single_photo->id;
    $secret_id = $single_photo->secret;
    $size = 'm';

    $title = $single_photo->title;

    $photo_url = 'http://farm'.$farm_id.'.staticflickr.com/'.$server_id.'/'.$photo_id.'_'.$secret_id.'_'.$size.'.'.'jpg';

    $_SESSION["flickr_search"] = $_SESSION["flickr_search"]
        . ' <div> '
        . ' <input type=submit name="select_image" value="'.$photo_url.'"> '
        . ' <img title="'.$title.'" src="'.$photo_url.'" />'
        . ' <div> ';

}



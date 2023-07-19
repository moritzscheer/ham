<?php

// items
include_once "../php/includes/items/Item.php";
include_once "../php/includes/items/Address.php";
include_once "../php/includes/items/User.php";
include_once "../php/includes/items/Event.php";

// api's
include_once "../php/includes/api/Flickr.php";
include_once "../php/includes/api/GeoLocation.php";

// memory stores
include_once "../stores/memory/FileUserStore.php";
include_once "../stores/memory/FileEventStore.php";

// database stores
include_once "../stores/database/DBBlobStore.php";
include_once "../stores/database/DBUserStore.php";
include_once "../stores/database/DBAddressStore.php";
include_once "../stores/database/DBEventStore.php";

// session settings and init stores
include_once "../php/settings.php";

// controller 
include_once "../php/controller/user_controller.php";
include_once "../php/controller/item_controller.php";
include_once "../php/controller/flickr_controller.php";
include_once "../php/controller/map_controller.php";


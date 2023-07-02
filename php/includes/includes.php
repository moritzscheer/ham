<?php

// items
include_once "../php/includes/Item/Address.php";
include_once "../php/includes/Item/User.php";
include_once "../php/includes/Item/Event.php";

// api's
include_once "../php/includes/api/Flickr.php";

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
include_once "../php/controller/account.php";
include_once "../php/controller/itemList.php";
include_once "../php/controller/flickr.php";


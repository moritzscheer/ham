<?php
include "../php/includes/Item/Address.php";
include "../php/includes/Item/User.php";
include "../php/includes/Item/Event.php";

// memory stores
include "../stores/memory/FileUserStore.php";
include "../stores/memory/FileEventStore.php";

// database stores
include "../stores/database/DBBlobStore.php";
include "../stores/database/DBUserStore.php";
include "../stores/database/DBAddressStore.php";
include "../stores/database/DBEventStore.php";

// session settings and init stores
include "../php/settings.php";

// controller 
include "../php/controller/account.php";
include "../php/controller/itemList.php";
include "../php/controller/flickr.php";
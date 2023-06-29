<?php
include_once "../php/includes/dto/Address.php";
include_once "../php/includes/dto/User.php";
include_once "../php/includes/dto/Event.php";

include_once "../stores/memory/FileUserStore.php";
include_once "../stores/memory/FileEventStore.php";

include_once "../stores/database/DBBlobStore.php";
include_once "../stores/database/DBUserStore.php";
include_once "../stores/database/DBAddressStore.php";
include_once "../stores/database/DBEventStore.php";

include_once "../stores/interface/UserStore.php";
include_once "../stores/interface/AddressStore.php";
include_once "../stores/interface/EventStore.php";
include_once "../stores/interface/Store.php";

include_once "../php/settings.php";
include_once "../php/controller/account.php";
include_once "../php/controller/itemList.php";
include_once "../php/controller/flickr.php";
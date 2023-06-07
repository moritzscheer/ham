<?php
include_once "../stores/interface/EventStore.php";


class DBEventStore implements EventStore
{

    private PDO $db;
    private Store $addressStore;

    public function __construct(PDO $db, Store $addressStore)
    {
        $this->db = $db;
        $this->addressStore = $addressStore;

        $tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table';");
        $tables = $tablesquery->fetchArray(SQLITE3_ASSOC);



        $sql = "CREATE TABLE event (
            event_ID INTEGER PRIMARY KEY AUTOINCREMENT,
            image BLOB DEFAULT NULL,
            name varchar(40) DEFAULT NULL,
            address_ID int(11) DEFAULT NULL,
            date varchar(20) DEFAULT NULL,
            startTime varchar(20) DEFAULT NULL,
            endTime varchar(20) DEFAULT NULL,
            );";
        $this->db->exec($sql);
    }


    public function create(Event $item):Event
    {
        //  create address
        $address = new StdClass();
        $address->street = $item->getStreet();
        $address->houseNr = $item->getHouseNr();
        $address->postalCode = $item->getPostalCode();
        $address->city = $item->getCity();

        $address = $this->addressStore->create($address);

        $create = "INSERT INTO event (image ,description,name,address_ID,date,startTime ,endTime, requirements)
                    VALUES (" . ibase_blob_create($item -> getImage()).
            "," . $item->getDescription() .
            "," . $item->getName() .
            "," . $address->id.
            "," . $item->getDate() .
            "," . $item->getStartTime() .
            "," . $item->getEndTime() .
            "," . $item->getRequirements() .
            ");";
        $this->db->exec($create);
        return $this->findOne($this->db->lastInsertId());
    }

    public function update(Event $item):Event
    {

        // update address
        $address = new StdClass();
        $address->street = $item->getStreet();
        $address->houseNr = $item->getHouseNr();
        $address->postalCode = $item->getPostalCode();
        $address->city = $item->getCity();

        $this->addressStore->update($address);


        $update = "UPDATE event 
            SET image = ".$item->getImage() . ",
            description = ".$item->getDescription() . ",
            name = ".$item->getName() . ",
            date = ".$item->getDate() . ",
            startTime = ".$item->getStartTime() . ",
            endTime = ".$item->getEndTime() . ",
            requirements = ".$item->getRequirements() . "
            WHERE event_ID = ". $item-> getId().";";

        $this->db->exec($update);

        return $this->findOne($item-> getId());

    }

    public function delete(string $id): void
    {
        $delete = "DELETE FROM event WHERE event_ID = " . $id;
        $this->db->exec($delete);
    }

    public function findOne(string $id): Event
    {
        $findOne ="SELECT * FROM event 
                     WHERE event_ID = " . $id."
                     INNER JOIN address 
                     ON address.address_ID = event.address_ID;
                     LIMIT 1";
        return new Event($this->db->query($findOne)->fetch());
    }

    public function findMany(array $ids): array
    {
        foreach ($ids as $key => $id) {
            $ids[$key] = "event_ID = " . $id;
        }
        $findMany ="SELECT * FROM event 
                     WHERE ". $ids.join(" OR ") ."
                     INNER JOIN address 
                     ON address.address_ID = event.address_ID;
                     LIMIT " .count($ids);
        $events = $this->db->query($findMany)->fetchAll();
        foreach ($events as $key => $event) {
            $events[$key] = new Event($event);
        }
        return $events;

    }

    public function findAll(): array
    {
        $findAll = "SELECT * FROM event
                    INNER JOIN address 
                    ON address.address_ID = event.address_ID;";
        $events = $this->db->query($findAll)->fetchAll();
        foreach ($events as $key => $event) {
            $events[$key] = new Event($event);
        }
        return $events;
    }
}

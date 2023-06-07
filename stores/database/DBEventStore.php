<?php
include_once "../stores/interface/EventStore.php";

global $db;

class DBEventStore implements EventStore
{

    private PDO $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }


    public function create(EventItem $item): EventItem
    {
        //  create address
        $create = "INSERT INTO address (street_name, house_number, postal_code, city)
                    VALUES (" . $item->getStreet() .
            "," . $item->getHouseNr() .
            "," . $item->getPostalCode() .
            "," . $item->getCity() .
            ")";

        $addressId = $this->db->exec($create);

        $create = "INSERT INTO event (image ,description,name,address_ID,date,startTime ,endTime, requirements)
                    VALUES (" . ibase_blob_create($item -> getImage()).
            "," . $item->getDescription() .
            "," . $item->getName() .
            "," . $addressId .
            "," . $item->getDate() .
            "," . $item->getStartTime() .
            "," . $item->getEndTime() .
            "," . $item->getRequirements() .
            ");";
        $eventId = $this->db->exec($create);
        return $this->findOne($eventId);
    }

    public function update(EventItem $item): EventItem
    {
        //  edit address
        $update = "UPDATE ADDRESS 
            SET street_name = ".$item->getStreet() . ",
            house_number = ".$item->getHouseNr() . ",
            postal_code = ".$item->getPostalCode() . ",
            city = ".$item->getCity() . "
            WHERE address_ID = ". $item-> getId().";";

        $this->db->exec($update);

    }

    public function delete(string $id): void
    {
        $delete = "DELETE FROM event WHERE event_ID = " . $id;
        $this->db->exec($delete);
    }

    public function findOne(string $id): EventItem
    {
        $findOne ="SELECT * FROM event 
                     WHERE event_ID = " . $id."
                    LIMIT 1";
        return $this->db->exec($findOne);
    }

    public function findMany(array $ids)
    {
        foreach ($ids as $id) {
            $id = "event_ID = " . $id;
        }
        $findMany ="SELECT * FROM event 
                     WHERE ". $ids.join(" OR ") ." LIMIT " .count($ids);
        return $this->db->exec($findMany);

    }

    public function findAll()
    {
        $findAll = "SELECT * FROM event ";
        return $this->db->exec($findAll);
    }


}

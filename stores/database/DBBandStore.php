<?php


global $db;

class DBBandStore
{

    private PDO $db;
    private Blob $blobObj;

    public function __construct(PDO $db, Store $addressStore)
    {
        $this->db = $db;
        $this->addressStore = $addressStore;

        $sql = "CREATE TABLE IF NOT EXISTS band (
            band_ID INTEGER PRIMARY KEY AUTOINCREMENT,
            image BLOB DEFAULT NULL,
            name varchar(40) DEFAULT NULL,
            address_ID int(11) DEFAULT NULL,
            date varchar(20) DEFAULT NULL,
            startTime varchar(20) DEFAULT NULL,
            endTime varchar(20) DEFAULT NULL
            );";
        $this->db->exec($sql);
    }


    public function create(Event $item)
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
        $eventId = $this->db->exec($create);
        return $this->findOne($eventId);
    }

    public function update(Event $item)
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

    public function findOne(string $id)
    {
        $findOne ="SELECT * FROM event 
                     WHERE event_ID = " . $id."
                     INNER JOIN address 
                     ON address.address_ID = event.address_ID;
                     LIMIT 1";
        return $this->db->exec($findOne);
    }

    public function findMany(array $ids)
    {
        foreach ($ids as $id) {
            $id = "event_ID = " . $id;
        }
        $findMany ="SELECT * FROM event 
                     WHERE ". $ids.join(" OR ") ."
                     INNER JOIN address 
                     ON address.address_ID = event.address_ID;
                     LIMIT " .count($ids);
        return $this->db->exec($findMany);

    }

    public function findAll()
    {
        $findAll = "SELECT * FROM event
                    INNER JOIN address 
                    ON address.address_ID = event.address_ID;";
        return $this->db->exec($findAll);
    }
}
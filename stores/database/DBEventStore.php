<?php
include_once "../stores/interface/EventStore.php";


class DBEventStore implements EventStore
{

    private PDO $db;
    private Store $addressStore;
private Blob $blobObj;

    public function __construct(PDO $db, Store $addressStore, Blob $blobObj) {
        $this->db = $db;
        $this->addressStore = $addressStore;
        $this->blobObj = $blobObj;

        $sql = "CREATE TABLE IF NOT EXISTS event (
            event_ID INTEGER PRIMARY KEY AUTOINCREMENT,
            address_ID int(11) DEFAULT NULL,
            name varchar(40) DEFAULT NULL,
            description varchar(20) DEFAULT NULL,
            requirements varchar(20) DEFAULT NULL,
            date varchar(20) DEFAULT NULL,
            startTime varchar(20) DEFAULT NULL,
            endTime varchar(20) DEFAULT NULL,
            FOREIGN KEY (address_ID) REFERENCES address(address_ID)
        );";
        $db->exec($sql);
    }


    public function create(Event $item):Event {
        $sql = "INSERT INTO event (address_ID, name, description, requirements, date, startTime , endTime) VALUES (
            '".$item->getAddressID()."',
            '".$item->getName()."',
            '".$item->getDescription()."',
            '".$item->getRequirements()."',
            '".$item->getDate()."',             
            '".$item->getStartTime()."',
            '".$item->getEndTime()."'
        );";

          $this->db->exec($sql);
        return $this->findOne($this->db->lastInsertId());
    }

    public function update(Event $item):Event {
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



    public function delete(string $id): void {
        $delete = "DELETE FROM event WHERE event_ID = " . $id;
        $this->db->exec($delete);
    }




    public function findOne(string $id): Event {
        $findOne ="SELECT * FROM event 
                     WHERE event_ID = '".$id."';";
        return Event::withoutAddress($this->db->query($findOne)->fetch());
    }




    public function findMany(array $ids): array {
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




    public function findAll(): array {
        $sql = "SELECT * FROM event
                    INNER JOIN address 
                    ON address.address_ID = event.address_ID;";
        $stmt = $this->db->query($sql)->fetchAll();
     

        $return = array();
        foreach ($stmt as $key) {
            $newEvent = Event::withAddress($key);

            try {
                $imageID = $this->blobObj->queryID($key["event_ID"], "event");
                $blobArray = $this->blobObj->selectBlob($imageID);
                $newEvent->setDate($blobArray);
            } catch (RuntimeException $ex) {
                $return[] = $newEvent;
            }
        }
        return $return;
    }
}

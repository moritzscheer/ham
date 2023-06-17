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
            user_ID int(11) NOT NULL,
            name varchar(40) DEFAULT NULL,
            description varchar(20) DEFAULT NULL,
            requirements varchar(20) DEFAULT NULL,
            date varchar(20) DEFAULT NULL,
            startTime varchar(20) DEFAULT NULL,
            endTime varchar(20) DEFAULT NULL,
            FOREIGN KEY (user_ID) REFERENCES user(user_ID),
            FOREIGN KEY (address_ID) REFERENCES address(address_ID)
        );";
        $db->exec($sql);
    }


    /**
     * @throws Exception
     */
    public function create(Event $item):Event {
        try {
            $this->db->beginTransaction();
            //  create address
            $address = new Address();
            $address->setStreetName($item->getStreetName());
            $address->setHouseNumber($item->getHouseNumber());
            $address->setPostalCode($item->getPostalCode());
            $address->setCity($item->getCity());

            $address = $this->addressStore->create($address);

            // inserting an entry
            $sql = "INSERT INTO event (address_ID, user_ID, name, description, requirements, date, startTime , endTime) VALUES (
                '".$address->getAddressID()."',
                '".$item->getUserID()."',
                '".$item->getName()."',
                '".$item->getDescription()."',
                '".$item->getRequirements()."',
                '".$item->getDate()."',             
                '".$item->getStartTime()."',
                '".$item->getEndTime()."');";
            $this->db->exec($sql);

            $event = $this->findOne($this->db->lastInsertId());
            $this->db->commit();
            return $event;
        } catch (Exception $ex) {
            $this->db->rollBack();
            throw new Exception("could not create Event");
        }
    }

    public function update(Event $item):Event {
        $this->db->beginTransaction();

        $sql = "UPDATE event 
            SET image = ".$item->getImageSource() . ",
            description = ".$item->getDescription() . ",
            name = ".$item->getName() . ",
            date = ".$item->getDate() . ",
            startTime = ".$item->getStartTime() . ",
            endTime = ".$item->getEndTime() . ",
            requirements = ".$item->getRequirements() . "
            WHERE event_ID = ". $item-> getEventID().";";

        $this->db->exec($sql);

        $event = $this->findOne($this->db->lastInsertId());
        $this->db->commit();
        return $event;
    }



    public function delete(string $id): void {
        $delete = "DELETE FROM event WHERE event_ID = " . $id;
        $this->db->exec($delete);
    }




    public function findOne(string $id): Event {
        $findOne ="SELECT * FROM event 
                     WHERE event_ID = '".$id."';";
        return Event::withAddress($this->db->query($findOne)->fetch());
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
        foreach ($stmt as $event) {
            $newEvent = Event::withAddress($event);

            try {
                $imageID = $this->blobObj->queryID($event["event_ID"], "event");
                $blobArray = $this->blobObj->selectBlob($imageID[0]["id"]);
                $newEvent->setBlobData($blobArray);
                $return[] = $newEvent;
            } catch (RuntimeException $ex) {
                $return[] = $newEvent;
            }
        }
        return $return;
    }
}

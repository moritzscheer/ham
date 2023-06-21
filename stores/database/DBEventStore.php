<?php
include_once "../stores/interface/EventStore.php";


class DBEventStore implements EventStore {

    private PDO $db;
    private Store $addressStore;
    private Blob $blobObj;

    public function __construct(PDO $db, Store $addressStore, Blob $blobObj) {
        $this->db = $db;
        $this->addressStore = $addressStore;
        $this->blobObj = $blobObj;

        // creates the event table
        $sql = "CREATE TABLE IF NOT EXISTS event (".
               "event_ID INTEGER PRIMARY KEY AUTOINCREMENT, ".
               "address_ID int(11) DEFAULT NULL, ".
               "user_ID int(11) NOT NULL, ".
               "name varchar(40) DEFAULT NULL, ".
               "description varchar(20) DEFAULT NULL, ".
               "requirements varchar(20) DEFAULT NULL, ".
               "date varchar(20) DEFAULT NULL, ".
               "startTime varchar(20) DEFAULT NULL, ".
               "endTime varchar(20) DEFAULT NULL, ".
               "FOREIGN KEY (user_ID) REFERENCES user(user_ID), ".
               "FOREIGN KEY (address_ID) REFERENCES address(address_ID));";
        $db->exec($sql);
    }

    /**
     * @throws Exception
     */
    public function create(Event $item):Event {
        try {
            $this->db->beginTransaction();

            // checking if an entry already exist with the name
            $sql = "SELECT * FROM event WHERE name = '".$item->getName()."';";
            $stmt = $this->db->query($sql)->fetch();
            if($stmt !== false) {
                throw new Exception("There is already an Event called ".$item->getName()."!");
            }

            //  creates address if user has put anything in any address field
            if($item->getStreetName() !== "" || $item->getHouseNumber() !== "" || $item->getPostalCode() !== "" || $item->getCity() !== "") {
                $address = $this->addressStore->create($item);
                $item->setAddressID($address->getAddressID());
            }

            // inserting an entry
            $sql = "INSERT INTO event (".$item->getKeys(false).") VALUES (".$item->getValues(false).");";
            $this->db->exec($sql);
            $item = $this->findOne($this->db->lastInsertId());
            $this->db->commit();
            return $item;
        } catch (Exception $ex) {
            $this->db->rollBack();
            throw new Exception(" ");
        }
    }

    /**
     * @param Event $item
     * @return Event
     */
    public function update(Event $item):Event {
        $this->db->beginTransaction();

        $sql = "UPDATE event SET ".
               "image = '".$item->getImageSource()."' ".
               "description = '".$item->getDescription()."' ".
               "name = '".$item->getName()."' ".
               "date = '".$item->getDate()."' ".
               "startTime = '".$item->getStartTime()."' ".
               "endTime = '".$item->getEndTime()."' ".
               "requirements = '".$item->getRequirements()."' ".
               "WHERE event_ID = '". $item-> getEventID()."';";

        $this->db->exec($sql);
        $event = $this->findOne($this->db->lastInsertId());
        
        $this->db->commit();
        return $event;
    }

    /**
     * @param string $event_ID
     * @return void
     */
    public function delete(string $event_ID): void {
        $delete = "DELETE FROM event WHERE event_ID = '" . $event_ID . "' RETURNING address_ID;";
        $this->db->exec($delete);
        $this->addressStore->delete($delete);
    }

    /**
     * @param string $event_ID
     * @return Event
     */
    public function findOne(string $event_ID): Event {
        $sql ="SELECT * FROM event WHERE event_ID = '".$event_ID."';";
        $stmt = $this->db->prepare($sql);

        $stmt->execute(array(":user_ID" => $event_ID));

        $stmt->bindColumn(1, $address_ID);
        $stmt->bindColumn(2, $user_ID);
        $stmt->bindColumn(3, $name);
        $stmt->bindColumn(4, $description);
        $stmt->bindColumn(5, $requirements);
        $stmt->bindColumn(6, $date);
        $stmt->bindColumn(7, $startTime);
        $stmt->bindColumn(8, $endTime);
        $stmt->bindColumn(10, $street_name);
        $stmt->bindColumn(11, $house_number);
        $stmt->bindColumn(12, $postal_code);
        $stmt->bindColumn(13, $city);

        $stmt->fetch(PDO::FETCH_BOUND);
        
        return Event::withAddress(array("event_ID" => $event_ID, "address_ID" => $address_ID, "user_ID" => $user_ID
        , "name" => $name, "description" => $description, "requirements" => $requirements, "date" => $date, "startTime" => $startTime
        , "endTime" => $endTime, "street_name" => $street_name, "house_number" => $house_number
        , "postal_code" => $postal_code, "city" => $city));
    }

    /**
     * @param array $ids
     * @return array
     */
    public function findMany(array $ids): array {
        foreach ($ids as $key => $id) {
            $ids[$key] = "event_ID = " . $id;
        }
        $sql = "SELECT * FROM event                        ".
               "  WHERE ". $ids.join(" OR ") ."    ".
               "  INNER JOIN address                       ".
               "  ON address.address_ID = event.address_ID;".
               "  LIMIT " .count($ids).";                  ";
        $events = $this->db->query($sql)->fetchAll();
        foreach ($events as $key => $event) {
            $events[$key] = new Event($event);
        }
        return $events;
    }

    /**
     * @param string $stmt
     * @return array
     * @throws Exception
     */
    public function findAny(string $stmt): array {
        $sql = "SELECT * FROM event                         ".
            "    INNER JOIN address                      ".
            "    ON address.address_ID = event.address_ID".
            "    WHERE name LIKE '%".$stmt."%' OR          ".
            "    description LIKE '%".$stmt."%' OR          ".
            "    requirements LIKE '%".$stmt."%' OR          ".
            "    date LIKE '%".$stmt."%' OR          ".
            "    startTime LIKE '%".$stmt."%' OR          ".
            "    endTime LIKE '%".$stmt."%'           ";
        return $this->createEventArray($sql);
    }

    public function findMy($user_ID): array {
        $sql = "SELECT * FROM event                         ".
               "    INNER JOIN address                      ".
               "    ON address.address_ID = event.address_ID".
               "    WHERE user_ID = '".$user_ID."';         ";
        return $this->createEventArray($sql);
    }

    public function findAll(): array {
        $sql = "SELECT * FROM event                          ".
               "     INNER JOIN address                      ".
               "    ON address.address_ID = event.address_ID;";
        return $this->createEventArray($sql);
    }

    /**
     * @param string $sql
     * @return array
     * @throws Exception
     */
    public function createEventArray(string $sql): array
    {
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

<?php

namespace stores\database;

use Exception;
use php\includes\items\Event;
use PDO;
use RuntimeException;
use stores\interface\EventStore;
use stores\interface\Store;

class DBEventStore implements EventStore {

    private PDO $db;
    private Store $addressStore;
    private DBBlobStore $blobObj;

    public function __construct(PDO $db, Store $addressStore, DBBlobStore $blobObj) {
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
                throw new Exception("There is already an items\Event called ".$item->getName()."!");
            }
            if($item->getStreetName() !== "" || $item->getHouseNumber() !== "" || $item->getPostalCode() !== "" || $item->getCity() !== "") {
                $address_ID = $this->addressStore->create($item);
                $item->setAddressID($address_ID);
            }

            $sql = "INSERT INTO event (".$item->getEventAttributesAsList("key", false).") VALUES (".$item->getEventAttributesAsList("value", true).");";
            $this->db->exec($sql);

            $item = $this->findOne($this->db->lastInsertId());
            $this->db->commit();
            return $item;
        } catch (Exception $ex) {
            $this->db->rollBack();
            throw new Exception($ex);
        }
    }

    /**
     * @param Event $item
     * @return Event
     */
    public function update(Event $item):Event {
        $address_ID = $this->addressStore->update($item);
        $item->setAddressID($address_ID);

        $sql = "UPDATE event SET ".$item->getEventAttributesAsSet(",")." WHERE event_ID = '". $item->getEventID()."';";

        $this->db->exec($sql);
        return $this->findOne($item->getEventID());
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void {
        $sql = "DELETE FROM event WHERE event_ID = '" . $id . "' RETURNING address_ID;";
        $stmt = $this->db->exec($sql);
        $this->addressStore->delete($stmt);
    }

    /**
     * @param string $id
     * @return Event
     */
    public function findOne(string $id): Event {
        $sql ="SELECT * FROM event WHERE event_ID = :event_ID;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(":event_ID" => $id));
        $stmt->bindColumn(2, $address_ID);
        $stmt->bindColumn(3, $user_ID);
        $stmt->bindColumn(4, $name);
        $stmt->bindColumn(5, $description);
        $stmt->bindColumn(6, $requirements);
        $stmt->bindColumn(7, $date);
        $stmt->bindColumn(8, $startTime);
        $stmt->bindColumn(9, $endTime);
        $stmt->fetch(PDO::FETCH_BOUND);

        $event = array("event_ID" => $id, "address_ID" => $address_ID, "user_ID" => $user_ID, "name" => $name
        , "description" => $description, "requirements" => $requirements, "date" => $date, "startTime" => $startTime
        , "endTime" => $endTime, "street_name" => "", "house_number" => "", "postal_code" => "", "city" => "");

        if($address_ID !== NULL) {
            $sql = "SELECT * FROM address WHERE address_ID = :address_ID;";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(":address_ID" => $address_ID));
            $stmt->bindColumn(2, $street_name);
            $stmt->bindColumn(3, $house_number);
            $stmt->bindColumn(4, $postal_code);
            $stmt->bindColumn(5, $city);
            $stmt->fetch(PDO::FETCH_BOUND);

            $event["street_name"] = $street_name;
            $event["house_number"] = $house_number;
            $event["postal_code"] = $postal_code;
            $event["city"] = $city;
        }

        return Event::withAddress($event);
    }

    /**
     * @param string $stmt
     * @return array
     * @throws Exception
     */
    public function findAny(string $stmt): array {
        $sql = "SELECT * FROM event                         ".
               "    LEFT JOIN address                      ".
               "    ON address.address_ID = event.address_ID".
               "    WHERE name LIKE '%".$stmt."%' OR          ".
               "    description LIKE '%".$stmt."%' OR          ".
               "    requirements LIKE '%".$stmt."%' OR          ".
               "    date LIKE '%".$stmt."%' OR          ".
               "    startTime LIKE '%".$stmt."%' OR          ".
               "    endTime LIKE '%".$stmt."%'           ";
        return $this->createEventArray($sql);
    }

    /**
     * @throws Exception
     */
    public function findMy(string $user_ID): array {
        $sql = "SELECT * FROM event                         ".
               "    LEFT JOIN address                      ".
               "    ON address.address_ID = event.address_ID".
               "    WHERE user_ID = '".$user_ID."';         ";
        return $this->createEventArray($sql);
    }

    /**
     * @throws Exception
     */
    public function findAll(): array {
        $sql = "SELECT * FROM event                          ".
               "    LEFT JOIN address                        ".
               "    ON address.address_ID = event.address_ID;";
        return $this->createEventArray($sql);
    }

    /**
     * @param string $sql
     * @return array
     * @throws Exception
     */
    public function createEventArray(string $sql): array {
        $stmt = $this->db->query($sql);
        $stmt = $stmt->fetchAll();

        $return = array();
        foreach ($stmt as $event) {
            $newEvent = Event::withAddress($event);

            try {
                $imageID = $this->blobObj->queryID($newEvent->getEventID(), "event");
                $image = $this->blobObj->selectBlob($imageID[0]["id"]);
                $newEvent->setBlobData($image);
                $return[] = $newEvent;
            } catch (RuntimeException $ex) {
                $return[] = $newEvent;
            }
        }
        return $return;
    }
}

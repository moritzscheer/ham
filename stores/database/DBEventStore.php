<?php

namespace stores\database;

use Exception;
use php\includes\items\Event;
use PDO;
use stores\interface\EventStore;
use stores\interface\Store;

class DBEventStore implements EventStore {

    private PDO $db;
    private Store $addressStore;
    private DBBlobStore $blobObj;

    /**
     * constructor:
     * creates event table
     * @param PDO $db
     * @param Store $addressStore
     * @param DBBlobStore $blobObj
     */
    public function __construct(PDO $db, Store $addressStore, DBBlobStore $blobObj)
    {
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

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * creates an Event entry in the database
     * @throws Exception
     * @noinspection DuplicatedCode
     */
    public function create(Event $event) : Event
    {
        try {
            $this->db->beginTransaction();

            // checking if an entry already exist with the name
            $sql = "SELECT * FROM event WHERE name = '".$event->getName()."';";
            $stmt = $this->db->query($sql)->fetch();
            if($stmt !== false) {
                throw new Exception("There is already an Event called ".$event->getName()."!");
            }

            // if any address attribute is not empty
            if($event->hasAddressInputs()) {
                $address_ID = $this->addressStore->create($event);
                $event->setAddressID($address_ID);
            }

            // inserting data
            $this->preparedInsert($event);

            // gets inserted data
            $event = $this->findOne($this->db->lastInsertId());
            $this->db->commit();
            return $event;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * updates the data from the event given in
     * @param Event $event
     * @return Event
     * @throws Exception
     */
    public function update(Event $event):Event
    {
        // updates address data
        $address_ID = $this->addressStore->update($event);
        $event->setAddressID($address_ID);

        // updating event data
        $this->preparedUpdate($event);

        // gets updated data
        return $this->findOne($event->getEventID());
    }

    /**
     * deletes the data from the event with the given id
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        // deletes event data
        $stmt = $this->db->prepare("DELETE FROM event WHERE event_ID=? RETURNING address_ID;");
        $stmt->execute([$id]);
        $stmt = $stmt->fetch();

        // deletes address data
        $this->addressStore->delete($stmt["address_ID"]);
    }

    /**
     * gets the data from the event with the given id
     * @param string $id
     * @return Event
     */
    public function findOne(string $id): Event
    {
        $sql = "SELECT * FROM event LEFT JOIN address ON event.address_ID = address.address_ID WHERE event_ID = ".$id.";";
        $stmt = $this->db->query($sql)->fetch();
        return Event::create($stmt);
    }

    /**
     * gets the data from the events with the $stmt in any attribute
     * @param string $stmt
     * @return array
     * @throws Exception
     */
    public function findAny(string $stmt): array
    {
        $sql = "SELECT * FROM event ".
               "LEFT JOIN address ".
               "ON address.address_ID = event.address_ID ".
               "WHERE name LIKE '%" . $stmt . "%' OR ".
               "description LIKE '%" . $stmt . "%' OR ".
               "requirements LIKE '%" . $stmt . "%' OR ".
               "date LIKE '%" . $stmt . "%' OR ".
               "startTime LIKE '%" . $stmt . "%' OR ".
               "endTime LIKE '%" . $stmt . "%'";
        return $this->createEventArray($sql);
    }

    /**
     * gets the data from all events
     * @throws Exception
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM event " .
               "LEFT JOIN address " .
               "ON address.address_ID = event.address_ID;";
        return $this->createEventArray($sql);
    }

    /**
     * gets the data from all events which were created by the user with the given user_ID
     * @throws Exception
     */
    public function findMy(string $user_ID): array
    {
        $sql = "SELECT * FROM event ".
               "LEFT JOIN address ".
               "ON address.address_ID = event.address_ID ".
               "WHERE user_ID = '" . $user_ID . "';";
        return $this->createEventArray($sql);
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                              private methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param string $sql
     * @return array
     * @throws Exception
     */
    private function createEventArray(string $sql): array
    {
        $stmt = $this->db->query($sql);
        $stmt = $stmt->fetchAll();

        $return = array();
        foreach ($stmt as $event) {
            $newEvent = Event::create($event);

            try {
                $imageID = $this->blobObj->queryID($newEvent->getEventID(), "event");
                $image = $this->blobObj->findOne($imageID[0]["id"]);
                $newEvent->setImage($image);
                $return[] = $newEvent;
            } catch (Exception) {
                $return[] = $newEvent;
            }
        }
        return $return;
    }

    /**
     * method to update data into the database
     * @param Event $event
     * @return void
     */
    private function preparedUpdate(Event $event) : void
    {
        $sql = 'UPDATE event SET address_ID = :address_ID, user_ID = :user_ID, name = :name, description = :description, requirements = '.
            ':requirements, date = :date, startTime = :startTime, endTime = :endTime WHERE event_ID = :event_ID';

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue('address_ID', $event->getAddressID());
        $stmt->bindValue('event_ID', $event->getEventID());
        $stmt->bindValue('user_ID', $event->getUserID());
        $stmt->bindValue('name', $event->getName());
        $stmt->bindValue('description', $event->getDescription());
        $stmt->bindValue('requirements', $event->getRequirements());
        $stmt->bindValue('date', $event->getDate());
        $stmt->bindValue('startTime', $event->getStartTime());
        $stmt->bindValue('endTime', $event->getEndTime());

        $stmt->execute();
    }

    /**
     * @param Event $event
     * @return void
     */
    private function preparedInsert(Event $event) : void
    {
        if ($event->getAddressID() === "") {
            $sql = 'INSERT INTO event (user_ID, name, description, requirements, date, startTime, endTime) '.
                'VALUES (:user_ID, :name , :description, :requirements, :date, :startTime, :endTime)';
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = 'INSERT INTO event (address_ID, user_ID, name , description, requirements, date, startTime, '.
                'endTime) VALUES (:address_ID, :user_ID, :name , :description, :requirements, :date, :startTime, '.
                ':endTime)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('address_ID', $event->getAddressID());
        }

        $stmt->bindValue('user_ID', $event->getUserID());
        $stmt->bindValue('name', $event->getName());
        $stmt->bindValue('description', $event->getDescription());
        $stmt->bindValue('requirements', $event->getRequirements());
        $stmt->bindValue('date', $event->getDate());
        $stmt->bindValue('startTime', $event->getStartTime());
        $stmt->bindValue('endTime', $event->getEndTime());

        $stmt->execute();
    }
}

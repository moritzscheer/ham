<?php

namespace stores\memory;

use Exception;
use php\includes\items\Event;
use stores\interface\EventStore;
use stores\interface\Store;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/EventStore.php';

class FileEventStore implements EventStore
{
    private string $eventFile;
    private mixed $itemsOfJsonfile;

    private Store $addressStore;
    private FileBlobStore $blobObj;

    /**
     * constructor:
     * creates user table
     * @param string $eventFile
     * @param Store $addressStore
     * @param FileBlobStore $blobObj
     */
    public function __construct(string $eventFile, Store $addressStore, FileBlobStore $blobObj)
    {
        $this->blobObj = $blobObj;
        $this->addressStore = $addressStore;
        $this->eventFile = $eventFile;
        $this->reloadItemsFromJsonFile();
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * methode to save data of an event in the file
     * @param Event $event an items\Event object
     * @return Event return true if event was successfully written
     * @throws Exception
     */
    public function create(Event $event): Event
    {
        try {
            $this->reloadItemsFromJsonFile();

            if ($event->getEventID() === null)
                $event->setEventID(rand(1, 2147483647));

            $jsonEvent = $event->getJsonEvent();

            // checking if an entry already exist with the name
            foreach ($this->itemsOfJsonfile as $item) {
                if ($item->name === $jsonEvent["name"])
                    throw new Exception("There is already an Event called ".$jsonEvent["name"]."!");
            }

            // if any address attribute is not empty
            if ($event->hasAddressInputs()) {
                $address_ID = $this->addressStore->create($event);
                $event->setAddressID($address_ID);
            }

            // inserting data
            $this->itemsOfJsonfile[] = $jsonEvent;
            $this->addItemsToJsonFile();

            // gets inserted data
            return $event;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * updates the data from the event given in the JSON-File
     * @throws Exception
     */
    public function update(Event $event): Event
    {
        try {
            $this->reloadItemsFromJsonFile();

            $jsonEvent = $event->getJsonEvent();

            // updates address data
            $address_ID = $this->addressStore->update($event);
            $event->setAddressID($address_ID);

            // updating event data
            foreach ($this->itemsOfJsonfile as $item) {
                if ($item->event_ID === $jsonEvent["event_ID"])
                unset($item);

                // inserting data
                $this->itemsOfJsonfile[] = $jsonEvent;
                $this->addItemsToJsonFile();

                break;
            }

            // gets updated data
            return $event;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * deletes the data from the event with the given id
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function delete(string $id) : void
    {
        $this->reloadItemsFromJsonFile();

        // deletes event data
        foreach ($this->itemsOfJsonfile as $item) {
            if ($id === $item->id) {
                unset($this->itemsOfJsonfile[$item]);
                $this->addItemsToJsonFile();
                break;
            }
        }

        // deletes address data
        $this->addressStore->delete($id);
    }

    /**
     * @param $user_ID
     * @return Event|null
     */
    public function findOne($user_ID): ?Event
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonfile as $item) {
            if ($item->user_ID === $user_ID) {
                $address = $this->addressStore->findOne($item->address_ID);
                return Event::stdClassToEvent($item, $address);

            }
        }
        return null;
    }

    /**
     * @param $count
     * @param $address_ID
     * @return int|mixed
     */
    public function getOne($count, $address_ID): mixed
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonfile as $item) {
            if ($item->address_ID === $address_ID) $count++;
        }
        return $count;
    }

    /**
     * gets the data from the events with the $stmt in any attribute
     * @param string $stmt
     * @return array
     */
    public function findAny(string $stmt): array
    {
        $this->reloadItemsFromJsonFile();

        $events = array();
        foreach ($this->itemsOfJsonfile as $item) {
            foreach ($item as $attribute) {
                if ($attribute === $stmt) {
                    $events[] = $this->createEvent($item);
                    break;
                }
            }
        }
        return $events;
    }

    /**
     * gets the data from all events
     * @return array
     */
    public function findAll(): array
    {
        $this->reloadItemsFromJsonFile();

        $events = array();
        foreach ($this->itemsOfJsonfile as $item) {
            $events[] = $this->createEvent($item);
        }
        return $events;
    }

    /**
     * gets the data from all events which were created by the user with the given user_ID
     * @param $user_ID
     * @return array
     */
    public function findMy($user_ID): array
    {
        $this->reloadItemsFromJsonFile();

        $events = array();
        foreach ($this->itemsOfJsonfile as $item) {
            foreach ($item as $attribute) {
                if ($attribute === "user_ID" && $attribute === $user_ID) {
                    $events[] = $this->createEvent($item);
                    break;
                }
            }
        }
        return $events;
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                              private methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param mixed $event
     * @return Event
     */
    private function createEvent(mixed $event): Event
    {
        $address = $this->addressStore->findOne($event->address_ID);
        $event = Event::stdClassToEvent($event, $address);

        $imageID = $this->blobObj->queryID($event->getUserID(), "event");
        if ($imageID !== null) {
            $image = $this->blobObj->findOne($imageID);
            $event->setImage($image);
        }
        return $event;
    }

    /**
     * Loads content of jsonfile into a variable
     * @return void
     */
    private function reloadItemsFromJsonFile(): void
    {
        $content = file_get_contents($this->eventFile, true);
        $this->itemsOfJsonfile = json_decode($content, false);
    }

    /**
     * Adds an items\Event to json file
     * @return void
     * @throws Exception
     */
    private function addItemsToJsonFile(): void
    {
        $var = file_put_contents($this->eventFile, json_encode($this->itemsOfJsonfile), LOCK_EX);
        if ($var === false) throw new Exception("Error: Could not send data to remote server.");
    }
}
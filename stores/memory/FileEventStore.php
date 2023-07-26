<?php

namespace stores\memory;

use Exception;
use php\includes\items\Event;
use stores\interface\EventStore;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/EventStore.php';

class FileEventStore implements EventStore
{
    private string $eventFile;
    private mixed $itemsOfJsonfile;

    public function __construct($eventFile)
    {
        $this->eventFile = $eventFile;
        $this->reloadItemsFromJsonFile();
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
     * @return bool
     */
    private function addItemsToJsonFile(): bool
    {
        $var = file_put_contents($this->eventFile, json_encode($this->itemsOfJsonfile));
        if ($var !== false) {
            return true;
        } else return false;
    }


    /**
     * Loads all Events from json file
     * @return Event[]
     */
    public function findAll(): array
    {
        $events = array();
        foreach ($this->itemsOfJsonfile as $item) {
            $event = Event::getJsonEvent($item);
            $events[] = $event;
        }
        return $events;
    }

    /**
     * Stores an items\Event to the event json file
     * @param Event $event an items\Event object
     * @return Event return true if event was successfully written
     */
    public function create(Event $event): Event
    {
        $jsonEvent = Event::toArrayForJsonEntry($event);
        $this->itemsOfJsonfile[] = $jsonEvent;
        $var = $this->addItemsToJsonFile();
        if ($var) {
            $this->reloadItemsFromJsonFile();
            return $event;
        } else return new Event();
    }

    /**
     * @throws Exception
     */
    public function update(Event $event): Event
    {
        // maybe other solution ?
        $this->delete($event->getEventID());
        return $this->create($event);
    }

    public function findOne(string $id): Event
    {
        foreach ($this->itemsOfJsonfile as $item) {
            if ($item->id == $id) {
                return Event::getJsonEvent($item);
            }
        }
        return new Event(); // object or exception ?
    }

    /**
     * Deletes items\Event form json file by given id
     *
     * Deletes an entry in the array and overwrites the json file
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function delete(string $id) : void
    {
        foreach ($this->itemsOfJsonfile as $item) {
            if ($id == $item->id) {
                unset($this->itemsOfJsonfile[$item]);
                $this->addItemsToJsonFile();
                return;
            }
        }
        throw new Exception("No such items\Event was found.");
    }

    public function findMy($user_ID): array
    {
        return array();
        // TODO: Implement findMy() method.
    }

    public function findAny(string $stmt): array
    {
        return array();
        // TODO: Implement findAny() method.
    }

    public function createEventArray(string $sql): array
    {
        return array();
        // TODO: Implement createEventArray() method.
    }
}
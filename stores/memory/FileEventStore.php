<?php

use Item\Event;

include_once "../stores/interface/EventStore.php";

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
    private function reloadItemsFromJsonFile()
    {
        $content = file_get_contents($this->eventFile, true);
        $this->itemsOfJsonfile = json_decode($content, false);
    }


    /**
     * Adds an Item\Event to json file
     * @param array $item
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
     * Stores an Item\Event to the event json file
     * @param Event $item an Item\Event object
     * @return bool return true if event was successfully written
     * @throws Exception will be thrown if item is not an event object
     */
    public function create(Event $item): Event
    {
        $jsonEvent = Event::toArrayForJsonEntry($item);
        $this->itemsOfJsonfile[] = $jsonEvent;
        $var = $this->addItemsToJsonFile();
        if ($var) {
            $this->reloadItemsFromJsonFile();
            return $item;
        } else return new Event();
    }

    public function update(Event $item): Event
    {
        // maybe other solution ?
        $this->delete($item->getEventID());
        return $this->create($item);
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
     * Deletes Item\Event form json file by given id
     *
     * Deletes an entry in the array and overwrites the json file
     * @param string $id
     * @return void
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
        throw new Exception("No such Item\Event was found.");
    }

    public function findMany(array $ids)
    {
        $events = array();
        foreach($ids as $id){
            $event = $this->findOne($id);
            if ($event->getEventID() == "") continue;
            $events[] = $event;
        }
        return $events;
    }


}
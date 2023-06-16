<?php
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
     * Adds an Event to json file
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
     * Stores an Event to the event json file
     * @param Item $item an Event object
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
     * Deletes Event form json file by given id
     *
     * Loads all the content form the json file into a variable,
     * deletes an entry in the array and overwrites the json file
     * @param string $id
     * @return void
     */
    public function delete(string $id)
    {
        $i = 0;
        foreach ($this->itemsOfJsonfile as $item) {
            if ($id == $item->id) {
                unset($this->itemsOfJsonfile[$i]);
            }
            $i++;
        }
        $this->addItemsToJsonFile();
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
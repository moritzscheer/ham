<?php
include_once "../stores/interface/ItemStore.php";

class FileEventsStore implements ItemStore
{
    private string $eventFile;

    public function __construct($eventFile)
    {
        $this->eventFile = file_get_contents($eventFile, true);
    }

    /**
     * Loads all Events from json file
     * @return Event[]
     */
    public function loadAll(): array
    {
        $items = json_decode($this->eventFile, false);
        $events = array();
        foreach ($items as $item) {
            $event = new Event($item);
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
    public function store(Item $item) : bool
    {
        if (!($item instanceof Event)){
            throw new Exception("FileEventsStore:store(item): Item is not an Event ");
        }
        $var = file_put_contents($this->eventFile, json_encode($item->toJsonArray()));
        if ($var !== false) {
            return true;
        } else return false;
    }
}
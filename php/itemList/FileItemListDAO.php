<?php
include_once 'classes.php';
class FileItemListDAO implements ItemListDAO
{

    private string $bandFile;
    private string $eventFile;

    public function __construct($bandFile, $eventFile)
    {
        $this->bandFile = file_get_contents($bandFile, true);
        $this->eventFile = file_get_contents($eventFile, true);
    }

    /**
     * Converts a json-file into an array of items (bands or events)
     * @param $type : bands or events
     * @return array|Band[]|Event[]|Item[] array of the specific items
     */
    public function loadItems($type): array
    {
        switch ($type) {
            case "bands":

                     $items = json_decode($this->bandFile, false);
                                    return $this->loadBands($items);
            case "events":

                    $items = json_decode($this->eventFile, false);
                    return $this->loadEvents($items);
            default:
            {
                return array();
            }
        }
    }

    /**
     * @param $items decoded json array of bands
     * @return Band[] returns an array of Banditem objects
     */
    private function loadBands($items): array
    {
        $bands = array();
        foreach ($items as $item) {
            $band = new Band($item);
            $bands[] = $band; // adds band to bands array
        }
        return $bands;
    }

    /**
     * @param $items array of event items
     * @return Event[] an array of Eventitem objects
     */
    private function loadEvents($items): array
    {
        $events = array();
        foreach ($items as $item) {
            $event = new Event($item);
            $events[] = $event;
        }
        return $events;
    }

    /**
     * Stores a Band or a new event to the json-file
     * @param Item $item
     * @return bool
     */
    public function storeItem(Item $item): bool
    {
        if ($item instanceof Band) {
            // todo: implement ...
            return true;
        } elseif ($item instanceof Event) {
            return $this->storeEvent($item);  // type conversion ?
        } else return false;
    }


    /**
     * Writes an Eventitem object to json-file
     * @param Event $event
     * @return bool
     */
    private function storeEvent(Event $event): bool
    {
        $var = file_put_contents("../resources/json/Events.json", json_encode($event->toJsonArray()));
        if ($var !== false) {
            return true;
        } else return false;
    }
}
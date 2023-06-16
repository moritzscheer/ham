<?php
include_once "../stores/interface/EventStore.php";

class FileEventStore implements EventStore
{
    private string $eventFile;

    public function __construct($eventFile)
    {
        $this->eventFile = file_get_contents($eventFile, true);
    }

    private function getJsonItems(): mixed
    {
        return json_decode($this->eventFile, false);
    }


    private function addItemToJsonFile(array $item): bool
    {
        $var = file_put_contents($this->eventFile, json_encode($item));
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
        //todo: fix this
        $items = $this->getJsonItems();
        $events = array();
        foreach ($items as $item) {
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
        $jsonEvent = array(
            "image" => $item->getImageSource(),
            "id" => $item->getID(),
            "authorID" => $item->getAuthorID(),
            "type" => "event",
            "description" => $item->getDescription(),
            "name" => $item->getName(),
            "address_ID" => $item->getAddressID(),
            "street" => $item->getStreetName(),
            "houseNr" => $item->getHouseNumber(),
            "postalCode" => $item->getPostalCode(),
            "city" => $item->getCity(),
            "Date" => $item->getDate(),
            "startTime" => $item->getStartTime(),
            "endTime" => $item->getEndTime(),
            "requirements" => $item->getRequirements()
        );

        $var = $this->addItemToJsonFile($jsonEvent);
        if ($var) {
            return $item;
        } else return new Event();
    }

    public function update(Event $item): Event
    {
        // TODO: Implement update() method.
        return new Event();
    }

    public function findOne(string $id): Event
    {
        // TODO: Implement findOne() method.
        $items = $this->getJsonItems();

        return new Event();
    }

    /**
     * Deletes Event form json file by given id
     * @param string $id
     * @return void
     */
    public function delete(string $id)
    {
        $i = 0;
        $items = $this->getJsonItems();
        foreach ($items as $item) {
            if ($id == $item->id) {
                unset($items[$i]);
            }
            $i++;
        }
        $toJsonString = json_encode($items, JSON_PRETTY_PRINT);
        $openFile = fopen($this->eventFile, 'w');
        fwrite($openFile, $toJsonString);
        fclose($openFile);
    }

    public function findMany(array $ids) : Event
    {
        // TODO: Implement findMany() method.
        return new Event();
    }


}
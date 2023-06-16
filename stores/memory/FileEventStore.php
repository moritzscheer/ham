<?php
include_once "../stores/interface/EventStore.php";

class FileEventStore implements EventStore
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
    public function findAll(): array
    {
        $items = json_decode($this->eventFile, false);
        $events = array();
        foreach ($items as $item) {
            $event = new Event();
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

        $var = file_put_contents($this->eventFile, json_encode($jsonEvent));
        if ($var !== false) {
            return $item;
        } else return new Event();
    }

    public function update(Event $item): Event
    {
        // TODO: Implement update() method.
    }

    public function findOne(string $id): Event
    {
        // TODO: Implement findOne() method.
    }

    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }

    public function findMany(array $ids)
    {
        // TODO: Implement findMany() method.
    }
}
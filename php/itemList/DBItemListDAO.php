<?php

class DBItemListDAO implements ItemListDAO
{
    public function __construct($dbFile)
    {
        //todo: implement constructor method ?
    }

    public function loadItems($type): array
    {
        switch ($type){
            case "bands":
                return $this->loadBands();

            case "events":
                return $this->loadEvents();

            default:
                return array();
        }
    }

    /**
     * @return BandItem[] returns an array of bands
     */
    private function loadBands(): array {
        // TODO: Implement this method.
        return array();
    }

    /**
     * @return EventItem[] returns an array of events
     */
    private function loadEvents(): array {
        // TODO: Implement this method.
        return array();
    }

    public function storeItem(Item $item): bool
    {
        // TODO: Implement storeItem() method.
        return true;
    }


}
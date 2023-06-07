<?php

class FileBandsStore implements ItemStore {

    private string $bandfile;
    
    public function __construct($bandFile)
    {
        $this->bandFile = file_get_contents($bandFile, true);
    }

    /**
     * Loads all Bands from json file
     * @return Band[] array of bands
     */
    public function loadAll(): array
    {
        $bands = json_decode($this->bandFile, false);
        $bandItems = array();
        foreach ($bands as $band){
            $item = new Band($band);
            $bands[] = $item;
        }
        return $bands;
    }

    /**
     * @param Item $item is a Band object
     * @return bool return true if band was written to json file
     * @throws Exception will be thrown if item is not a Band object
     */
    public function store(Item $item) : bool
    {
        if (!($item instanceof Band)){
            throw new Exception("FileBandsStore:store(item): Item is not a Band object");
        }
        $var = file_put_contents($this->bandfile, json_encode($item->toJsonArray()));
        if ($var !== false) {
            return true;
        } else return false;
    }
}
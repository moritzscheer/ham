<?php


global $db;

class DBBandStore
{

    private PDO $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }


    public function create(object $item): void
    {
        //  create address
        $create = "INSERT INTO address (street_name, house_number, postal_code, city)
                    VALUES (" . $item->getStreet() .
            "," . $item->getHouseNr() .
            "," . $item->getPostalCode() .
            "," . $item->getCity() .
            ")";

        $addressId = $this->db->exec($create);

        $create = "INSERT INTO event (image ,description,name,address_ID,date,startTime ,endTime, requirements)
                    VALUES (" . $item-> .
            "," . $item->getHouseNr() .
            "," . $item->getPostalCode() .
            "," . $item->getCity() .
            ");";
    }

    public function update(BandDOA $item)
    {
        //  edit address
        $create = "INSERT INTO address (street_name, house_number, postal_code, city)
                    VALUES (" . $item->getStreet() .
            "," . $item->getHouseNr() .
            "," . $item->getPostalCode() .
            "," . $item->getCity() .
            ")";

        $this->db->exec($create);

    }

    public function delete(string $id)
    {

    }

    public function findOne(string $id): EventItem
    {

    }

    public function findMany(string $id)
    {

    }

    public function findAll(string $id)
    {

    }


}
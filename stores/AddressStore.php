<?php

global $db;

class AddressStore
{

    private PDO $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }


    public function create(Address $item): Address
    {
        //  create address
        $create = "INSERT INTO address (street_name, house_number, postal_code, city)
                    VALUES (" . $item->getStreet() .
            "," . $item->getHouseNr() .
            "," . $item->getPostalCode() .
            "," . $item->getCity() .
            ")";

        $addressId = $this->db->exec($create);

        return $this->findOne($addressId);
    }

    public function update(Address $item): Address
    {
        //  edit address
        $update = "UPDATE ADDRESS 
            SET street_name = ".$item->getStreet() . ",
            house_number = ".$item->getHouseNr() . ",
            postal_code = ".$item->getPostalCode() . ",
            city = ".$item->getCity() . "
            WHERE address_ID = ". $item-> getId().";";

        $this->db->exec($update);
        return  $this->findOne($item-> getId());
    }

    public function delete(string $id): void
    {
        $delete = "DELETE FROM event WHERE event_ID = " . $id;
        $this->db->exec($delete);
    }

    public function findOne(string $id): Address
    {
        $findOne ="SELECT * FROM event 
                     WHERE event_ID = " . $id."
                    LIMIT 1";
        return $this->db->exec($findOne);
    }

    public function findMany(array $ids): array
    {
        foreach ($ids as $id) {
            $id = "event_ID = " . $id;
        }
        $findMany ="SELECT * FROM event 
                     WHERE ". $ids.join(" OR ") ." LIMIT " .count($ids);
        return $this->db->exec($findMany);

    }

    public function findAll(): array
    {
        $findAll = "SELECT * FROM event ";
        return $this->db->exec($findAll);
    }


}

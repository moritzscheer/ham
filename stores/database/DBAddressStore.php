<?php
include_once "../stores/interface/AddressStore.php";
include_once "../php/Item/Address.php";

class DBAddressStore implements AddressStore
{

    private PDO $db;


    public function __construct($db)
    {
        $this->db = $db;

        $sql = "CREATE TABLE IF NOT EXISTS address (
            address_ID INTEGER PRIMARY KEY AUTOINCREMENT,
            street_name varchar(30) DEFAULT NULL,
            house_number int(5) DEFAULT NULL UNIQUE,
            postal_code int(5) DEFAULT NULL,
            city varchar(20) DEFAULT NULL
            );";
        $this->db->exec($sql);

    }


    public function create(object $address): Address
    {
        //  create address
        $create = "INSERT INTO address (street_name, house_number, postal_code, city) VALUES ('".$address->getStreetName()."', '".$address->getHouseNumber()."', '".$address->getPostalCode()."', '".$address->getCity()."')";
        $this->db->exec($create);
        return $this->findOne($this->db->lastInsertId());
    }


    public function update(object $item): Address
    {
        //  edit address
        $update = "UPDATE address SET 
            street_name = ".$item->getStreetName() . ",
            house_number = ".$item->getHouseNumber() . ",
            postal_code = ".$item->getPostalCode() . ",
            city = ".$item->getCity() . "
            WHERE address_ID = ". $item-> getId().";";

        $this->db->exec($update);
        return $this->findOne($item-> getId());
    }

    public function delete(string $id): void
    {
        $delete = "DELETE FROM address WHERE address_ID = " . $id;
        $this->db->exec($delete);
    }

    public function findOne(string $address_ID): Address
    {
        $findOne ="SELECT * FROM address 
                     WHERE address_ID = ".$address_ID."
                    LIMIT 1";
        return Address::withAddressID($this->db->query($findOne)->fetch());
    }

    public function findMany(array $ids): array
    {
        foreach ($ids as $key => $id) {
            $ids[$key] = "address_ID = " . $id;
        }
        $findMany ="SELECT * FROM address 
                     WHERE ". $ids.join(" OR ") ." LIMIT " .count($ids);
        $addresses = $this->db->query($findMany)->fetchAll();
        foreach ($addresses as $key => $address) {
            $addresses[$key] = Address::withAddressID($address);
        }
        return $addresses;
    }

    public function findAll(): array
    {
        $findAll = "SELECT * FROM address ";
        $addresses =  $this->db->query($findAll)->fetchAll();
        foreach ($addresses as $key => $address) {
            $addresses[$key] = Address::withAddressID($address);
        }
        return $addresses;
    }


}

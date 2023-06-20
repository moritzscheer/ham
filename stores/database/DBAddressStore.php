<?php
include_once "../stores/interface/AddressStore.php";
include_once "../php/Item/Address.php";

class DBAddressStore implements AddressStore {

    private PDO $db;

    /**
     * @param $db
     */
    public function __construct($db) {
        $this->db = $db;

        // creates the address table
        $sql = "CREATE TABLE IF NOT EXISTS address ( ".
               "address_ID INTEGER PRIMARY KEY AUTOINCREMENT, ".
               "street_name varchar(30) DEFAULT NULL, ".
               "house_number int(5) DEFAULT NULL, ".
               "postal_code int(5) DEFAULT NULL, ".
               "city varchar(20) DEFAULT NULL, ".
               "UNIQUE(street_name, house_number, postal_code, city));";
        $this->db->exec($sql);
    }

    /**
     * @param object $item
     * @return Address
     */
    public function create(object $item): Address {
        // checking if an entry already exist
        $sql = "SELECT address_ID FROM address WHERE ".
               "street_name = '".$item->getStreetName()."' OR ".
               "house_number = '".$item->getHouseNumber()."' OR ".
               "postal_code = '".$item->getPostalCode()."' OR ".
               "city = '".$item->getCity()."';";
        $stmt = $this->db->query($sql)->fetch();
        if ($stmt !== false) {
            return $this->findOne($stmt[0]);
        }
        // inserting an entry
        $sql = "INSERT INTO address (street_name, house_number, postal_code, city) VALUES (".
                $item->getStreetName() ."', ".
                $item->getHouseNumber()."', ".
                $item->getPostalCode() ."', ".
                $item->getCity()       ."');";

        $this->db->exec($sql);
        return $this->findOne($this->db->lastInsertId());
    }

    /**
     * @param object $item
     * @return Address
     */
    public function update(object $item): Address {
        //  edit address
        $sql = "UPDATE address SET ".
            "street_name = ".$item->getStreetName().", ".
            "house_number = ".$item->getHouseNumber().", ".
            "postal_code = ".$item->getPostalCode().", ".
            "city = ".$item->getCity().", ".
            "WHERE address_ID = ". $item-> getId().";";

        $this->db->exec($sql);
        return $this->findOne($item-> getId());
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void {
        $sql = "DELETE FROM address WHERE address_ID = " . $id;
        $this->db->exec($sql);
    }

    /**
     * @param string $address_ID
     * @return Address
     */
    public function findOne(string $address_ID): Address {
        $sql = "SELECT * FROM address WHERE ".
            "address_ID = '".$address_ID."';";
        return Address::withAddressID($this->db->query($sql)->fetch());
    }

    /**
     * @param array $ids
     * @return array
     */
    public function findMany(array $ids): array {
        foreach ($ids as $key => $id) {
            $ids[$key] = "address_ID = " . $id;
        }
        $sql ="SELECT * FROM address WHERE ".
            $ids.join(" OR ") ." LIMIT " .count($ids);
        $addresses = $this->db->query($sql)->fetchAll();
        foreach ($addresses as $key => $address) {
            $addresses[$key] = Address::withAddressID($address);
        }
        return $addresses;
    }

    public function findAll(): array {
        $findAll = "SELECT * FROM address";
        $addresses =  $this->db->query($findAll)->fetchAll();
        foreach ($addresses as $key => $address) {
            $addresses[$key] = Address::withAddressID($address);
        }
        return $addresses;
    }


}

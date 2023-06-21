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
               "street_name varchar(100) DEFAULT NULL, ".
               "house_number int(10) DEFAULT NULL, ".
               "postal_code int(5) DEFAULT NULL, ".
               "city varchar(20) DEFAULT NULL, ".
               "UNIQUE(street_name, house_number, postal_code, city));";
        $this->db->exec($sql);
    }

    /**
     * @param object $item
     * @return string
     */
    public function create(object $item): string {
        // checking if an entry already exist
        $sql = "SELECT address_ID FROM address WHERE ".
               "street_name = '".$item->getStreetName()."' AND ".
               "house_number = '".$item->getHouseNumber()."' AND ".
               "postal_code = '".$item->getPostalCode()."' AND ".
               "city = '".$item->getCity()."';";
        $stmt = $this->db->query($sql)->fetch();

        if ($stmt !== false) { // if an entry exist
            return $stmt["address_ID"];
        }

        // inserting an entry
        $sql = "INSERT INTO address (".$item->getAddressAttributes("key", "list").") VALUES (".$item->getAddressAttributes("valueWithApo", "list").");";
        $this->db->exec($sql);
        return $this->db->lastInsertId();
    }

    /**
     * @param object $item
     * @return string
     */
    public function update(object $item): string {
        if($item->getAddressID() === NULL) {
            $sql = "INSERT INTO address (".$item->getAddressAttributes("key", "list").") VALUES (".$item->getAddressAttributes("valueWithApo", "list").");";
        } else {
            // checking if address_ID is saved in any entry
            $sql = "SELECT COUNT(*) FROM (".
                   "SELECT event_ID FROM event WHERE event.address_ID = '".$item->getAddressID()."' UNION ".
                   "SELECT user_ID FROM user WHERE user.address_ID = '".$item->getAddressID()."');";
            $stmt = $this->db->query($sql)->fetch();
            if ($stmt["COUNT(*)"] > 1) {  // if address_ID is used somewhere else
                $sql = "INSERT INTO address (".$item->getAddressAttributes("key", "list").") VALUES (".$item->getAddressAttributes("valueWithApo", "list").");";
            } else {  // else edit address
                $sql = "UPDATE address SET ".$item->getAddressAttributes("key", "set")." WHERE address_ID = ". $item->getAddressID().";";
                $this->db->exec($sql);
                return $item->getAddressID();
            }
        }
        $this->db->exec($sql);
        return $this->db->lastInsertId();
    }

    /**
     * @param string $address_ID
     * @return void
     */
    public function delete(string $address_ID): void {
        $sql = "DELETE FROM address WHERE address_ID = " . $address_ID;
        $this->db->exec($sql);
    }

    /**
     * @param string $address_ID
     * @return array
     */
    public function findOne(string $address_ID): array {
        $sql = "SELECT * FROM address WHERE address_ID = :address_ID;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(":address_ID" => $address_ID));
        $stmt->bindColumn(2, $street_name);
        $stmt->bindColumn(3, $house_number);
        $stmt->bindColumn(4, $postal_code);
        $stmt->bindColumn(5, $city);
        $stmt->fetch(PDO::FETCH_BOUND);
        return array("address_ID" => $address_ID
        , "street_name" => $street_name, "house_number" => $house_number
        , "postal_code" => $postal_code, "city" => $city);
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

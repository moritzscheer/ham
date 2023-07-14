<?php

use Item\Address;
use Item\User;
use Item\Event;

include_once "../stores/interface/AddressStore.php";
include_once "../php/includes/items/Address.php";

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
        $sql = "SELECT address_ID FROM address WHERE " . $item->getAddressAttributesAsSet("AND") . ";";
        $stmt = $this->db->query($sql)->fetch();

        if ($stmt !== false) { // if an entry exist
            return $stmt["address_ID"];
        }

        // inserting an entry
        $sql = "INSERT INTO address (".$item->getAddressAttributesAsList("key", false).") VALUES (".$item->getAddressAttributesAsList("value", true).");";
        $this->db->exec($sql);
        return $this->db->lastInsertId();
    }

    /**
     * @param object $item
     * @return string
     * @throws Exception
     */
    public function update(object $item): string {
        try {
            // selects all addresses with the same data
            $sql = "SELECT address_ID FROM address WHERE " . $item->getAddressAttributesAsSet("AND") . ";";
            $stmt1 = $this->db->query($sql)->fetch();
            $DataInDB = $stmt1 !== false;

            // checking if address_ID is saved in any entry
            $sql = "SELECT COUNT(*) FROM (".
                "SELECT event_ID FROM event WHERE event.address_ID = '".$item->getAddressID()."' UNION ".
                "SELECT user_ID FROM user WHERE user.address_ID = '".$item->getAddressID()."');";
            $stmt2 = $this->db->query($sql)->fetch();
            $IDUsedAnywhereElse = $stmt2["COUNT(*)"] > 1;

            if($item->getAddressID() === "") {  // if item had no address_ID
                if ($item->getStreetName() === "" && $item->getHouseNumber() === "" && $item->getPostalCode() === "" && $item->getCity() === "") {
                    // if no address was typed In
                    return "";
                } elseif ($DataInDB) {
                    return $stmt1["address_ID"];
                } else {
                    return $this->create($item);
                }
            } else {  // if item had an address_ID
                if ($item->getStreetName() === "" && $item->getHouseNumber() === "" && $item->getPostalCode() === "" && $item->getCity() === "") {
                    // if no address was typed In
                    if(!$IDUsedAnywhereElse) {
                        $this->delete($item->getAddressID());
                    }
                    return "";
                } elseif ($DataInDB) {
                    return $item->getAddressID();
                } else {
                    $sql = "UPDATE address SET ".$item->getAddressAttributesAsSet(",")." WHERE address_ID = ". $item->getAddressID().";";
                    $this->db->exec($sql);
                    return $item->getAddressID();
                }
            }
        } catch (SQLiteException $e) {
            return $item->getAddressID();
        }
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

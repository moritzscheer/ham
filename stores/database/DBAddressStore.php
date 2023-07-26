<?php

namespace stores\database;

use Exception;
use PDO;
use stores\interface\AddressStore;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/AddressStore.php';

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
     * @return string|bool
     */
    public function create(object $item): string|false
    {
        // inserting an entry
        $insert = $this->preparedInsert($item);

        if ($insert === false) {
            return $this->findOne($item);
        } else {
            return $insert;
        }
    }

    /**
     * @param object $item
     * @return string
     * @throws Exception
     */
    public function update(object $item): string {
        try {
            // flag for entries that already exist in database. if none exist false is saved, else address_ID.
            $DataInDB = $this->findOne($item);

            // checking if address_ID is saved in any entry. if other entries use this address_ID true is saved, else false.
            $sql = "SELECT COUNT(*) FROM (".
                "SELECT event_ID FROM event WHERE event.address_ID = '".$item->getAddressID()."' UNION ".
                "SELECT user_ID FROM user WHERE user.address_ID = '".$item->getAddressID()."');";
            $stmt2 = $this->db->query($sql)->fetch();
            $IDInUse = $stmt2["COUNT(*)"] > 1;

            if ($item->getAddressID() === "") {
                // if item had no address_ID

                if (!$item->hasAddressInputs()) {
                    // if no address was typed in
                    return "";

                } elseif ($DataInDB === false) {
                    return $this->create($item);

                } else {
                    return $DataInDB;
                }

            } else {
                // if item had an address_ID
                if (!$item->hasAddressInputs()) {
                    // if address was deleted
                    if ($IDInUse === false) {
                        $this->delete($item->getAddressID());
                    }
                    return "";

                } elseif ($DataInDB === false) {
                    $this->preparedUpdate($item);

                    return $item->getAddressID();

                } else {
                    return $DataInDB;

                }
            }
        } catch (Exception) {
            return $item->getAddressID();
        }
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
     * @param object $item
     * @return string|false
     */
    public function findOne(object $item): mixed {
        $sql = 'SELECT address_ID FROM address WHERE '.
               'street_name = :street_name AND house_number = :house_number AND '.
               'postal_code = :postal_code AND city = :city';

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue('street_name', $item->getStreetName());
        $stmt->bindValue('house_number', $item->getHouseNumber());
        $stmt->bindValue('postal_code', $item->getPostalCode());
        $stmt->bindValue('city', $item->getCity());

        $stmt->execute();

        /* Bind result by address_ID */
        $stmt->bindColumn("address_ID", $address_ID);

        if ($stmt->fetch( PDO::FETCH_BOUND)) {
            return $address_ID;
        } else {
            return false;
        }
    }

    /**
     * method to update data into the database
     * @param object $item
     * @return void
     */
    private function preparedUpdate(object $item) : void
    {
        $sql = 'UPDATE address SET street_name = :street_name, house_number = :house_number, '.
               'postal_code = :postal_code, city = :city WHERE address_ID = :address_ID';

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue('addressID', $item->getAddressID());
        $stmt->bindValue('street_name', $item->getStreetName());
        $stmt->bindValue('house_number', $item->getHouseNumber());
        $stmt->bindValue('postal_code', $item->getPostalCode());
        $stmt->bindValue('city', $item->getCity());

        $stmt->execute();
    }

    /**
     * method to insert data into the database
     * @param object $item
     * @return string|false
     */
    private function preparedInsert(object $item) : string|false
    {
        try {
            $sql = 'INSERT INTO address (street_name, house_number, postal_code, city) '.
                'VALUES (:street_name, :house_number, :postal_code, :city)';

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue('street_name', $item->getStreetName());
            $stmt->bindValue('house_number', $item->getHouseNumber());
            $stmt->bindValue('postal_code', $item->getPostalCode());
            $stmt->bindValue('city', $item->getCity());

            if ($stmt->execute() === false) {
                return false;
            } else {
                return $this->db->lastInsertId();
            }
        } catch (Exception) {
            return false;
        }
    }

}

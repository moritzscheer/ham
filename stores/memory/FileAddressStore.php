<?php

namespace stores\memory;

use Exception;
use stores\interface\Store;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/UserStore.php';

class FileAddressStore implements Store
{
    private string $addressFile;
    private mixed $itemsOfJsonFile;

    /**
     * constructor:
     * creates user table
     * @param $addressFile
     */
    public function __construct($addressFile)
    {
        $this->addressFile = $addressFile;
        $this->reloadItemsFromJsonFile();
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */


    /**
     * methode to save data of an address in the file
     * @param object $item
     * @return string
     * @throws Exception
     */
    public function create(object $item): string
    {
        try {
            $this->reloadItemsFromJsonFile();

            $item->setAddressID(rand(1, 2147483647));
            $jsonAddress = $item->getJsonAddress();

            // if an entry already exist return address_ID
            $foundOne = $this->alreadyExist($item);
            if ($foundOne !== false) return $foundOne;

            // inserting data
            $this->itemsOfJsonFile[] = $jsonAddress;
            $this->addItemsToJsonFile();

            // gets inserted data
            return $item->getAddressID();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param object $item
     * @return string
     */
    public function update(object $item): string
    {
        global $eventStore, $userStore;

        try {
            $this->reloadItemsFromJsonFile();

            $jsonAddress = $item->getJsonAddress();

            // if an entry already exist return address_ID
            $DataInDB = $this->alreadyExist($item);

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
                // if item has no address. check if address_ID is saved in any entry.
                $count = 0;
                $count = $userStore->findOne($item->getAddressID(), $count);
                $count = $eventStore->findOne($item->getAddressID(), $count);
                $IDInUse = $count > 1;

                if (!$item->hasAddressInputs()) {
                    // if address was deleted
                    if ($IDInUse === false) {
                        $this->delete($item->getAddressID());
                    }
                    return "";

                } elseif ($DataInDB === false) {
                    // updating address data
                    foreach ($this->itemsOfJsonFile as $address) {
                        if ($address->address_ID === $item->getAddressID())
                            unset($item);

                        // inserting data
                        $this->itemsOfJsonFile[] = $jsonAddress;
                        $this->addItemsToJsonFile();

                        break;
                    }
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
     * methode to delete an address
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function delete(string $id): void
    {
        $this->reloadItemsFromJsonFile();

        // deletes address data
        foreach ($this->itemsOfJsonFile as $address) {
            if ($address->address_ID === $id) {
                unset($this->itemsOfJsonFile[$address]);
                $this->addItemsToJsonFile();
                break;
            }
        }
    }

    /**
     * @param string $address_ID
     * @return false
     */
    public function findOne(string $address_ID)
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonFile as $address) {
            if ($address->address_ID === $address_ID) {
                return $address;
            }
        }
        return null;
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                              private methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param object $item
     * @return mixed
     */
    private function alreadyExist(object $item): mixed
    {
        foreach ($this->itemsOfJsonFile as $address) {
            if ($address->street_name === $item->getStreetName() ||
                $address->house_number === $item->getHouseNumber() ||
                $address->postal_code === $item->getPostalCode() ||
                $address->city === $item->getCity() ) {
                return $address->address_ID;
            }
        }
        return false;
    }

    /**
     * Loads content of jsonfile into a variable
     * @return void
     */
    private function reloadItemsFromJsonFile(): void
    {
        $content = file_get_contents($this->addressFile, true);
        $this->itemsOfJsonFile = json_decode($content, false);
    }

    /**
     * Adds an items\User to json file
     * @return void
     * @throws Exception
     */
    private function addItemsToJsonFile(): void
    {
        $var = file_put_contents($this->addressFile, json_encode($this->itemsOfJsonFile), LOCK_EX);
        if ($var === false) throw new Exception("Error: Could not send data to remote server.");
    }
}
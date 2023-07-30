<?php

namespace stores\memory;

use Exception;
use RuntimeException;
use stores\interface\Store;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/UserStore.php';

class FileBlobStore implements Store
{
    private string $imageFile;
    private mixed $itemsOfJsonFile;

    /**
     * constructor:
     * creates user table
     * @param string $imageFile
     */
    public function __construct(string $imageFile)
    {
        $this->imageFile = $imageFile;
        $this->reloadItemsFromJsonFile();
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * methode to save data of an image in the file
     * @param $assigned_ID
     * @param $category
     * @param $filePath
     * @param $mime
     * @return void
     * @throws Exception
     */
    public function create($assigned_ID, $category, $filePath, $mime): void
    {
        $this->reloadItemsFromJsonFile();

        $id = rand(1, 2147483647);

        if($category == "profile_small" || $category == "profile_large") {
            foreach ($this->itemsOfJsonFile as $image) {
                if($image->assigned_ID == $assigned_ID || $image->category == $category) {
                    $this->update($assigned_ID, $category, $filePath, $mime);
                }
            }
        }

        $this->itemsOfJsonFile[] = array("id" => $id, "assigned_ID" => $assigned_ID, "category" => $category, "mime" => $mime, "data" => $filePath);
        $this->addItemsToJsonFile();
    }

    /**
     * @param $assigned_ID
     * @param $category
     * @param $filePath
     * @param $mime
     * @return void
     * @throws Exception
     */
    public function update($assigned_ID, $category, $filePath, $mime): void
    {
        $this->reloadItemsFromJsonFile();

        // updating event data
        foreach ($this->itemsOfJsonFile as $image) {
            if ($image->assigned_ID == $assigned_ID && $image->category == $category) {
                $id = $image->id;
                unset($image);

                // inserting data
                $this->itemsOfJsonFile[] = array("id" => $id, "assigned_ID" => $assigned_ID, "category" => $category, "mime" => $mime, "data" => $filePath);
                $this->addItemsToJsonFile();
                break;
            }
        }
    }

    /**
     * @param $id
     * @return string|null
     */
    public function findOne($id): ?string
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonFile as $image)  {
            if($image->id == $id) {
                return $image->data;
            }
        }
        return null;
    }

    /**
     * methode to delete an image
     * @param $id
     * @return void
     * @throws Exception
     */
    public function delete($id): void
    {
        $this->addItemsToJsonFile();

        // deletes image data
        foreach ($this->itemsOfJsonFile as $image)
        {
            if ($image->id == $id) {
                unset($this->itemsOfJsonFile[$image]);
                $this->addItemsToJsonFile();
                break;
            }
        }
    }

    /**
     * @param $assigned_ID
     * @param $category
     * @return string|null
     */
    public function queryID($assigned_ID, $category) : ?string
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonFile as $image) {
            if ($image->assigned_ID == $assigned_ID && $image->category == $category) {
                return $image->id;
            }
        }
        return null;
    }

    public function queryOwnIDs($assigned_ID) : array
    {
        $this->reloadItemsFromJsonFile();

        $array = array();
        foreach ($this->itemsOfJsonFile as $image) {
            if ($image->assigned_ID == $assigned_ID) {
                $array[] = array("id" => $image->id);
            }
        }
        if(empty($array)) throw new RuntimeException("could not find any");
        return $array;
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                              private methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * Loads content of jsonfile into a variable
     * @return void
     */
    private function reloadItemsFromJsonFile(): void
    {
        $content = file_get_contents($this->imageFile, true);
        $this->itemsOfJsonFile = json_decode($content, false);
    }

    /**
     * Adds an items\User to json file
     * @return void
     * @throws Exception
     */
    private function addItemsToJsonFile(): void
    {
        $var = file_put_contents($this->imageFile, json_encode($this->itemsOfJsonFile), LOCK_EX);
        if($var == false) throw new Exception("Error: Could not send data to remote server.");
    }
}
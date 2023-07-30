<?php

namespace stores\memory;

use Exception;
use php\includes\items\User;
use stores\interface\Store;
use stores\interface\UserStore;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/UserStore.php';

class FileUserStore implements UserStore
{
    private string $userFile;
    private mixed $itemsOfJsonFile;

    private Store $addressStore;
    private FileBlobStore $blobObj;

    /**
     * constructor:
     * creates user table
     * @param string $userFile
     * @param Store $addressStore
     * @param FileBlobStore $blobObj
     */
    public function __construct(string $userFile, Store $addressStore, FileBlobStore $blobObj)
    {
        $this->blobObj = $blobObj;
        $this->addressStore = $addressStore;
        $this->userFile = $userFile;
        $this->reloadItemsFromJsonFile();
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * methode to save data of a user in the file
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function create(User $user): User
    {
        try {
            $this->reloadItemsFromJsonFile();

            if ($user->getUserID() === null)
                $user->setUserID(rand(1, 2147483647));
            $jsonUser = $user->getJsonUser();

            // checking if an entry already exist with the name
            foreach ($this->itemsOfJsonFile as $item) {
                if ($item->name === $jsonUser["name"])
                    throw new Exception("There is already an User called " . $jsonUser["name"] . "!");
            }

            // if any address attribute is not empty
            if ($user->hasAddressInputs()) {
                $address_ID = $this->addressStore->create($user);
                $user->setAddressID($address_ID);
            }

            // inserting data
            $this->itemsOfJsonFile[] = $jsonUser;
            $this->addItemsToJsonFile();

            // gets inserted data
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * methode to update user information.
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function update(User $user): User
    {
        try {
            $this->reloadItemsFromJsonFile();

            $jsonUser = $user->getJsonUser();

            // updates address data
            $address_ID = $this->addressStore->update($user);
            $user->setAddressID($address_ID);

            // updating event data
            foreach ($this->itemsOfJsonFile as $item) {
                if ($item->user_ID === $jsonUser["user_ID"])
                    unset($item);

                // inserting data
                $this->itemsOfJsonFile[] = $jsonUser;
                $this->addItemsToJsonFile();

                break;
            }

            // gets updated data
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * methode to delete a user
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function delete(string $id): void
    {
        $this->reloadItemsFromJsonFile();

        // deletes event data
        foreach ($this->itemsOfJsonFile as $item) {
            if ($item->user_ID === $id) {
                unset($this->itemsOfJsonFile[$item]);
                $this->addItemsToJsonFile();
                break;
            }
        }

        // deletes address data
        $this->addressStore->delete($id);
    }

    /**
     * @param $user_ID
     * @return User|null
     */
    public function findOne($user_ID): ?User
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonFile as $user) {
            if ($user->user_ID === $user_ID) {
                $address = $this->addressStore->findOne($user->address_ID);
                return User::stdClassToUser($user, $address);
            }
        }
        return null;
    }

    /**
     * @param $count
     * @param $address_ID
     * @return int|mixed
     */
    public function getOne($count, $address_ID): mixed
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonFile as $user) {
            if ($user->address_ID === $address_ID) $count++;
        }
        return $count;
    }

    /**
     * gets the data from the events with the $stmt in any attribute
     * @param string $stmt
     * @return array
     */
    public function findAny(string $stmt): array
    {
        $this->reloadItemsFromJsonFile();

        $users = array();
        foreach ($this->itemsOfJsonFile as $item) {
            foreach ($item as $attribute) {
                if ($attribute === $stmt) {
                    $users[] = $this->createUser($item);
                    break;
                }
            }
        }
        return $users;
    }

    /**
     * Returns all items\User stored in the user.json file
     * @return array
     */
    public function findAll(): array
    {
        $this->reloadItemsFromJsonFile();

        $users = array();
        foreach ($this->itemsOfJsonFile as $item) {
            $users[] = $this->createUser($item);
        }
        return $users;
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               custom methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */


    /**
     * methode to check email and password of a user in the database
     * @param $email
     * @param $password
     * @return User
     * @throws Exception
     */
    public function login($email, $password): User
    {
        $this->reloadItemsFromJsonFile();

        foreach ($this->itemsOfJsonFile as $item) {
            // if email does exist
            if ($email === $item->email) {
                // if password is right
                if (password_verify($password, $item->password)) {
                    return $this->createUser($item);
                } else {
                    throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
                }
            }
        }
        throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
    }

    /**
     * @param User $user
     * @param $old_password
     * @param $new_password
     * @return User
     * @throws Exception
     */
    public function changePassword(User $user, $old_password, $new_password): User
    {
        try {
            $this->reloadItemsFromJsonFile();

            $user->setUserID(rand(1, 2147483647));
            $jsonUser = $user->getJsonUser();

            // checking if new password already exist
            foreach ($this->itemsOfJsonFile as $item) {
                if (password_verify($item->password, $new_password)) {
                    throw new Exception("Something went wrong! try again.");
                }
            }

            // checking if user password is equal to typed in old password
            foreach ($this->itemsOfJsonFile as $item) {
                if ($item->user_ID === $jsonUser["user_ID"] && password_verify($item->password, $old_password))
                    throw new Exception("Old Password is incorrect.");
            }

            $user->setPassword(password_hash($new_password, PASSWORD_DEFAULT));

            return $this->update($user);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                              private methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param mixed $user
     * @return User
     */
    private function createUser(mixed $user): User
    {
        $address = $this->addressStore->findOne($user->address_ID);
        $user = User::stdClassToUser($user, $address);
        $imageID = $this->blobObj->queryID($user->getUserID(), "profile_large");

        if ($imageID !== null) {
            $image = $this->blobObj->findOne($imageID);
            $user->setImage($image);
        }
        return $user;
    }

    /**
     * Loads content of jsonfile into a variable
     * @return void
     */
    private function reloadItemsFromJsonFile(): void
    {
        $content = file_get_contents($this->userFile, true);
        $this->itemsOfJsonFile = json_decode($content, false);
    }

    /**
     * Adds an items\User to json file
     * @return void
     * @throws Exception
     */
    private function addItemsToJsonFile(): void
    {
        $var = file_put_contents($this->userFile, json_encode($this->itemsOfJsonFile), LOCK_EX);
        if ($var === false) throw new Exception("Error: Could not send data to remote server.");
    }
}
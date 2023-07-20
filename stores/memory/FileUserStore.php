<?php

namespace stores\memory;

use Exception;
use php\includes\items\User;
use stores\interface\UserStore;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/UserStore.php';

class FileUserStore implements UserStore
{

    private string $userJsonFile;
    private mixed $usersOfJsonFile;

    /**
     * constructor:
     * creates user table
     * @param $userFile
     */
    public function __construct($userFile)
    {
        $this->userJsonFile = $userFile;
        $this->reloadUserFromJsonFile();
    }


    private function reloadUserFromJsonFile(): void
    {
        //todo: maybe add Exception if Reading doesn't work ?
        $content = file_get_contents($this->userJsonFile, true);
        $this->usersOfJsonFile = json_decode($content, false);
    }

    private function addUsersToJsonFile(): void
    {
        $var = file_put_contents($this->userJsonFile, json_encode($this->usersOfJsonFile));
        if ($var !== false) {

        } else {
        }
    }

    /**
     * methode to save register data of a user in the file
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function create(User $user): User
    {
        $user_ID = rand(5, 7);

        foreach ($this->usersOfJsonFile as $userJSON) {
            if ($userJSON->email === $user->getEmail() || $userJSON->password === $user->getPassword()) {
                throw new Exception("Email or Password already exist");
            }
            while ($userJSON->user_ID === $user_ID) {
                $user_ID = rand(5, 7);
            }
        }
        $user->setUserID($user_ID);

        $userJSON = User::toArrayForJsonEntry($user);
        $this->usersOfJsonFile[] = $userJSON;
        $this->addUsersToJsonFile();
        $this->reloadUserFromJsonFile(); // update usersOfJsonFile attribute
        return $this->findOne($user_ID);
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
            $this->delete($user->getUserID());
            $this->create($user);
        } catch (Exception $e) {
            throw new Exception("FileUserStore-update(" . $user->getUserID() ."): Update doesn't worked: " . $e->getMessage());
        }
        return $this->findOne($user->getUserID());
    }

    /**
     * methode to delete a user
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function delete(string $id): void
    {

        $i = 0;
        foreach ($this->usersOfJsonFile as $userJSON) {
            if ($userJSON->user_ID == $id) {
                unset($this->usersOfJsonFile[$i]);
                return;
            }
            $i++;
        }
        throw new Exception("No such items\User was found.");
    }

    /**
     * methode to find a user
     * @param string $id
     * @return User
     * @throws Exception
     */
    public function findOne(string $id): User
    {
        foreach ($this->usersOfJsonFile as $userJSON) {
            if ((string)$userJSON->user_ID === $id) {
                return User::getJsonUser($userJSON);
            }
        }
        throw new Exception("No such items\User was found.");
    }

    /**
     * methode to check email and password of a user in the database
     * @param $email
     * @param $password
     * @return User
     * @throws Exception
     */
    public function login($email, $password): User
    {
        foreach ($this->usersOfJsonFile as $user) {
            if ($user->email === $email && $user->password === $password) {
                return User::getJsonUser($user);
            }
        }
        throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
    }

    /**
     * Returns all items\User stored in the user.json file
     * @return array
     */
    public function findAll(): array
    {
        $users = array();
        foreach ($this->usersOfJsonFile as $userJson) {
            $user = User::getJsonUser($userJson);
            $users[] = $user;
        }
        return $users;
    }

    public function findAny(string $stmt): array
    {
        return array();
        // TODO: Implement findAny() method.
    }

    public function createUserArray(string $sql): array
    {
        return array();
        // TODO: Implement createUserArray() method.
    }

    public function changePassword(object $user, $old_password, $new_password): User
    {
        return new User();
        // TODO: Implement changePassword() method.
    }
}
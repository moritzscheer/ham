<?php

use Item\User;

include_once "../stores/interface/UserStore.php";

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


    private function reloadUserFromJsonFile()
    {
        //todo: maybe add Exception if Reading doesn't work ?
        $content = file_get_contents($this->userJsonFile, true);
        $this->usersOfJsonFile = json_decode($content, false);
    }

    private function addUsersToJsonFile(): bool
    {
        $var = file_put_contents($this->userJsonFile, json_encode($this->usersOfJsonFile));
        if ($var !== false){
            return true;
        } else return false;
    }

    /**
     * methode to save register data of a user in the file
     * @param object $user
     * @return User
     * @throws Exception
     */
    public function create(User $user): User
    {
        $user_ID = uniqid("user_", false);

        foreach ($this->usersOfJsonFile as $userJSON) {
            if ($userJSON->email === $user->getEmail() || $userJSON->password === $user->getPassword()) {
                throw new Exception("Email or Password already exist");
            }
            while ($userJSON->userID === $user_ID) {
                $user_ID = uniqid("user_", false);
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
     * @param object $user
     * @return User
     * @throws Exception
     */
    public function update(User $user): User
    {
        try {
            $this->delete($user->getUserID());
            $this->create($user);
        } catch (Exception $e){
            throw new Exception("Update doesn't worked: " . $e->getMessage());
        }
        return $this->findOne($user->getUserID());
    }

    /**
     * methode to delete a user
     * @param string $user_ID
     * @return void
     * @throws Exception
     */
    public function delete(string $user_ID): void
    {
        foreach ($this->usersOfJsonFile as $userJSON) {
            if ($userJSON->user_ID === $user_ID) {
                unset($this->usersOfJsonFile[$userJSON]);
            }
        }
        throw new Exception("No such Item\User was found.");
    }

    /**
     * methode to find a user
     * @param string $user_ID
     * @return User
     * @throws Exception
     */
    public function findOne(string $user_ID): User
    {
        foreach ($this->usersOfJsonFile as $userJSON) {
            if ((string)$userJSON->user_ID === $user_ID) {
                return User::getJsonUser($userJSON);
            }
        }
        throw new Exception("No such Item\User was found.");
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
                return $user;
            }
        }
        throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
    }

    public function findMany(array $ids)
    {
        $users = array();
        foreach($ids as $id){
            try {
                $users[] = $this->findOne($id);
            }catch (Exception $e){
                yield $e;
                continue;
            }
        }
        return $users;
    }

    /**
     * Returns all Item\User stored in the user.json file
     * @return array
     */
    public function findAll()
    {
        $users = array();
        foreach ($this->usersOfJsonFile as $userJson){
            $user = User::getJsonUser($userJson);
            $users[] = $user;
        }
        return $users;
    }

}
<?php
include_once "../stores/interface/UserStore.php";

class FileUserStore implements UserStore
{

    private ?string $userJsonFile;
    private ?string $usersOfJsonFile;

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
        $content = file_get_contents($this->userJsonFile, true);
        $this->userJsonFile = json_decode($content, false);
    }

    private function addUsersToJsonFile()
    {
        //todo: implement this: writes all User to json file (overwrites json file)
    }

    /**
     * methode to save register data of a user in the file
     * @param object $user
     * @return User
     * @throws Exception
     */
    public function create(object $user): User
    {
        $user_ID = uniqid("user_", false);

        foreach ($this->userJsonFile as $userJSON) {
            if ($userJSON->email === $user->getEmail() || $userJSON->password === $user->getPassword()) {
                throw new Exception("Email or Password already exist");
            }
            while ($userJSON->userID === $user_ID) {
                $user_ID = uniqid("user_", false);
            }
        }
        $userJSON["user_ID"] = $user_ID;
        $userJSON["type"] = $user->getType();
        $userJSON["address_ID"] = $user->getType(); //todo: fix this
        $userJSON["name"] = $user->getType();
        $userJSON["surname"] = $user->getType();
        $userJSON["password"] = $user->getType();
        $userJSON["phone_number"] = $user->getType();
        $userJSON["email"] = $user->getType();
        $userJSON["genre"] = $user->getGenre();
        $userJSON["members"] = $user->getMembers();
        $userJSON["other_remarks"] = $user->getOtherRemarks();

        $users[] = (object)$userJSON; //todo: fix this
        file_put_contents("../resources/json/user.json", json_encode($users));
        return $this->findOne($user_ID);
    }

    /**
     * methode to update user information.
     * @param object $user
     * @return User
     * @throws Exception
     */
    //todo: fix this
    public function update(object $user): User
    {
        $json = json_decode($this->userJsonFile, false);
        foreach ($json as $userJSON) {
            if ($userJSON->user_ID === $user->getUserID()) {
                $userJSON["user_ID"] = $user->getUserID();
                $userJSON["type"] = $user->getType();
                $userJSON["address_ID"] = $user->getType();
                $userJSON["name"] = $user->getType();
                $userJSON["surname"] = $user->getType();
                $userJSON["password"] = $user->getType();
                $userJSON["phone_number"] = $user->getType();
                $userJSON["email"] = $user->getType();
                $userJSON["genre"] = $user->getGenre();
                $userJSON["members"] = $user->getMembers();
                $userJSON["other_remarks"] = $user->getOtherRemarks();
                file_put_contents("../resources/json/user.json", json_encode($json));

                $users[] = (object)$userJSON;
                file_put_contents("../resources/json/user.json", json_encode($users));
                return $this->findOne($user->getUserID());
            }
        }
        throw new Exception('No such User was found.');
    }

    /**
     * methode to delete a user
     * @param string $user_ID
     * @return void
     * @throws Exception
     */
    public function delete(string $user_ID): void
    {
        $json = json_decode($this->userJsonFile, false); //todo: fix this
        foreach ($json as $userJSON) {
            if ($userJSON->user_ID === $user_ID) {
                unset($json[$userJSON]);
                file_put_contents("../resources/json/user.json", json_encode($json));
                return;
            }
        }
        throw new Exception("No such User was found.");
    }

    /**
     * methode to find a user
     * @param string $user_ID
     * @return User
     * @throws Exception
     */
    //todo: fix this
    public function findOne(string $user_ID): User
    {
        $json = json_decode($this->userJsonFile, false);
        foreach ($json as $userJSON) {
            if ($userJSON->user_ID === $user_ID) {
                $user[0] = $userJSON->user_ID;
                $user[1] = $userJSON->address_ID;
                $user[2] = $userJSON->type;
                $user[3] = $userJSON->name;
                $user[4] = $userJSON->surname;
                $user[5] = $userJSON->password;
                $user[6] = $userJSON->phone_number;
                $user[7] = $userJSON->email;
                $user[8] = $userJSON->genre;
                $user[9] = $userJSON->members;
                $user[10] = $userJSON->other_remarks;
                return User::withAddress($user);
            }
        }
        throw new Exception("No such User was found.");
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
        $users = json_decode($this->userJsonFile, false);
        foreach ($users as $user) {
            if ($user->email === $email && $user->password === $password) {
                return $user;
            }
        }
        throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
    }

    public function findMany(array $ids)
    {
        // TODO: Implement findMany() method.
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

}
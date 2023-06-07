<?php
include_once "UserStore.php";

class FileUserStore implements UserStore {

    private ?string $userFile;
    private ?int $user_ID = null;

    /**
     * constructor:
     * creates user table and user_type table
     * @param $userFile
     */
    public function create($userFile): void {
        $this->userFile = file_get_contents($userFile, true);
    }


    /**
     * methode to save register data of a user in the file
     * @param $type_ID
     * @param $address_ID
     * @param $name
     * @param $surname
     * @param $password
     * @param $phone_number
     * @param $email
     * @return String
     * @throws Exception
     */
    public function register($type_ID, $address_ID, $name, $surname, $password, $phone_number, $email): String {
        $users = json_decode($this->userFile, false);

        foreach ($users as $user) {
            if($user->email === $email || $user->password === $password) {
                throw new Exception("Email or Password already exist");
            }
        }
        $newUser["user_ID"] = random_bytes(10);
        $newUser["type_ID"] = $type_ID;
        $newUser["address_ID"] = $address_ID;
        $newUser["name"] = $name;
        $newUser["surname"] = $surname;
        $newUser["password"] = $password;
        $newUser["phone_number"] = $phone_number;
        $newUser["email"] = $email;
        $newUser["profile_picture_small"] = "";
        $newUser["profile_picture_large"] = "";
        $newUser["profile_gallery"] = array();

        $users[] = (object) $newUser;
        file_put_contents("../resources/json/user.json", json_encode($users));
        return $newUser["user_ID"];
    }                                                                               


    /**
     * methode to check email and password of a user in the database
     * @param $email
     * @param $password
     * @return stdClass
     * @throws Exception
     */
    public function login($email, $password): stdClass {
        $users = json_decode($this->userFile, false);
        foreach ($users as $user) {
            if($user->email === $email && $user->password === $password) {
                return $user;
            }
        }
        throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
    }


    /**
     * methode to delete a user from the database
     * @param $user_ID
     * @return void
     * @throws Exception
     */
    public function delete($user_ID): void {
        $users = json_decode($this->userFile, false);
        foreach ($users as $user) {
            if($user->user_ID !== "1") {
                throw new Exception("Can't delete user test.");
            } elseif ($user->user_ID === $user_ID) {

                //todo delete user

            } else {
                throw new Exception("No such User was found.");
            }
        }
    }


    /**
     * @param $user_ID
     * @param $list
     * @return string
     * @throws Exception
     */
    public function update($user_ID, $list) {
        $users = json_decode($this->userFile, false);
        foreach ($users as $user) {
            if($user->user_ID === $user_ID) {
                // user was found
                foreach ($list as $set) {
                    $var = $set->var;
                    $value = $set->value;

                    $user->$var = $value;
                }
            } else {
                throw new Exception('No such User was found.');
            }
        }
        return "";
    }
}
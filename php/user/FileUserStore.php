<?php
include_once "UserStore.php";

class FileUserStore implements UserStore {

    private ?string $userFile;

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
     * @param $type
     * @param $address_ID
     * @param $name
     * @param $surname
     * @param $password
     * @param $phone_number
     * @param $email
     * @return String
     * @throws Exception
     */
    public function register($type, $address_ID, $name, $surname, $password, $phone_number, $email): String {
        $users = json_decode($this->userFile, false);
        $user_ID = random_int(2, 1000000);

        foreach ($users as $user) {
            if ($user->email === $email || $user->password === $password) {
                throw new Exception("Email or Password already exist");
            }
            if ($user->userID === $user_ID) {
                $user_ID = random_int(2, 1000000);
            }
        }
        $newUser["user_ID"] = $user_ID;
        $newUser["type"] = $type;
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
        return $user_ID;
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
     * @param $user_ID
     * @return void
     * @throws Exception
     */
    public function delete($user_ID): void {
        $users = json_decode($this->userFile, false);
        foreach ($users as $user => $value) {
            if($value->user_ID === $user_ID) {
                if($value->user_ID === 1) {
                    throw new Exception("Can't delete user test.");
                } else {
                    unset($users[$user]);
                    file_put_contents("../resources/json/user.json", json_encode($users));
                    return;
                }
            }
        }
        throw new Exception("No such User was found.");
    }


    /**
     * @param $user_ID
     * @param $array
     * @return void
     * @throws Exception
     */
    public function update($user_ID, $array): void {
        $users = json_decode($this->userFile, false);
        foreach ($users as $user) {
            if($user->user_ID === $user_ID) {
                if($user->user_ID === 1) {
                    throw new Exception("Can't change user test.");
                } else {
                    foreach ($array as $var => $value) {
                        $user->$var = $value;
                        file_put_contents("../resources/json/user.json", json_encode($users));
                        return;
                    }
                }
            }
        }
        throw new Exception('No such User was found.');
    }
}
<?php

use Item\User;

include_once "../stores/interface/UserStore.php";

class DBUserStore implements UserStore
{
    private PDO $db;
    private Store $addressStore;
    private Blob $blobObj;


    public function __construct(PDO $db, Store $addressStore, Blob $blobObj) {
        $this->db = $db;
        $this->addressStore = $addressStore;
        $this->blobObj = $blobObj;

        // creates the user table
        $sql = "CREATE TABLE IF NOT EXISTS user (".
               "user_ID INTEGER PRIMARY KEY AUTOINCREMENT, ".
               "address_ID int(11) DEFAULT NULL, ".
               "type varchar(15) NOT NULL, ".
               "name varchar(50) DEFAULT NULL, ".
               "surname varchar(50) DEFAULT NULL, ".
               "password varchar(255) NOT NULL UNIQUE, ".
               "phone_number varchar(20) DEFAULT NULL, ".
               "email varchar(255) NOT NULL UNIQUE, ".
               "genre varchar(255) DEFAULT NULL, ".
               "members varchar(255) DEFAULT NULL, ".
               "other_remarks longtext DEFAULT NULL, ".
               "FOREIGN KEY (address_ID) REFERENCES address(address_ID));";
        $db->exec($sql);
    }

    /**
     * methode to register a user into the database. First it searches the database, if the email or password
     * already exist, then the data set is inserted and returned as a Item\User object. Else an exception is thrown.
     * @param User $user the user object given in
     * @return User the returned user object with the user_ID in it
     * @throws Exception
     */
    public function create(User $user): User {
        try {
            $this->db->beginTransaction();

            // checking if an entry already exist with the password an email
            $sql = "SELECT * FROM user WHERE email = '".$user->getEmail()."' OR password = '".$user->getPassword()."';";
            $stmt = $this->db->query($sql)->fetch();
            if($stmt !== false) {
                throw new Exception("Email or Password already exist");
            }

            if($user->getStreetName() !== "" || $user->getHouseNumber() !== "" || $user->getPostalCode() !== "" || $user->getCity() !== "") {
                $address_ID = $this->addressStore->create($user);
                $user->setAddressID($address_ID);
            }

            $sql = "INSERT INTO user (".$user->getAttributes("key", "list").") VALUES (".$user->getAttributes("valueWithApo", "list").");";
            $this->db->exec($sql);

            $user = $this->findOne($this->db->lastInsertId());
            $this->db->commit();
            return $user;
        } catch (Exception $ex) {
            $this->db->rollBack();
            throw new Exception($ex);
        }
    }

    /**
     * methode to update user information.
     * @param object $user
     * @return User
     */
    public function update(User $user): User {
        $address_ID = $this->addressStore->update($user);
        $user->setAddressID($address_ID);

        $sql = "UPDATE user SET ".$user->getAttributes("key", "set")." WHERE user_ID = '". $user->getUserID()."';";

        $this->db->exec($sql);
        return $this->findOne($user->getUserID());
    }

    /**
     * methode to delete a user
     * @param string $user_ID
     * @return void
     */
    public function delete(string $user_ID): void {
        $sql = "DELETE FROM user WHERE user_ID = '" . $user_ID . "' RETURNING 'address_ID';";
        $stmt = $this->db->exec($sql);
        $this->addressStore->delete($stmt);
    }

    /**
     * methode to find a user
     * @param string $user_ID
     * @return User
     */
    public function findOne(string $user_ID): User {
        $sql = "SELECT * FROM user WHERE user_ID = :user_ID;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(":user_ID" => $user_ID));
        $stmt->bindColumn(2, $address_ID);
        $stmt->bindColumn(3, $type);
        $stmt->bindColumn(4, $name);
        $stmt->bindColumn(5, $surname);
        $stmt->bindColumn(6, $password);
        $stmt->bindColumn(7, $phone_number);
        $stmt->bindColumn(8, $email);
        $stmt->bindColumn(9, $genre);
        $stmt->bindColumn(10, $members);
        $stmt->bindColumn(11, $other_remarks);
        $stmt->fetch(PDO::FETCH_BOUND);

        if($address_ID !== NULL) {
            $sql = "SELECT * FROM address WHERE address_ID = :address_ID;";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(":address_ID" => $address_ID));
            $stmt->bindColumn(2, $street_name);
            $stmt->bindColumn(3, $house_number);
            $stmt->bindColumn(4, $postal_code);
            $stmt->bindColumn(5, $city);
            $stmt->fetch(PDO::FETCH_BOUND);
        }

        $user =  User::withAddress(array("user_ID" => $user_ID, "address_ID" => $address_ID, "type" => $type, "name" => $name, "surname" => $surname
        , "password" => $password, "phone_number" => $phone_number, "email" => $email, "genre" => $genre, "members" => $members
        , "other_remarks" => $other_remarks, "street_name" => $street_name, "house_number" => $house_number
        , "postal_code" => $postal_code, "city" => $city));
        return $user;
    }

    /**
     * methode to find multiple users
     * @param array $user_IDs
     * @return false|int
     */
    public function findMany(array $user_IDs) : false|int {
        foreach ($user_IDs as $user_ID) {
            $id = "user_ID = " . $user_ID;
        }
        $sql = "SELECT * FROM user ".
               "WHERE ". $user_IDs.join(" OR ").
               "INNER JOIN address ".
               "ON address.address_ID = user.address_ID ".
               "LIMIT " .count($user_IDs);
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * methode to find all users
     * @return array
     */
    public function findAll() : array {
        $sql = "SELECT * FROM user INNER JOIN address ".
               "ON address.address_ID = user.address_ID ".
               "WHERE type = 'Musician';";
        $stmt = $this->db->query($sql)->fetchAll();

        $return = array();
        foreach ($stmt as $band) {
            $newUser = User::withAddress($band);

            try {
                $imageID = $this->blobObj->queryID($band["user_ID"], "profile_picture_large");
                if($imageID[0]["id"] !== null) {
                    $blobArray = $this->blobObj->selectBlob($imageID[0]["id"]);
                    $newUser->setBlobData($blobArray);
                }
                $return[] = $newUser;
            } catch (RuntimeException $ex) {
                $return[] = $newUser;
            }
        }
        return $return;
    }

    /**
     * @param $email
     * @param $password
     * @return User
     * @throws Exception
     */
    public function login($email, $password): User {
        $sql = "SELECT * FROM user WHERE email = '".$email."';";
        $stmt = $this->db->query($sql)->fetch();
        
        if($stmt === false) {
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
        }
        if(!password_verify($password, $stmt["password"])) {
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
        }

        return $this->findOne($stmt["user_ID"]);
    }

    /**
     * @throws Exception
     */
    public function changePassword(object $user, $old_password, $new_password): User {
        // checking if new password already exist
        $sql = "SELECT * FROM user WHERE password = '".$new_password."';";
        $stmt = $this->db->query($sql)->fetch();
        if($stmt !== false) {
            throw new Exception("Something went wrong! try again.");
        }

        // checking if user password is equal to typed in old password
        $sql = "SELECT password FROM user WHERE user_ID = '".$user->getUserID()."';";
        $stmt = $this->db->query($sql)->fetch();

        if($stmt[0] != $old_password) {
            throw new Exception("Old Password is incorrect.");
        }

        $user->setPassword($new_password);
        return $this->update($user);
    }

}
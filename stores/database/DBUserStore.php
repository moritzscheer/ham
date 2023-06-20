<?php
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
               "name varchar(15) DEFAULT NULL, ".
               " surname varchar(15) DEFAULT NULL, ".
               "password varchar(20) NOT NULL UNIQUE, ".
               "phone_number varchar(20) DEFAULT NULL, ".
               "email varchar(30) NOT NULL UNIQUE, ".
               "genre varchar(30) DEFAULT NULL, ".
               "members varchar(50) DEFAULT NULL, ".
               "other_remarks longtext DEFAULT NULL, ".
               "FOREIGN KEY (address_ID) REFERENCES address(address_ID));";
        $db->exec($sql);
    }

    /**
     * methode to register a user into the database. First it searches the database, if the email or password
     * already exist, then the data set is inserted and returned as a User object. Else an exception is thrown.
     * @param object $user the user object given in
     * @return User the returned user object with the user_ID in it
     * @throws Exception
     */
    public function create(object $user): User {
        try {
            $this->db->beginTransaction();

            // checking if an entry already exist with the password an email
            $sql = "SELECT * FROM user WHERE email = '".$user->getEmail()."' OR password = '".$user->getPassword()."';";
            $stmt = $this->db->query($sql)->fetch();
            if($stmt !== false) {
                throw new Exception("Email or Password already exist");
            }

            //  create address
            $address = $this->addressStore->create($user);

            // inserting an entry
            $sql = "INSERT INTO user ".
                   "(address_ID, type, name, surname, ".
                   "password, phone_number, email, genre, ".
                   "members, other_remarks) VALUES ".
                   "(:address_ID, :type, :name, :surname, :password, :phone_number, :email, :genre, :members, :other_remarks);".
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':address_ID', $address->getAddressID());
            $stmt->bindParam(':type', $user->getType());
            $stmt->bindParam(':name', $user->getName());
            $stmt->bindParam(':surname', $user->getSurname());
            $stmt->bindParam(':password', $user->getPassword());
            $stmt->bindParam(':phone_number', $user->getPhoneNumber());
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':genre', $user->getGenre());
            $stmt->bindParam(':members', $user->getMembers());
            $stmt->bindParam(':other_remarks', $user->getOtherRemarks());

            $stmt->execute();

            $user = $this->findOne($this->db->lastInsertId());
            $this->db->commit();
            return $user;
        } catch (Exception $ex) {
            $this->db->rollBack();
            throw new Exception("could not create User");
        }
    }

    /**
     * methode to update user information.
     * @param object $user
     * @return User
     */
    public function update(object $user): User {
        $sql = "UPDATE user SET ".
               "address_ID = '".$user->getAddressID()      ."', ".
               "type = '".$user->getType()                 ."', ".
               "name = '".$user->getName()                 ."', ".
               "surname = '".$user->getSurname()           ."', ".
               "password = '".$user->getPassword()         ."', ".
               "phone_number = '".$user->getPhoneNumber()  ."', ".
               "email = '".$user->getEmail()               ."', ".
               "genre = '".$user->getGenre()               ."', ".
               "members = '".$user->getMembers()           ."', ".
               "other_remarks = '".$user->getOtherRemarks()."', ".
               "WHERE user_ID = '".$user->getUserID()      ."';";
        $this->db->exec($sql);
        return $this->findOne($user->getUserID());
    }

    /**
     * methode to delete a user
     * @param string $user_ID
     * @return void
     */
    public function delete(string $user_ID): void {
        try {
            $this->db->beginTransaction();

            $sql = "SELECT COUNT(*) FROM user WHERE address_ID = (SELECT address_ID FROM user WHERE user_ID = '".$user_ID."');";
            $stmt = $this->db->query($sql)->fetch();

            if($stmt[0] == 1) {
                $sql = "SELECT address_ID FROM user WHERE user_ID = '".$user_ID."';";
                $address_ID = $this->db->query($sql)->fetch();

                $sql = "DELETE FROM user WHERE user_ID = '".$user_ID."';";
                $this->db->exec($sql);

                $this->addressStore->delete($address_ID[0]);
            } else {
                $sql = "DELETE FROM user WHERE user_ID = '".$user_ID."';";
                $this->db->exec($sql);
            }

            $this->db->commit();
        } catch (Exception $ex) {
            $this->db->rollBack();
        }
    }

    /**
     * methode to find a user
     * @param string $user_ID
     * @return User|null
     */
    public function findOne(string $user_ID): User|null {
        $sql = "SELECT * FROM user JOIN address ".
               "ON address.address_ID = user.address_ID ".
               "WHERE user_ID = '".$user_ID."';";
        $stmt = $this->db->query($sql)->fetch();

        if(!$stmt) {
            return null;
        } else {
            return User::withAddress($stmt);
        }
    }

    /**
     * methode to find multiple users
     * @param array $user_IDs
     * @return false|int
     */
    public function findMany(array $user_IDs) {
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
        $sql = "SELECT * FROM user WHERE email = '".$email."' AND password = '".$password."';";
        $stmt = $this->db->query($sql)->fetch();
        if(!$stmt) {
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
        }
        return $this->findOne($stmt[0]);
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
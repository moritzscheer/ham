<?php
include_once "../stores/interface/UserStore.php";

class DBUserStore implements UserStore
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;


        // creates the user table
        $sql = "CREATE TABLE IF NOT EXISTS user (
                user_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                address_ID int(11) DEFAULT NULL,
                type varchar(15) NOT NULL,
                name varchar(15) DEFAULT NULL,
                surname varchar(15) DEFAULT NULL,
                password varchar(20) NOT NULL UNIQUE,
                phone_number varchar(20) DEFAULT NULL,
                email varchar(30) NOT NULL UNIQUE,
                genre varchar(30) DEFAULT NULL,
                members varchar(50) DEFAULT NULL,
                other_remarks longtext DEFAULT NULL,
                FOREIGN KEY (address_ID) REFERENCES address(address_ID)
            );";
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
        // checking if email or password already exist
        $sql = "SELECT * FROM user WHERE email = '".$user->getEmail()."' OR password = '".$user->getPassword()."';";
        $stmt = $this->db->query($sql)->fetch();
        if($stmt !== false) {
            throw new Exception("Email or Password already exist");
        }

        $create = "INSERT INTO user (address_ID, type, name, surname, password, phone_number, email, genre, members, other_remarks ) VALUES (
            '".$user->getAddressID()."',
            '".$user->getType()."',
            '".$user->getName()."',
            '".$user->getSurname()."',
            '".$user->getPassword()."',
            '".$user->getPhoneNumber()."',
            '".$user->getEmail()."',
            '".$user->getGenre()."',
            '".$user->getMembers()."',
            '".$user->getOtherRemarks()."');";
        $this->db->exec($create);

        return $this->findOne($this->db->lastInsertId());
    }

    /**
     * methode to update user information.
     * @param object $user
     * @return User
     */
    public function update(object $user): User {
        $sql = "UPDATE user SET 
            address_ID = '".$user->getAddressID()."', 
            type = '".$user->getType()."', 
            name = '".$user->getName()."', 
            surname = '".$user->getSurname()."',
            password = '".$user->getPassword()."',
            phone_number = '".$user->getPhoneNumber()."',
            email = '".$user->getEmail()."',
            genre = '".$user->getGenre()."',
            members = '".$user->getMembers()."',
            other_remarks = '".$user->getOtherRemarks()."'
            WHERE user_ID = ".$user->getUserID().";";
        $this->db->exec($sql);
        return $this->findOne($user->getUserID());
    }

    /**
     * methode to delete a user
     * @param string $user_ID
     * @return void
     */
    public function delete(string $user_ID): void {
        $sql = "DELETE FROM user WHERE user_ID = '".$user_ID."';";
        $this->db->exec($sql);
    }

    /**
     * methode to find a user
     * @param string $user_ID
     * @return User|null
     */
    public function findOne(string $user_ID): User|null {
        $sql ="SELECT * FROM user WHERE user_ID = ".$user_ID;
        $stmt = $this->db->query($sql)->fetch();
        if(!$stmt) {
            return null;
        } else {
            return User::withUserID($stmt);
        }
    }

    /**
     * methode to find multiple users
     * @param array $user_IDs
     * @return false|int
     */
    public function findMany(array $user_IDs) {
        foreach ($user_IDs as $user_ID) {
            $id = "user_ID = " . $id;
        }
        $sql ="SELECT * FROM user
                     WHERE ". $user_IDs.join(" OR ") ."
                     INNER JOIN address 
                     ON address.address_ID = user.address_ID;
                     LIMIT " .count($user_IDs);
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * methode to find all users
     * @return array
     */
    public function findAll() : array {
        $sql = "SELECT * FROM user
                    INNER JOIN address 
                    ON address.address_ID = user.address_ID;";
        return $this->db->query($sql)->fetchAll();
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
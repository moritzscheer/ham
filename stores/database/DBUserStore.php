<?php
include_once "../stores/interface/UserStore.php";

class DBUserStore implements UserStore
{
    private PDO $db;
    private Store $addressStore;

    public function __construct(PDO $db, Store $addressStore) {
        $this->db = $db;
        $this->addressStore = $addressStore;

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
        $result = $this->db->query($sql);
        $row = $result->fetch();
        if($row !== false) {
            throw new Exception("Email or Password already exist");
        }
        
        $create = "INSERT INTO user (address_ID, type, name, surname, password, phone_number, email, genre, members, other_remarks) VALUES ('".$user->getAddressID()."', '".$user->getType()."', '" . $user->getName()."', '".$user->getSurname()."', '".$user->getPassword()."', '".$user->getPhoneNumber()."', '".$user->getEmail()."', '".$user->getGenre()."', '".$user->getMembers()."', '".$user->getOtherRemarks()."');";
        $this->db->exec($create);

        return $this->findOne($this->db->lastInsertId());
    }

    public function update(object $user): User {
        $update = "UPDATE user SET 
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
        $this->db->exec($update);
        return $this->findOne($user->getUserID());
    }

    public function delete(string $user_ID): void {
        $delete = "DELETE FROM user WHERE user_ID = '".$user_ID."';";
        $this->db->exec($delete);
    }

    public function findOne(string $user_ID): User|null {
        $findOne ="SELECT * FROM user WHERE user_ID = ".$user_ID;
        $result = $this->db->query($findOne)->fetch();
        if(!$result) {
            return null;
        } else {
            return User::withUserID($result);
        }
    }

    public function findMany(array $user_IDs) {
        foreach ($user_IDs as $user_ID) {
            $id = "user_ID = " . $id;
        }
        $findMany ="SELECT * FROM user
                     WHERE ". $user_IDs.join(" OR ") ."
                     INNER JOIN address 
                     ON address.address_ID = user.address_ID;
                     LIMIT " .count($user_IDs);
        return $this->db->exec($findMany);

    }

    public function findAll() {
        $findAll = "SELECT * FROM user
                    INNER JOIN address 
                    ON address.address_ID = user.address_ID;";
        return $this->db->exec($findAll);
    }

    /**
     * @param $email
     * @param $password
     * @return User
     * @throws Exception
     */
    public function login($email, $password): User {
        $sql = "SELECT * FROM user WHERE email = '".$email."' AND password = '".$password."';";
        $result = $this->db->query($sql);
        $row = $result->fetch();
        if($row === false) {
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
        }
        return $this->findOne($row[0]);
    }

    /**
     * @throws Exception
     */
    public function changePassword(object $user, $old_password, $new_password): User {
        // checking if new password already exist
        $sql = "SELECT * FROM user WHERE password = '".$new_password."';";
        $result = $this->db->query($sql);
        $row = $result->fetch();
        if($row !== false) {
            throw new Exception("Something went wrong! try again.");
        }

        // checking if user password is equal to typed in old password
        $sql = "SELECT password FROM user WHERE user_ID = '".$user->getUserID()."';";
        $password = $this->db->query($sql)->fetch();
        
        if($password[0] != $old_password) {
            throw new Exception("Old Password is incorrect.");
        }
        
        $user->setPassword($new_password);
        return $this->update($user);
    }

}
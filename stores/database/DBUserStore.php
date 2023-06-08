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
                password varchar(20) NOT NULL,
                phone_number varchar(20) DEFAULT NULL,
                email varchar(30) NOT NULL,
                genre varchar(30) DEFAULT NULL,
                members varchar(50) DEFAULT NULL,
                other_remarks longtext DEFAULT NULL,
                FOREIGN KEY (address_ID) REFERENCES address(address_ID)
            );";
        $db->exec($sql);
    }


    /**
     * @throws Exception
     */
    public function create(object $user): User {
        // checking if email or password already exist
        $sql = "SELECT * FROM user WHERE email = '" . $user->getEmail() . "' OR password = '" . $user->getPassword() . "';";
        $result = $this->db->query($sql);
        if ($result->rowCount() > 0) {
            throw new Exception("Email or Password already exist");
        }

        $create = "INSERT INTO user VALUES ('".$user->getAddressID()."', '".$user->getType()."', '" . $user->getName()."', '".$user->getSurname()."', '".$user->getPassword()."', '".$user->getPhoneNumber()."', '".$user->getEmail()."', '".$user->getGenre()."', '".$user->getMembers()."', '".$user->getOtherRemarks()."');";
        $this->db->exec($create);

        return $this->findOne($this->db->lastInsertId());
    }

    public function update(object $user): User {
        $update = "UPDATE user SET 
            address_ID = " . $user->getAddress_ID() . ",
            type = " . $user->getType() . ",
            name = " . $user->getName() . ",
            surname = " . $user->getSurname() . "
            phone_number = " . $user->getPhone_number() . "
            email = " . $user->getEmail() . "
            genre = " . $user->getGenre() . "
            members = " . $user->getMembers() . "
            other_remarks = " . $user->getOther_remarks() . "
            WHERE user_ID = " . $user->getUser_ID() . ";";

        $this->db->exec($update);
        return $this->findOne($user->getUser_ID());
    }

    public function delete(string $user_ID): void {
        $delete = "DELETE FROM event WHERE event_ID = " . $user_ID;
        $this->db->exec($delete);
    }

    public function findOne(string $user_ID): false|int {
        $findOne ="SELECT * FROM user 
                     WHERE user_ID = " . $user_ID."
                     INNER JOIN address 
                     ON address.address_ID = user.address_ID;
                     LIMIT 1";
        return User::withUserID($this->db->query($findOne)->fetch());
    }

    public function findMany(array $user_IDs) {
        foreach ($user_IDs as $user_ID) {
            $id = "event_ID = " . $id;
        }
        $findMany ="SELECT * FROM event 
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
     * @throws Exception
     */
    public function login($email, $password): void {
        $sql = "SELECT COUNT(*) FROM user WHERE email = '" . $email . "' AND password = '" . $password . "';";
        $result = $this->db->query($sql);
        if ($result->rowCount() == 0) {
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
        }
    }
}
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
        $sql = "CREATE TABLE user (
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
                FOREIGN KEY (type_ID) REFERENCES type(type_ID),
                FOREIGN KEY (address_ID) REFERENCES address(address_ID)
            );";
        $db->exec($sql);
    }


    /**
     * @throws Exception
     */
    public function create(object $user): User {
        // checking if email or password already exist
        $select = "SELECT * FROM user WHERE email = '" . $user->getEmail() . "' OR password = '" . $user->getPassword() . "';";
        $result = $this->query($select);
        if ($result->numRows > 0) {
            throw new Exception("Email or Password already exist");
        }

        $create = "INSERT INTO user VALUES ('" . $user->getAddress_ID() . "', '" . $user->getType() . "', '" . $user->getName() . "', '" . $user->getSurname() . "', '" . $user->getPassword() . "', '" . $user->getPhone_number() . "', '" . $user->getEmail() . "', '" . $user->getGenre() . "', '" . $user->getMembers() . "', '" . $user->getOther_remarks() . "');";
        $user_ID = $this->db->exec($create);
        return $this->findOne($user_ID);
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
        $delete = "DELETE FROM user WHERE user_ID = " . $user_ID;
        $this->db->exec($delete);
    }

    public function findOne(string $user_ID): User {
        $findOne = "SELECT * FROM user 
                     WHERE user_ID = " . $user_ID . "
                    LIMIT 1";
        return new User($this->db->query($findOne)->fetch());
    }

    public function findMany(array $user_IDs): array {
        foreach ($user_IDs as $key => $user_ID) {
            $user_IDs[$key] = "user_ID = " . $user_ID;
        }
        $findMany = "SELECT * FROM user 
                     WHERE " . $user_IDs . join(" OR ") . " LIMIT " . count($user_IDs);
        $users = $this->db->query($findMany)->fetchAll();
        foreach ($users as $key => $user) {
            $users[$key] = new User($user);
        }
        return $users;
    }

    public function findAll(): array {
        $findAll = "SELECT * FROM user ";
        return $this->db->exec($findAll);
    }

    public function login($email, $password): void {
        $sql = "SELECT COUNT(*) FROM user WHERE email = '" . $email . "' AND password = '" . $password . "';";
        $result = $this->exec($sql);
        if ($sql == 0) {
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
        }
    }
}
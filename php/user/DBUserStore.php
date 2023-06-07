<?php
include_once "UserStore.php";

class DBUserStore implements UserStore {

    protected $db;


    /**
     * constructor
     * creates user table and user_type table
     */
    public function DBUserStore() {
        global $db;
        try {
            $this->openConnection();

            // creates the user table
            $sql = "CREATE TABLE user (
                user_ID bigint(20) DEFAULT NULL,
                type_ID tinyint(1) NOT NULL,
                address_ID int(11) DEFAULT NULL,
                name varchar(15) DEFAULT NULL,
                surname varchar(15) DEFAULT NULL,
                password varchar(20) NOT NULL,
                phone_number varchar(20) DEFAULT NULL,
                email varchar(30) NOT NULL,
                PRIMARY KEY (user_ID),
                FOREIGN KEY (type_ID) REFERENCES type(type_ID),
                FOREIGN KEY (address_ID) REFERENCES address(address_ID)
            );";
            $db->exec($sql);

            // creates the type user table
            $sql = "CREATE TABLE type_user (
                user_type_ID bigint(20) DEFAULT NULL,
                type_ID tinyint(1) NOT NULL,
                user_ID bigint(20) NOT NULL,
                genre varchar(30) DEFAULT NULL,
                members varchar(50) DEFAULT NULL,
                other_remarks longtext DEFAULT NULL,
                PRIMARY KEY (user_type_ID),
                FOREIGN KEY (type_ID) REFERENCES type(type_ID),
                FOREIGN KEY (user_ID) REFERENCES user(user_ID)
            );";
            $db->exec($sql);

            $this->closeConnection();
        } catch (PDOException $ex) {

        }

    }
    
    /**
     * methode to open connection to database
     */
    protected function openConnection(): void {
        try {
            $user = "root";
            $pw = null;
            $dsn = "sqlite:sqlite-pdo.db";
            $this->db = new PDO($dsn, $user, $pw);
        } catch (PDOException $exc) {
            $this->db = NULL;
            throw $exc;
        }
    }

    /**
     * methode to close connection to database
     */
    protected function closeConnection(): void {
        if ($this->db != NULL) {
            $this->db->close();
        }
    }

    /**
     * methode to save register data of a user in the database
     * @throws Exception
     */
    public function register($type, $address_ID, $name, $surname, $password, $phone_number, $email): void {
        try {
            $this->openConnection();
            $this->exec("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
            $this->beginTransaction();

            // checking if email or password already exist
            $sql = "SELECT * FROM user WHERE email = '".$_SESSION["email"]."' AND password = '".$_SESSION["password"]."';";
            $result = $this->exec($sql);
            if ($result > 0) {
                throw new Exception("Email or Password already exist");
            }

            // inserting data in the user and address table
            if($_SESSION["street_name"] != null || $_SESSION["house_number"] != null || $_SESSION["postal_code"] != null || $_SESSION["city"] != null) {
                // if any data is given for address put in data
                $sql = "INSERT INTO address VALUES ('null', '".$_SESSION["street_name"]."', '".$_SESSION["house_number"]."', '".$_SESSION["postal_code"]."', '".$_SESSION["city"]."');";
                $this->exec($sql);
                $sql = "INSERT INTO user VALUES ('null', '".$type."', '".LAST_INSERT_ID()."', '".$_SESSION["name"]."', '".$_SESSION["surname"]."', '".$_SESSION["password"]."', '".$_SESSION["phoneNumber"]."', '".$_SESSION["email"]."');";
                $this->exec($sql);
            } else {
                // if no data is given set addressID to null
                $sql = "INSERT INTO user VALUES ('null', '".$type."', 'null', '".$_SESSION["name"]."', '".$_SESSION["surname"]."', '".$_SESSION["password"]."', '".$_SESSION["phoneNumber"]."', '".$_SESSION["email"]."');";
                $this->exec($sql);
            }

            $this->commit();
            $this->closeConnection();
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }


    /**
     * methode to check email and password of a user in the database
     * @throws Exception
     */
    public function login($email, $password): void {
        try {
            $this->openConnection();

            $sql = "SELECT email, password FROM user WHERE email = '".$_SESSION["email"]."' AND password = '".$_SESSION["password"]."';";
            $result = $this->exec($sql);
            if ($result == 0) {
                throw new Exception('<p id="loginError">Email or Password are not correct!</p>');
            }

            $this->closeConnection();
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    
    /**
     * methode to delete a user from the database
     */
    public function delete($user_ID) {
        try {
            $this->openConnection();

            $sql = "DELETE FROM user WHERE email = '".$_SESSION["email"]."';";
            $this->exec($sql);

            $this->closeConnection();
        } catch (Exception $ex) {
            return false;
        }
    }

    public function update($user_ID, $array): void {
        // TODO: Implement update() method.
    }

    public function create($userFile): void {
        // TODO: Implement create() method.
    }
}
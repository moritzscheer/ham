<?php

namespace stores\database;

use Exception;
use php\includes\items\User;
use PDO;
use RuntimeException;
use stores\interface\Store;
use stores\interface\UserStore;


class DBUserStore implements UserStore
{
    private PDO $db;
    private Store $addressStore;
    private DBBlobStore $blobObj;

    /**
     * constructor:
     * creates user table
     * @param PDO $db
     * @param Store $addressStore
     * @param DBBlobStore $blobObj
     */
    public function __construct(PDO $db, Store $addressStore, DBBlobStore $blobObj)
    {
        $this->db = $db;
        $this->addressStore = $addressStore;
        $this->blobObj = $blobObj;

        // creates the user table
        $sql = "CREATE TABLE IF NOT EXISTS user (" .
            "user_ID INTEGER PRIMARY KEY AUTOINCREMENT, " .
            "address_ID int(11) DEFAULT NULL, " .
            "type varchar(15) NOT NULL, " .
            "name varchar(50) DEFAULT NULL, " .
            "surname varchar(50) DEFAULT NULL, " .
            "password varchar(255) NOT NULL UNIQUE, " .
            "phone_number varchar(20) DEFAULT NULL, " .
            "email varchar(255) NOT NULL UNIQUE, " .
            "genre varchar(255) DEFAULT NULL, " .
            "members varchar(255) DEFAULT NULL, " .
            "other_remarks longtext DEFAULT NULL, " .
            "dsr varchar(1) NOT NULL, " .
            "FOREIGN KEY (address_ID) REFERENCES address(address_ID));";
        $db->exec($sql);
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * creates the data from the user given in
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function create(User $user): User
    {
        try {
            $this->db->beginTransaction();

            // checking if an entry already exist with the password an email
            $sql = "SELECT * FROM user WHERE email = '" . $user->getEmail() . "' OR password = '" . $user->getPassword() . "';";
            $stmt = $this->db->query($sql)->fetch();
            if ($stmt !== false) {
                throw new Exception("Email or Password invalid. Please try again.");
            }

            // if any address attribute is not empty
            if ($user->hasAddressInputs()) {
                $address_ID = $this->addressStore->create($user);
                $user->setAddressID($address_ID);
            }
            // inserting user data
            $this->preparedInsert($user);

            // gets inserted data
            $user = $this->findOne($this->db->lastInsertId());

            $this->db->commit();
            return $user;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * updates the data from the user given in
     * @param User $user
     * @return User
     */
    public function update(User $user): User
    {
        // updates address data
        $address_ID = $this->addressStore->update($user);
        $user->setAddressID($address_ID);

        // updating user data
        $this->preparedUpdate($user);

        // gets updated data
        return $this->findOne($user->getUserID());
    }

    /**
     * deletes the data from the user with the given id
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        // deletes user data
        $stmt = $this->db->prepare("DELETE FROM user WHERE user_ID=? RETURNING address_ID;");
        $stmt->execute([$id]);
        $stmt = $stmt->fetch();

        // deletes address data
        $this->addressStore->delete($stmt["address_ID"]);
    }

    /**
     * gets the data from the user with the given id
     * @param string $id
     * @return User
     */
    public function findOne(string $id): User
    {
        $sql = "SELECT * FROM user LEFT JOIN address ON user.address_ID = address.address_ID WHERE user_ID = " . $id . ";";
        $stmt = $this->db->query($sql)->fetch();
        return User::withAddress($stmt);
    }

    /**
     * gets the data from all users with the $stmt in any attribute
     * @param string $stmt
     * @return array
     * @throws Exception
     */
    public function findAny(string $stmt): array
    {
        $sql = "SELECT * FROM user ".
            "LEFT JOIN address ".
            "ON address.address_ID = user.address_ID ".
            "WHERE type = 'Musician' AND ".
            "name LIKE '%".$stmt."%' OR ".
            "surname LIKE '%".$stmt."%' OR ".
            "genre LIKE '%".$stmt."%' OR ".
            "members LIKE '%".$stmt."%' OR ".
            "other_remarks LIKE '%".$stmt."%';";
        return $this->createUserArray($sql);
    }

    /**
     * gets the data from all users
     * @throws Exception
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM user LEFT JOIN address ".
               "ON address.address_ID = user.address_ID ".
               "WHERE type = 'Musician';";
        return $this->createUserArray($sql);
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               custom methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param $email
     * @param $password
     * @return User
     * @throws Exception
     */
    public function login($email, $password): User
    {
        $sql = "SELECT * FROM user WHERE email = '" . $email . "';";
        $stmt = $this->db->query($sql)->fetch();

        // if email does not exist
        if ($stmt === false)
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');

        // if password is wrong
        if (!password_verify($password, $stmt["password"]))
            throw new Exception('<p id="loginError">Email or Password are not correct!</p>');

        // gets user data
        return $this->findOne($stmt["user_ID"]);
    }

    /**
     * @param User $user
     * @param $old_password
     * @param $new_password
     * @return User
     * @throws Exception
     */
    public function changePassword(User $user, $old_password, $new_password): User
    {
        try {
            $this->db->beginTransaction();

            // checking if new password already exist
            $sql = "SELECT password FROM user;";
            $stmt = $this->db->query($sql)->fetchAll();

            if ($stmt !== false) {
                foreach ($stmt as $password) {
                    if (password_verify($password["password"], $new_password)) {
                        throw new Exception("Something went wrong! try again.");
                    }
                }
            }

            // checking if user password is equal to typed in old password
            $sql = "SELECT password FROM user WHERE user_ID = '" . $user->getUserID() . "';";
            $stmt = $this->db->query($sql)->fetch();
            if (!password_verify($old_password, $stmt["password"]))
                throw new Exception("Old Password is incorrect.");

            $user->setPassword(password_hash($new_password, PASSWORD_DEFAULT));

            // updates user data
            return $this->update($user);
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                              private methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param string $sql
     * @return array
     * @throws Exception
     */
    private function createUserArray(string $sql): array
    {
        $stmt = $this->db->query($sql);
        $stmt = $stmt->fetchAll();

        $return = array();
        foreach ($stmt as $user) {
            $newUser = User::withAddress($user);

            try {
                $imageID = $this->blobObj->queryID($newUser->getUserID(), "profile_large");
                $image = $this->blobObj->findOne($imageID[0]["id"]);
                $newUser->setImage($image);
                $return[] = $newUser;
            } catch (RuntimeException) {
                $return[] = $newUser;
            }
        }
        return $return;
    }

    /**
     * method to update data into the database
     * @param User $user
     * @return void
     */
    private function preparedUpdate(User $user) : void
    {
        $sql = 'UPDATE user SET address_ID = :address_ID, type = :type, name = :name, surname = :surname, password = :password, phone_number = :phone_number, email = :email, genre = :genre, '.
            'members = :members, other_remarks = :other_remarks, dsr = :dsr WHERE user_ID = :user_ID';

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue('address_ID', $user->getAddressID());
        $stmt->bindValue('user_ID', $user->getUserID());
        $stmt->bindValue('type', $user->getType());
        $stmt->bindValue('name', $user->getName());
        $stmt->bindValue('surname', $user->getSurname());
        $stmt->bindValue('password', $user->getPassword());
        $stmt->bindValue('phone_number', $user->getPhoneNumber());
        $stmt->bindValue('email', $user->getEmail());
        $stmt->bindValue('genre', $user->getGenre());
        $stmt->bindValue('members', $user->getMembers());
        $stmt->bindValue('other_remarks', $user->getOtherRemarks());
        $stmt->bindValue('dsr', $user->getDsr());

        $stmt->execute();
    }

    /**
     * method to insert data into the database
     * @param User $user
     * @return void
     */
    private function preparedInsert(User $user) : void
    {
        if ($user->getAddressID() === "") {
            $sql = 'INSERT INTO user (type, name , surname, password, phone_number, email, genre, members, '.
                'other_remarks, dsr) VALUES (:type, :name , :surname, :password, :phone_number, :email, :genre, '.
                ':members, :other_remarks, :dsr)';
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = 'INSERT INTO user (address_ID, type, name , surname, password, phone_number, email, genre, '.
                'members, other_remarks, dsr) VALUES (:address_ID, :type, :name , :surname, :password, :phone_number, '.
                ':email, :genre, :members, :other_remarks, :dsr)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('address_ID', $user->getAddressID());
        }

        $stmt->bindValue('type', $user->getType());
        $stmt->bindValue('name', $user->getName());
        $stmt->bindValue('surname', $user->getSurname());
        $stmt->bindValue('password', $user->getPassword());
        $stmt->bindValue('phone_number', $user->getPhoneNumber());
        $stmt->bindValue('email', $user->getEmail());
        $stmt->bindValue('genre', $user->getGenre());
        $stmt->bindValue('members', $user->getMembers());
        $stmt->bindValue('other_remarks', $user->getOtherRemarks());
        $stmt->bindValue('dsr', $user->getDsr());

        $stmt->execute();
    }
}
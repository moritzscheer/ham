<?php
class user {
    private $user_ID;
    private $type_ID;
    private $address_ID;
    private $name;
    private $surname;
    private $password;
    private $phone_number;
    private $email;

    public function __construct($user_ID, $type_ID, $address_ID, $name, $surname, $password, $phone_number, $email) {
        $this->user_ID = $user_ID;
        $this->type_ID = $type_ID;
        $this->address_ID = $address_ID;
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->phone_number = $phone_number;
        $this->email = $email;
    }

    public function getUserID() {
        return $this->user_ID;
    }

    public function getType_ID() {
        return $this->type_ID;
    }

    public function getAddress_ID() {
        return $this->address_ID;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPhone_number() {
        return $this->phone_number;
    }

    public function getEmail() {
        return $this->email;
    }

}

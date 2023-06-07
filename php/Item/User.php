<?php

class User implements Item{

    private string $user_ID;
    private string $address_ID;
    private string $type;
    private string $name;
    private string $surname;
    private string $password;
    private string $phone_number;
    private string $email;
    private string $genre;
    private string $members;
    private string $other_remarks;

    public function __construct($address_ID, $type, $name, $surname, $password, $phone_number, $email, $genre, $members, $other_remarks) {
        $this->address_ID = $address_ID;
        $this->type = $type;
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->genre = $genre;
        $this->members = $members;
        $this->other_remarks = $other_remarks;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->user_ID;
    }

    /**
     * @param int $user_ID
     */
    public function setUserID(int $user_ID): void
    {
        $this->user_ID = $user_ID;
    }

    /**
     * @return string
     */
    public function getAddressID(): string
    {
        return $this->address_ID;
    }

    /**
     * @param string $address_ID
     */
    public function setAddressID(string $address_ID): void
    {
        $this->address_ID = $address_ID;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getMembers(): string
    {
        return $this->members;
    }

    /**
     * @param string $members
     */
    public function setMembers(string $members): void
    {
        $this->members = $members;
    }

    /**
     * @return string
     */
    public function getOtherRemarks(): string
    {
        return $this->other_remarks;
    }

    /**
     * @param string $other_remarks
     */
    public function setOtherRemarks(string $other_remarks): void
    {
        $this->other_remarks = $other_remarks;
    }

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->user_ID;
    }
}
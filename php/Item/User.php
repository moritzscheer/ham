<?php

class User {

    private int $user_ID;
    private ?string $address_ID;
    private ?string $type;
    private ?string $name;
    private ?string $surname;
    private ?string $password;
    private ?string $phone_number;
    private ?string $email;
    private ?string $genre;
    private ?string $members;
    private ?string $other_remarks;

    public function __construct() {
        $this->address_ID = "";
        $this->type = "";
        $this->name = "";
        $this->surname = "";
        $this->password = "";
        $this->phone_number = "";
        $this->email = "";
        $this->genre = "";
        $this->members = "";
        $this->other_remarks = "";
    }

    /**
     * 2nd constructor
     * @param $user
     * @return User
     */
    public static function withUserID($user): User {
        $instance = new self();
        $instance->user_ID = $user[0];
        $instance->address_ID = $user[1];
        $instance->type = $user[2];
        $instance->name = $user[3];
        $instance->surname = $user[4];
        $instance->password = $user[5];
        $instance->phone_number = $user[6];
        $instance->email = $user[7];
        $instance->genre = $user[8];
        $instance->members = $user[9];
        $instance->other_remarks = $user[10];
        return $instance;
    }

    /**
     * @return string
     */
    public function getUserID(): string
    {
        return $this->user_ID;
    }

    /**
     * @return string|null
     */
    public function getAddressID(): ?string
    {
        return $this->address_ID;
    }

    /**
     * @param string|null $address_ID
     */
    public function setAddressID(?string $address_ID): void
    {
        $this->address_ID = $address_ID;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    /**
     * @param string|null $phone_number
     */
    public function setPhoneNumber(?string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * @param string|null $genre
     */
    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return string|null
     */
    public function getMembers(): ?string
    {
        return $this->members;
    }

    /**
     * @param string|null $members
     */
    public function setMembers(?string $members): void
    {
        $this->members = $members;
    }

    /**
     * @return string|null
     */
    public function getOtherRemarks(): ?string
    {
        return $this->other_remarks;
    }

    /**
     * @param string|null $other_remarks
     */
    public function setOtherRemarks(?string $other_remarks): void
    {
        $this->other_remarks = $other_remarks;
    }
}
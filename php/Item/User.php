<?php

class User {

    private string $user_ID;
    private ?string $address_ID = null;
    private ?string $type = null;
    private ?string $name = null;
    private ?string $surname = null;
    private ?string $password = null;
    private ?string $phone_number = null;
    private ?string $email = null;
    private ?string $genre = null;
    private ?string $members = null;
    private ?string $other_remarks = null;

    public static function withUserID($user): User {
        $instance = new self();
        $instance->user_ID = $user->userID;
        $instance->address_ID = $user->address_ID;
        $instance->type = $user->type;
        $instance->name = $user->name;
        $instance->surname = $user->surname;
        $instance->password = $user->password;
        $instance->phone_number = $user->phone_number;
        $instance->email = $user->email;
        $instance->genre = $user->genre;
        $instance->members = $user->members;
        $instance->other_remarks = $user->other_remarks;
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
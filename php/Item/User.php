<?php

class User {

    // user attributes
    private int $user_ID;
    private ?string $address_ID = "";
    private ?string $type = "";
    private ?string $name = "";
    private ?string $surname = "";
    private ?string $password = "";
    private ?string $phone_number = "";
    private ?string $email = "";
    private ?string $genre = "";
    private ?string $members = "";
    private ?string $other_remarks = "";

    // address attributes
    private ?string $street_name = "";
    private ?string $house_number = "";
    private ?string $postal_code = "";
    private ?string $city = "";

    // small profile picture attributes
    private ?array $blobData = null;

    /**
     * constructor
     * @param $user
     * @return User
     */
    public static function withAddress($user): User {
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
        $instance->street_name = $user[12];
        $instance->house_number = $user[13];
        $instance->postal_code = $user[14];
        $instance->city = $user[15];
        return $instance;
    }

    public function getBandHTML(): string {
        return $string =
            '    <form method="post" name="event_ID" id="item">                                                    '.
            '        <div id="item_image">                                                                         '.
            '            <img src="' . $this->getImageSource() . '" alt="bandImage"/>                              '.
            '        </div>                                                                                        '.
            '        <div id="item_short_description" class="text-line-pre">                                       '.
            '            <span>' . $this->name . ' ' . $this->surname . '</span>                                   '.
            '            <br>                                                                                      '.
            '            <span>Genre: ' . $this->genre . '</span>                                                  '.
            '            <br>                                                                                      '.
            '            <span>Members: ' . $this->members . '</span>                                              '.
            '            <br>                                                                                      '.
            '            <span>other Remarks: ' . $this->other_remarks . '</span>                                  '.
            '            <br>                                                                                      '.
            '            <form method="post">                                                                      '.
            '                <label id="profile_Link">link to profile                                              '.
            '                    <input type="submit" name="viewProfile" value="' . $this->user_ID . '">           '.
            '                </label>                                                                              '.
            '            </form>                                                                                   '.
            '        </div>                                                                                        '.
            '    </form>                                                                                           ';
    }

    /**
     * @return string
     */
    public function printAddress(): string {
        if($this->street_name === "" && $this->house_number === "") {
            return $this->postal_code." ".$this->city;
        } else {
            return $this->street_name." ".$this->house_number.", ".$this->postal_code." ".$this->city;
        }
    }

    /**
     * @return string
     */
    public function getImageSource(): string {
        if(empty($this->blobData)) {
            return "../resources/images/profile/default/defaultLarge.jpeg";
        } else {
            return "data:".$this->blobData["mime"].";base64,".base64_encode($this->blobData["data"]);
        }
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               getter and setter                                                */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @return array|null
     */
    public function getBlobData(): ?array
    {
        return $this->blobData;
    }

    /**
     * @param array|null $blobData
     */
    public function setBlobData(?array $blobData): void
    {
        $this->blobData = $blobData;
    }

    /**
     * @return string|null
     */
    public function getStreetName(): ?string
    {
        return $this->street_name;
    }

    /**
     * @param string|null $street_name
     */
    public function setStreetName(?string $street_name): void
    {
        $this->street_name = $street_name;
    }

    /**
     * @return string|null
     */
    public function getHouseNumber(): ?string
    {
        return $this->house_number;
    }

    /**
     * @param string|null $house_number
     */
    public function setHouseNumber(?string $house_number): void
    {
        $this->house_number = $house_number;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    /**
     * @param string|null $postal_code
     */
    public function setPostalCode(?string $postal_code): void
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
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
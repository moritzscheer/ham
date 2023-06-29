<?php

namespace Item;
class User
{

    // user attributes
    private ?string $user_ID = "";
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
    public static function withAddress($user): User
    {
        $instance = new self();
        $instance->user_ID = (string)$user["user_ID"];
        $instance->address_ID = $user["address_ID"];
        $instance->type = $user["type"];
        $instance->name = $user["name"];
        $instance->surname = $user["surname"];
        $instance->password = $user["password"];
        $instance->phone_number = $user["phone_number"];
        $instance->email = $user["email"];
        $instance->genre = $user["genre"];
        $instance->members = $user["members"];
        $instance->other_remarks = $user["other_remarks"];
        $instance->street_name = $user["street_name"];
        $instance->house_number = $user["house_number"];
        $instance->postal_code = $user["postal_code"];
        $instance->city = $user["city"];
        return $instance;
    }

    public static function toArrayForJsonEntry(User $user): array
    {
        return array(
            "user_ID" => $user->getUserID(),
            "type" => $user->getType(),
            "name" => $user->getName(),
            "address_ID" => uniqid("user_", false),
            "surname" => $user->getSurname(),
            "password" => $user->getPassword(),
            "phone_number" => $user->getPhoneNumber(),
            "email" => $user->getEmail(),
            "genre" => $user->getGenre(),
            "members" => $user->getMembers(),
            "other_remarks" => $user->getOtherRemarks(),
            "profile_picture_small" => "",
            "profile_picture_large" => "",
            "profile_gallery" => array("..\/resources\/images\/bands\/band.jpg", "..\/resources\/images\/bands\/band.jpg"),
            "street_name" => $user->getStreetName(),
            "house_number" => $user->getHouseNumber(),
            "postal_code" => $user->getPostalCode(),
            "city" => $user->getCity()
        );
    }

    public static function getJsonUser($user): User
    {
        $instance = new self();
        $instance->user_ID = (string)$user->user_ID;
        $instance->type = $user->type;
        $instance->address_ID = $user->address_ID;
        $instance->name = $user->name;
        $instance->surname = $user->surname;
        $instance->password = $user->password;
        $instance->phone_number = $user->phone_number;
        $instance->email = $user->email;
        $instance->genre = $user->genre;
        $instance->members = $user->members;
        $instance->other_remarks = $user->other_remarks;
        $instance->street_name = $user->street_name;
        $instance->house_number = $user->house_number;
        $instance->postal_code = $user->postal_code;
        $instance->city = $user->city;

        return $instance;
    }

    public function getBandHTML(): string
    {
        return $string =
            '    <form method="post" name="event_ID" id="item">                                                    ' .
            '        <div id="item_image">                                                                         ' .
            '            <img src="' . $this->getImageSource() . '" alt="bandImage"/>                              ' .
            '        </div>                                                                                        ' .
            '        <div id="item_short_description" class="text-line-pre">                                       ' .
            '            <span>' . $this->name . ' ' . $this->surname . '</span>                                   ' .
            '            <br>                                                                                      ' .
            '            <span>Genre: ' . $this->genre . '</span>                                                  ' .
            '            <br>                                                                                      ' .
            '            <span>Members: ' . $this->members . '</span>                                              ' .
            '            <br>                                                                                      ' .
            '            <span>other Remarks: ' . $this->other_remarks . '</span>                                  ' .
            '            <br>                                                                                      ' .
            '            <form method="post">                                                                      ' .
            '                <label id="profile_Link">link to profile                                              ' .
            '                    <input type="submit" name="viewProfile" value="' . $this->user_ID . '">           ' .
            '                </label>                                                                              ' .
            '            </form>                                                                                   ' .
            '        </div>                                                                                        ' .
            '    </form>                                                                                           ';
    }

    /**
     * @return string
     */
    public function getImageSource(): string
    {
        if (empty($this->blobData)) {
            return "../resources/images/profile/default/defaultLarge.jpeg";
        } else {
            return "data:" . $this->blobData["mime"] . ";base64," . base64_encode($this->blobData["data"]);
        }
    }

    /**
     * returns a String containing all attributes of the user class defined in user Table that are not null.
     * The String is formatted according to the $schema variable
     * @param $keyOrValue
     * @param $schema
     * @return String
     */
    public function getAttributes($keyOrValue, $schema): string
    {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key !== "street_name" && $key !== "house_number" && $key !== "postal_code" && $key !== "city" && $key !== "blobData") {
                $result = $this->concatString($result, $key, $value, $keyOrValue, $schema);
            }
        }
        return $result;
    }

    /**
     * returns a String containing all attributes of the user class defined in address Table that are not null.
     * The String is formatted according to the $schema variable
     * @param $keyOrValue
     * @param $schema
     * @return String
     */
    public function getAddressAttributes($keyOrValue, $schema): string
    {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key === "street_name" || $key === "house_number" || $key === "postal_code" || $key === "city") {
                $result = $this->concatString($result, $key, $value, $keyOrValue, $schema);
            }
        }
        return $result;
    }

    /**
     * @param $result
     * @param $value
     * @param $keyOrValue
     * @param $schema
     * @return string
     */
    private function concatString($result, $key, $value, $keyOrValue, $schema): string
    {
        $attr = $keyOrValue === "value" ? $value : ($keyOrValue === "valueWithApo" ? "'" . $value . "'" : $key);

        if ($schema === "list") {
            if ($value !== null && $value !== "") {
                if ($result === "") {
                    $result = $attr;
                } else {
                    $result = $result . ", " . $attr;
                }
            }
        } elseif ($schema === "set") {
            if ($result === "") {
                $result = $key . " = '" . $value . "'";
            } else {
                $result = $result . ", " . $key . " = '" . $value . "'";
            }
        }

        return $result;
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
     * @param string|null $id
     * @return void
     */
    public function setUserID(?string $id): void
    {
        $this->user_ID = $id;
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
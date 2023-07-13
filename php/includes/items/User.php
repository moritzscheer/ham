<?php

namespace Item;

class User extends Item {

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
    private ?string $dsr = "";

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
        $instance->dsr = $user["dsr"];
        $instance->street_name = $user["street_name"];
        $instance->house_number = $user["house_number"];
        $instance->postal_code = $user["postal_code"];
        $instance->city = $user["city"];
        return $instance;
    }

    public static function toArrayForJsonEntry(User $user): array {
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
            "dsr" => $user->getDsr(),
            "profile_picture_small" => "",
            "profile_picture_large" => "",
            "profile_gallery" => array("..\/resources\/images\/bands\/band.jpg", "..\/resources\/images\/bands\/band.jpg"),
            "street_name" => $user->getStreetName(),
            "house_number" => $user->getHouseNumber(),
            "postal_code" => $user->getPostalCode(),
            "city" => $user->getCity()
        );
    }

    public static function getJsonUser($user): User {
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
        $instance->dsr = $user->dsr;
        $instance->street_name = $user->street_name;
        $instance->house_number = $user->house_number;
        $instance->postal_code = $user->postal_code;
        $instance->city = $user->city;

        return $instance;
    }

    public function getBandHTML(): string {
        return '<form method="post" name="event_ID" id="item">                                                    ' .
            '       <div id="item_image">                                                                         ' .
            '           <img src="' . $this->getImageSource() . '" alt="bandImage"/>                              ' .
            '       </div>                                                                                        ' .
            '       <div id="item_short_description" class="text-line-pre">                                       ' .
            '           <span>' . $this->getName() . ' ' . $this->getSurname() . '</span>                         ' .
            '           <br>                                                                                      ' .
            '           <span>Genre: ' . $this->getGenre() . '</span>                                             ' .
            '           <br>                                                                                      ' .
            '           <span>Members:<br>' . $this->getMembers() . '</span>                                      ' .
            '           <br>                                                                                      ' .
            '           <span>Other Remarks:<br>' . $this->getOtherRemarks() . '</span>                           ' .
            '           <br>                                                                                      ' .
            '           <form method="post">                                                                      ' .
            '               <label id="profile_Link">link to profile                                              ' .
            '                   <input type="submit" name="viewProfile" value="' . $this->user_ID . '">           ' .
            '               </label>                                                                              ' .
            '           </form>                                                                                   ' .
            '       </div>                                                                                        ' .
            '   </form>                                                                                           ';
    }

    /**
     * @param $keyOrValue
     * @param $withApostroph
     * @return string
     */
    public function getUserAttributesAsList($keyOrValue, $withApostroph): string {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key !== "street_name" && $key !== "house_number" && $key !== "postal_code" && $key !== "city" && $key !== "blobData") {
                $result = $this->concatList($result, $key, $value, $keyOrValue, $withApostroph);
            }
        }
        return $result;
    }

    /**
     * @param $separator
     * @return string
     */
    public function getUserAttributesAsSet($separator): string {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key !== "street_name" && $key !== "house_number" && $key !== "postal_code" && $key !== "city" && $key !== "blobData") {
                $result = $this->concatSet($result, $key, $value, $separator);
            }
        }
        return $result;
    }

    /**
     * @param $keyOrValue
     * @param $withApostroph
     * @return string
     */
    public function getAddressAttributesAsList($keyOrValue, $withApostroph): string {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key === "street_name" || $key === "house_number" || $key === "postal_code" || $key === "city") {
                $result = $this->concatList($result, $key, $value, $keyOrValue, $withApostroph);
            }
        }
        return $result;
    }

    /**
     * @param $separator
     * @return string
     */
    public function getAddressAttributesAsSet($separator): string {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key === "street_name" || $key === "house_number" || $key === "postal_code" || $key === "city") {
                $result = parent::concatSet($result, $key, $value, $separator);
            }
        }
        return $result;
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               getter and setter                                                */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @return string
     */
    public function getImageSource(): string {
        if (empty($this->blobData)) {
            return htmlspecialchars("../resources/images/profile/default/defaultLarge.jpeg");
        } else {
            return htmlspecialchars("data:" . $this->blobData["mime"] . ";base64," . base64_encode($this->blobData["data"]));
        }
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
        return htmlspecialchars($this->address_ID);
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
        return htmlspecialchars($this->type);
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
        return htmlspecialchars($this->name);
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
        return htmlspecialchars($this->surname);
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
        return htmlspecialchars($this->password);
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
        return htmlspecialchars($this->phone_number);
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
        return htmlspecialchars($this->email);
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
        return htmlspecialchars($this->genre);
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
        return htmlspecialchars($this->members);
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
        return htmlspecialchars($this->other_remarks);
    }

    /**
     * @param string|null $other_remarks
     */
    public function setOtherRemarks(?string $other_remarks): void
    {
        $this->other_remarks = $other_remarks;
    }

    /**
     * @return string|null
     */
    public function getStreetName(): ?string
    {
        return htmlspecialchars($this->street_name);
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
        return htmlspecialchars($this->house_number);
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
        return htmlspecialchars($this->postal_code);
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
        return htmlspecialchars($this->city);
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return htmlspecialchars($this->getAddressAttributesAsList("value", false));
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
    public function getDsr(): ?string
    {
        return $this->dsr;
    }

    /**
     * @return string|null
     */
    public function getDsrCheckBox(): ?string
    {
        if($this->dsr === "y") {
            return "checked";
        } else {
            return "";
        }
    }

    /**
     * @param string|null $dsr
     */
    public function setDsr(?string $dsr): void
    {
        $this->dsr = $dsr;
    }
}
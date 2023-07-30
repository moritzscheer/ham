<?php

namespace php\includes\items;

use stdClass;

/**
 * This class defines a User and is transferred from the stores to the controller and other way around.
 */
class User extends Item {

    /* -------- User attributes -------- */

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

    /* -------- Address attributes -------- */

    private ?string $street_name = "";
    private ?string $house_number = "";
    private ?string $postal_code = "";
    private ?string $city = "";

    /* -------- Image attribute -------- */

    private ?string $image = "../resources/images/profile/default/defaultLarge.jpeg";

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                                 constructors                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * constructor
     * @param array $user
     * @return User
     */
    public static function withAddress(array $user): User
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
        $instance->dsr = $user["dsr"];
        $instance->street_name = $user["street_name"];
        $instance->house_number = $user["house_number"];
        $instance->postal_code = $user["postal_code"];
        $instance->city = $user["city"];
        return $instance;
    }

    /**
     * @param stdClass $user
     * @param stdClass|null $address
     * @return User
     */
    public static function stdClassToUser(stdClass $user, ?stdClass $address): User
    {
        $instance = new self();
        $instance->user_ID = $user->user_ID;
        $instance->type = $user->type;
        $instance->name = $user->name;
        $instance->surname = $user->surname;
        $instance->password = $user->password;
        $instance->phone_number = $user->phone_number;
        $instance->email = $user->email;
        $instance->genre = $user->genre;
        $instance->members = $user->members;
        $instance->other_remarks = $user->other_remarks;
        $instance->dsr = $user->dsr;
        if ($address !== NULL) {
            $instance->address_ID = $user->address_ID;
            $instance->street_name = $address->street_name;
            $instance->house_number = $address->house_number;
            $instance->postal_code = $address->postal_code;
            $instance->city = $address->city;
        }
        return $instance;
    }


    /**
     * @param User $user
     * @return array
     */
    public static function UserToArray(User $user): array
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

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @return string
     */
    public function getBandHTML(): string {
        return '<form method="post" name="event_ID" id="item">                                                    ' .
            '       <div id="item_image">                                                                         ' .
            '           <img src="' . $this->image . '" alt="bandImage"/>                                         ' .
            '       </div>                                                                                        ' .
            '       <div id="item_short_description" class="text-line-pre user">                                  ' .
            '           <span>' . $this->getName() . ' ' . $this->getSurname() . '</span>                         ' .
            '           <br>                                                                                      ' .
            '           <span>Genre: ' . $this->getGenre() . '</span>                                             ' .
            '           <br>                                                                                      ' .
            '           <span>Members:</span>                                                                     ' .
            '           <p>' . $this->getMembers() . '</p>                                                        ' .
            '           <br>                                                                                      ' .
            '           <span>Other Remarks:</span>                                                               ' .
            '           <p>' . $this->getOtherRemarks() . '</p>                                                   ' .
            '           <br>                                                                                      ' .
            '           <form method="post">                                                                      ' .
            '               <label id="profile_Link">link to profile                                              ' .
            '                   <input type="submit" name="viewProfile" value="' . $this->user_ID . '">           ' .
            '               </label>                                                                              ' .
            '           </form>                                                                                   ' .
            '       </div>                                                                                        ' .
            '   </form>                                                                                           ' ;
    }

    /**
     * @param $keyOrValue
     * @param $withApostroph
     * @return string
     */
    public function getUserAttributesAsList($keyOrValue, $withApostroph): string {
        $str = "";
        foreach ($this as $key => $value) {
            if ($key !== "street_name" && $key !== "house_number" && $key !== "postal_code" && $key !== "city" && $key !== "image" && $key !== "distance") {
                $str = $this->concatList($str, $key, $value, $keyOrValue, $withApostroph);
            }
        }
        return $str;
    }

    /**
     * @param $separator
     * @return string
     */
    public function getUserAttributesAsSet($separator): string {
        $str = "";
        foreach ($this as $key => $value) {
            if ($key !== "street_name" && $key !== "house_number" && $key !== "postal_code" && $key !== "city" && $key !== "image" && $key !== "distance") {
                $str = $this->concatSet($str, $key, $value, $separator);
            }
        }
        return $str;
    }

    /**
     * @param $keyOrValue
     * @param $withApostroph
     * @return string
     */
    public function getAddressAttributesAsList($keyOrValue, $withApostroph): string {
        $str = "";
        foreach ($this as $key => $value) {
            if ($key === "street_name" || $key === "house_number" || $key === "postal_code" || $key === "city") {
                $str = $this->concatList($str, $key, $value, $keyOrValue, $withApostroph);
            }
        }
        return $str;
    }

    /**
     * @param $separator
     * @return string
     */
    public function getAddressAttributesAsSet($separator): string {
        $str = "";
        foreach ($this as $key => $value) {
            if ($key === "street_name" || $key === "house_number" || $key === "postal_code" || $key === "city") {
                $str = parent::concatSet($str, $key, $value, $separator);
            }
        }
        return $str;
    }

    /**
     * @return bool
     */
    public function hasAddressInputs() : bool {
        if ($this->street_name == "" &&
            $this->house_number == "" &&
            $this->postal_code == "" &&
            $this->city == "") {
            return false;
        } else {
            return true;
        }
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               combined getters                                                 */
    /* -------------------------------------------------------------------------------------------------------------- */

    /* -------- Address output -------- */

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return htmlspecialchars($this->getAddressAttributesAsList("value", false));
    }

    /* -------- Dsr checkbox output -------- */

    /**
     * @return string|null
     */
    public function getDsrCheckBox(): ?string
    {
        if ($this->dsr === "y") {
            return "checked";
        } else {
            return "";
        }
    }

    /**
     * @return string|null
     */
    public function getHostCheckBox(): ?string
    {
        if ($this->type === "Host") {
            return "checked";
        } else {
            return "";
        }
    }

    /**
     * @return string|null
     */
    public function getMusicianCheckBox(): ?string
    {
        if ($this->type === "Musician") {
            return "checked";
        } else {
            return "";
        }
    }

    /**
     * @return array
     */
    public function getJsonUser(): array {
        return array(
            "user_ID" => $this->user_ID,
            "address_ID" => $this->address_ID,
            "type" => $this->type,
            "name" => $this->name,
            "surname" => $this->surname,
            "password" => $this->password,
            "phone_number" => $this->phone_number,
            "email" => $this->email,
            "genre" => $this->genre,
            "members" => $this->members,
            "other_remarks" => $this->other_remarks,
            "dsr" => $this->dsr,
        );
    }

    /**
     * @return array
     */
    public function getJsonAddress(): array {
        return array(
            "address_ID" => $this->address_ID,
            "street_name" => $this->street_name,
            "house_number" => $this->house_number,
            "postal_code" => $this->postal_code,
            "city" => $this->city,
        );
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               getter and setter                                                */
    /* -------------------------------------------------------------------------------------------------------------- */

    /* -------- User ID attribute -------- */

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

    /* -------- Address ID attribute -------- */

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

    /* -------- Type attribute -------- */

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

    /* -------- Name attribute -------- */

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

    /* -------- Surname attribute -------- */

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

    /* -------- Password attribute -------- */

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

    /* -------- Phone Number attribute -------- */

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

    /* -------- E-Mail attribute -------- */

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

    /* -------- Genre attribute -------- */

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

    /* -------- Members attribute -------- */

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

    /* -------- Other Remarks attribute -------- */

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

    /* -------- Street Name attribute -------- */

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

    /* -------- House Number attribute -------- */

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

    /* -------- Postal Code attribute -------- */

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

    /* -------- City attribute -------- */

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

    /* -------- Image attribute -------- */

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return htmlspecialchars($this->image);
    }

    /* -------- Dsr attribute -------- */

    /**
     * @return string|null
     */
    public function getDsr(): ?string
    {
        return $this->dsr;
    }

    /**
     * @param string|null $dsr
     */
    public function setDsr(?string $dsr): void
    {
        $this->dsr = $dsr;
    }
}
<?php
include_once "Item.php";

class Event
{

    // event attributes
    private int $event_ID;
    private ?string $address_ID = "";
    private ?string $user_ID = "";
    private ?string $name = "";
    private ?string $description = "";
    private ?string $requirements = "";
    private ?string $date = "";
    private ?string $startTime = "";
    private ?string $endTime = "";

    // address attributes
    private ?string $street_name = "";
    private ?string $house_number = "";
    private ?string $postal_code = "";
    private ?string $city = "";

    // image attributes
    private ?array $blobData = null;

    /**
     * @param array $item
     * @return Event
     */
    public static function withAddress(array $item): Event
    {
        $instance = new self();
        $instance->event_ID = $item[0];
        $instance->address_ID = $item[1];
        $instance->user_ID = $item[2];
        $instance->name = $item[3];
        $instance->description = $item[4];
        $instance->requirements = $item[5];
        $instance->date = $item[6];
        $instance->startTime = $item[7];
        $instance->endTime = $item[8];
        $instance->street_name = $item[9];
        $instance->house_number = $item[10];
        $instance->postal_code = $item[11];
        $instance->city = $item[12];
        return $instance;
    }

    public static function getJsonEvent(array $item) : Event
    {
        $instance = new self();
        $instance->event_ID = $item->id;
        $instance->address_ID = $item->address_ID;
        $instance->user_ID = $item->authorID;
        $instance->name = $item->name;
        $instance->description = $item->description;
        $instance->requirements = $item->requirements;
        $instance->date = $item->Date;
        $instance->startTime = $item->startTime;
        $instance->endTime = $item->endTime;
        $instance->street_name = $item->street;
        $instance->house_number = $item->houseNr;
        $instance->postal_code = $item->postalCode;
        $instance->city = $item->city;
        return $instance;
    }

    public function getEventHTML(): string
    {
        return $string =
            '    <form method="post" name="event_ID" id="item">                                                    ' .
            '        <div id="item_image">                                                                                         ' .
            '            <img src="' . $this->getImageSource() . '" alt="bandImage"/>              ' .
            '        </div>                                                                                        ' .
            '        <div id="item_short_description" class="text-line-pre">                                             ' .
            '            <span>' . $this->name . '</span>                                                          ' .
            '            <br>                                                                                      ' .
            '            <span>Address: ' . $this->printAddress() . '</span>                                         ' .
            '            <br>                                                                                      ' .
            '            <span> ' . $this->getTime() . '</span>                                                    ' .
            '        </div>                                                                                        ' .
            '        <label>click to display more / less                                                           ' .
            '             <input type="submit" name="onItemClick" value="' . $this->event_ID . '">                 ' .
            '        </label>                                                                                      ' .
            '    </form>                                                                                           ';
    }

    /**
     * @return string
     */
    public function getImageSource(): string
    {
        if (empty($this->blobData)) {
            return "../resources/images/events/event.jpg";
        } else {
            return "data:" . $this->blobData["mime"] . ";base64," . base64_encode($this->blobData["data"]);
        }
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->startTime . " - " . $this->endTime;
    }

    /**
     * @return string
     */
    public function printAddress(): string
    {
        if ($this->street_name === "" && $this->house_number === "") {
            return $this->postal_code . " " . $this->city;
        } else {
            return $this->street_name . " " . $this->house_number . ", " . $this->postal_code . " " . $this->city;

        }
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               getter and setter                                                */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param int $user_ID
     */
    public function setUserID(int $user_ID): void
    {
        $this->user_ID = $user_ID;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->user_ID;
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getRequirements(): ?string
    {
        return $this->requirements;
    }

    /**
     * @param string|null $requirements
     */
    public function setRequirements(?string $requirements): void
    {
        $this->requirements = $requirements;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string|null
     */
    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    /**
     * @param string|null $startTime
     */
    public function setStartTime(?string $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return string|null
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    /**
     * @param string|null $endTime
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime = $endTime;
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
     * @return int
     */
    public function getEventID(): int
    {
        return $this->event_ID;
    }


}
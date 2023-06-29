<?php

namespace Item;
class Event
{

    // event attributes
    private ?int $event_ID = null;
    private ?string $address_ID = "";
    private ?int $user_ID = null;
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
        $instance->event_ID = $item["event_ID"];
        $instance->address_ID = $item["address_ID"];
        $instance->user_ID = $item["user_ID"];
        $instance->name = $item["name"];
        $instance->description = $item["description"];
        $instance->requirements = $item["requirements"];
        $instance->date = $item["date"];
        $instance->startTime = $item["startTime"];
        $instance->endTime = $item["endTime"];
        $instance->street_name = $item["street_name"];
        $instance->house_number = $item["house_number"];
        $instance->postal_code = $item["postal_code"];
        $instance->city = $item["city"];
        return $instance;
    }

    public static function getJsonEvent($item): Event
    {
        $instance = new self();
        $instance->event_ID = (int)$item->id;
        $instance->address_ID = $item->address_ID;
        $instance->user_ID = (int)$item->authorID;
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

    public static function toArrayForJsonEntry(Event $item): array
    {
        $jsonEvent = array(
            "image" => $item->getImageSource(),
            "id" => uniqid('ev_'),
            "authorID" => $item->getUserID(),
            "type" => "event",
            "description" => $item->getDescription(),
            "name" => $item->getName(),
            "address_ID" => $item->getAddressID(),
            "street" => $item->getStreetName(),
            "houseNr" => $item->getHouseNumber(),
            "postalCode" => $item->getPostalCode(),
            "city" => $item->getCity(),
            "Date" => $item->getDate(),
            "startTime" => $item->getStartTime(),
            "endTime" => $item->getEndTime(),
            "requirements" => $item->getRequirements()
        );
        return $jsonEvent;
    }

    public function getEventHTML(): string
    {
        return $string =
            '    <form method="post" name="event_ID" id="item">                                                    ' .
            '        <div id="item_image">                                                                         ' .
            '            <img src="' . $this->getImageSource() . '" alt="bandImage"/>                              ' .
            '        </div>                                                                                        ' .
            '        <div id="item_short_description" class="text-line-pre">                                       ' .
            '            <span>' . $this->name . '</span>                                                          ' .
            '            <br>                                                                                      ' .
            '            <span>Item\Address: ' . $this->getAddressAttributes("value", "list") . '</span>   ' .
            '            <br>                                                                                      ' .
            '            <span> ' . $this->getTime() . '</span>                                                    ' .
            '        </div>                                                                                        ' .
            '        <label>click to display more / less                                                           ' .
            '             <input type="submit" name="onItemClick" value="' . $this->event_ID . '">                 ' .
            '        </label>                                                                                      ' .
            '    </form>                                                                                           ';
    }

    //todo: fix line 120 to 127 with ajax ?
    public function getEditableEventHTML(): string
    {
        return $string =
            '    <form method="post" name="event_ID" id="item">                                                    ' .
            '        <div id="item_image">                                                                         ' .
            '            <img src="' . $this->getImageSource() . '" alt="bandImage"/>                              ' .
            '        </div>                                                                                        ' .
            '        <div id="item_editable">                                                                      ' .
            '             <label>Edit                                                                              ' .
            '                   <a href="createEvent.php"  name="onEdit" ></a>                                     ' .
            '                   <input type="submit" name="onEdit" value="' . $this->event_ID . '">                ' .
            '             </label>                                                                                 ' .
            '             <label>Delete                                                                            ' .
            '                   <a href="events.php"  name="onDelete" ></a>                                        ' .
            '                   <input type="submit" name="onDelete" value="' . $this->event_ID . '">              ' .
            '              </label>                                                                                ' .
            '        </div>                                                                                        ' .
            '        <div id="item_short_description" class="text-line-pre">                                       ' .
            '            <span>' . $this->name . '</span>                                                          ' .
            '            <br>                                                                                      ' .
            '            <span>Item\Address: ' . $this->getAddressAttributes("value", "list") . '</span>   ' .
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
     * @return int|null
     */
    public function getEventID(): ?int
    {
        return $this->event_ID;
    }


}
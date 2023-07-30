<?php

namespace php\includes\items;

use stdClass;

/**
 * This class defines an Event and is transferred from the stores to the controller and other way around.
 */
class Event extends Item {

    /* -------- Event attributes -------- */

    private ?string $event_ID = null;
    private ?string $address_ID = "";
    private ?string $user_ID = null;
    private ?string $name = "";
    private ?string $description = "";
    private ?string $requirements = "";
    private ?string $date = "";
    private ?string $startTime = "";
    private ?string $endTime = "";

    /* -------- Address attributes -------- */

    private ?string $street_name = "";
    private ?string $house_number = "";
    private ?string $postal_code = "";
    private ?string $city = "";

    /* -------- Image attribute -------- */

    private ?string $image = "../resources/images/events/event1.jpg";

    /* -------- distance from marker attribute -------- */

    private ?float $distance = 0;

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                                 constructors                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param array $item
     * @return Event
     */
    public static function create(array $item): Event
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

    /**
     * @param stdClass $event
     * @param stdClass|null $address
     * @return Event
     */
    public static function stdClassToEvent(stdClass $event, ?stdClass $address): Event
    {
        $instance = new self();
        $instance->event_ID = $event->event_ID;
        $instance->user_ID = $event->user_ID;
        $instance->name = $event->name;
        $instance->description = $event->description;
        $instance->requirements = $event->requirements;
        $instance->date = $event->date;
        $instance->startTime = $event->startTime;
        $instance->endTime = $event->endTime;
        if ($address !== NULL) {
            $instance->address_ID = $event->address_ID;
            $instance->street_name = $address->street_name;
            $instance->house_number = $address->house_number;
            $instance->postal_code = $address->postal_code;
            $instance->city = $address->city;
        }
        return $instance;
    }

    /**
     * @param Event $item
     * @return array
     */
    public static function EventToArray(Event $item): array
    {
        return array(
            "event_ID" => $item->getEventID(),
            "address_ID" => $item->getAddressID(),
            "user_ID" => $item->getUserID(),
            "name" => $item->getName(),
            "description" => $item->getDescription(),
            "requirements" => $item->getRequirements(),
            "date" => $item->getDate(),
            "startTime" => $item->getStartTime(),
            "endTime" => $item->getEndTime(),
            "street_name" => $item->getStreetName(),
            "house_number" => $item->getHouseNumber(),
            "postal_code" => $item->getPostalCode(),
            "city" => $item->getCity(),
            "image" => $item->getImage(),
            "distance" => $item->getDistance()
        );
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*                                               public methods                                                   */
    /* -------------------------------------------------------------------------------------------------------------- */

    /**
     * @param $isEditable
     * @return string
     */
    public function getEventHTML($isEditable, $isCloseToMe): string {
        $html =
            '<form method="post" id="item">                                                                ' .
            '    <div id="item_image">                                                                     ' .
            '       <img src="' . $this->image . '" alt="bandImage"/>                                      ' .
            '    </div>                                                                                    ' ;
        if ($isEditable)
            $html .=
                '<div id="item_editable">                                                                  ' .
                '    <label>Edit                                                                           ' .
                '    <input type="hidden" name="token" value="'. $_SESSION["token"] . '">                  ' .
                '        <a href="createEvent.php"  name="onEdit" ></a>                                    ' .
                '        <input type="submit" name="onEdit" value="' . $this->event_ID . '">               ' .
                '    </label>                                                                              ' .
                '    <label>Delete                                                                         ' .
                '        <a href="events.php"  name="onDelete" ></a>                                       ' .
                '        <input type="submit" name="onDelete" value="' . $this->event_ID . '">             ' .
                '    </label>                                                                              ' .
                '</div>                                                                                    ' ;
        if ($isCloseToMe)
            $html .=
                '<input type="hidden" name="init" value="false">                                           ' ;
        $html .=
            '    <div id="item_short_description" class="text-line-pre event">                             ' .
            '        <span>' . $this->name . '</span>                                                      ' .
            '        <br>                                                                                  ' .
            '        <span>Address: ' . $this->getAddress() . '</span>                                     ' .
            '        <br>                                                                                  ' .
            '        <span>Date: ' . $this->getDate() . '</span>                                           ' .
            '        <br>                                                                                  ' .
            '        <span>Time: ' . $this->getTime() . '</span>                                           ' .
            '    </div>                                                                                    ' .
            '    <label>click to display more / less                                                       ' .
            '        <input type="submit" name="onItemClick" value="' . $this->event_ID . '">              ' .
            '    </label>                                                                                  ' .
            '</form>                                                                                       ' ;
        return $html;
    }


    /**
     * @param $keyOrValue
     * @param $withApostroph
     * @return string
     */
    public function getEventAttributesAsList($keyOrValue, $withApostroph): string {
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
    public function getEventAttributesAsSet($separator): string {
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

    /* -------- Time attribute -------- */

    /**
     * @return string
     */
    public function getTime(): string
    {
        return htmlspecialchars($this->startTime . " - " . $this->endTime);
    }

    /**
     * @return array
     */
    public function getJsonEvent(): array {
        return array(
            "event_ID" => $this->event_ID,
            "address_ID" => $this->address_ID,
            "user_ID" => $this->user_ID,
            "name" => $this->name,
            "description" => $this->description,
            "requirements" => $this->requirements,
            "date" => $this->date,
            "startTime" => $this->startTime,
            "endTime" => $this->endTime,
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

    /* -------- Event ID attribute -------- */

    /**
     * @return string|null
     */
    public function getEventID(): ?string
    {
        return $this->event_ID;
    }

    /**
     * @param string|null $event_ID
     */
    public function setEventID(?string $event_ID): void
    {
        $this->event_ID = $event_ID;
    }

    /* -------- Address ID attribute -------- */

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

    /* -------- User ID attribute -------- */

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return htmlspecialchars($this->user_ID);
    }

    /**
     * @param int $user_ID
     */
    public function setUserID(int $user_ID): void
    {
        $this->user_ID = $user_ID;
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

    /* -------- Description attribute -------- */

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return htmlspecialchars($this->description);
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /* -------- Requirement attribute -------- */

    /**
     * @return string|null
     */
    public function getRequirements(): ?string
    {
        return htmlspecialchars($this->requirements);
    }

    /**
     * @param string|null $requirements
     */
    public function setRequirements(?string $requirements): void
    {
        $this->requirements = $requirements;
    }

    /* -------- Date attribute -------- */

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return htmlspecialchars($this->date);
    }

    /**
     * @param string|null $date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    /* -------- Start Time attribute -------- */

    /**
     * @return string|null
     */
    public function getStartTime(): ?string
    {
        return htmlspecialchars($this->startTime);
    }

    /**
     * @param string|null $startTime
     */
    public function setStartTime(?string $startTime): void
    {
        $this->startTime = $startTime;
    }

    /* -------- End Time attribute -------- */

    /**
     * @return string|null
     */
    public function getEndTime(): ?string
    {
        return htmlspecialchars($this->endTime);
    }

    /**
     * @param string|null $endTime
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime = $endTime;
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
        return $this->image;
    }

    /* -------- Distance attribute -------- */

    /**
     * @return float|null
     */
    public function getDistance(): ?float
    {
        return $this->distance;
    }

    /**
     * @param float|null $distance
     */
    public function setDistance(?float $distance): void
    {
        $this->distance = $distance;
    }
}
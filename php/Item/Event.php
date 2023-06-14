<?php
include_once "Item.php";
class Event
{
    // event attributes
    private int $event_ID;
    private ?string $address_ID;
    private ?string $name;
    private ?string $description;
    private ?string $requirements;
    private ?string $date;
    private ?string $startTime;
    private ?string $endTime;

    // address attributes
    private ?string $street_name;
    private ?string $house_number;
    private ?string $postal_code;
    private ?string $city;

    // image attributes
    private ?array $blobData;






    /**
     * constructor
     */
    public function __construct()
    {
        $this->address_ID = "";
        $this->name = "";
        $this->description = "";
        $this->requirements = "";
        $this->date = "";
        $this->startTime = "";
        $this->endTime = "";
        $this->street_name = "";
        $this->house_number = "";
        $this->postal_code = "";
        $this->city = "";
        $this->blobData = null;
    }



    /**
     * @param object $item
     * @return void
     */
    public static function withoutAddress(array $item) : Event
    {
        $instance = new self();
        $instance->event_ID = $item[0];
        $instance->address_ID = $item[1];
        $instance->name = $item[2];
        $instance->description = $item[3];
        $instance->requirements = $item[4];
        $instance->date = $item[5];
        $instance->startTime = $item[6];
        $instance->endTime = $item[7];
        return $instance;
    }

    public static function withAddress(array $item) : Event
    {
        $instance = new self();
        $instance->event_ID = $item[0];
        $instance->address_ID = $item[1];
        $instance->name = $item[2];
        $instance->description = $item[3];
        $instance->requirements = $item[4];
        $instance->date = $item[5];
        $instance->startTime = $item[6];
        $instance->endTime = $item[7];
        $instance->street_name = $item[8];
        $instance->house_number = $item[9];
        $instance->postal_code = $item[10];
        $instance->city = $item[11];
        return $instance;
    }

    public function getEventHTML(): string
    {                                   
        $address = $this->street_name." ".$this->house_number."\n".$this->postal_code." ".$this->city;
        $time = $this->startTime." - ".$this->endTime;

        return $string =
       '<section id="item-list">                                                                              '.
       '    <div id="item">                                                                                   '.
       '        <label class="item-head">                                                                     '.
       '            <img id="item-image" src="' . $this->getImageSource() . '" alt="bandImage"/>              '.
       '            <div id="item-description" class="text-line-pre">                                         '.
       '                <span>' . $this->name . '</span>                                                      '.
       '                <br>                                                                                  '.
       '                <span>Address: ' . $address . '</span>                                                '.
       '                <br>                                                                                  '.
       '                <span> ' . $time . '</span>                                                           '.
       '                <input type="checkbox" id="item-click">                                               '.
       '            </div>                                                                                    '.
       '        </label>                                                                                      '.
       '        <div id="item-m-details">                                                                     '.
       '            <div id="item-details-title">                                                             '.
       '                <img id="item-image" src="' . $this->getImageSource() . '" alt="bandImage"/>          '.
       '                <h2 id="item-details-name"> ' . $this->name . ' </h2>                                 '.
       '            </div>                                                                                    '.
       '            <div class="item-details-description">                                                    '.
       '                <p>' . $this->description . '</p>                                                     '.
       '            </div>                                                                                    '.
       '            <div id="item-details-foot">                                                              '.
       '                <p class="text-line-pre">                                                             '.
       '                    Requirements <br>                                                                 '.
       '                    ' . $this->requirements . '                                                       '.
       '                </p>                                                                                  '.
       '            </div>                                                                                    '.
       '        </div>                                                                                        '.
       '    </div>                                                                                            '.
       '</section>                                                                                            ';
    }

    /**
     * @return string
     */
    public function getImageSource(): string {
        if($this->blobData == null) {
            return "../resources/images/events/event.jpg";
        } else {
            return "data:".$this->blobData[0].";base64,".base64_encode($this->blobData[1]);

        }

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
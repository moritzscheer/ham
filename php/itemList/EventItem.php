<?php

class EventItem implements Item
{

    private string $image;
    private string $id, $authorId ,$type, $description, $name, $street, $city, $date, $startTime, $endTime, $requirements = "";
    private int $houseNr, $postalCode = -1;

    /*public function __construct()
    {
        $image = new object();
    }*/
    /**
     * @param string $image
     * @param string $id
     * @param string $type
     * @param string $description
     * @param string $name
     * @param string $street
     * @param string $city
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @param string $requirements
     * @param int $houseNr
     * @param int $postalCode
     */
    /*public function __construct(string $image, string $type, string $description, string $name, string $street, string $city, string $date, string $startTime, string $endTime, string $requirements, int $houseNr, int $postalCode)
    {
        if($image == null){
            $image = new object();
        }
        $this->image = $image;
        $this->id = $this->createID();
        $this->type = $type;
        $this->description = $description;
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->requirements = $requirements;
        $this->houseNr = $houseNr;
        $this->postalCode = $postalCode;

    }*/

    public function __construct(object $item)
    {
        (isset($item->id) && is_string($item->id)) ? $this->id = $item->id : $this->id = $this->createID();
        $this->authorId = $item->authorID;
        $this->image = $item->image;
        $this->type = $item->type;
        $this->description = $item->description;
        $this->name = $item->name;
        $this->street = $item->street;
        $this->city = $item->city;
        $this->date = $item->Date;
        $this->startTime = $item->startTime;
        $this->endTime = $item->endTime;
        $this->requirements = $item->requirements;
        $this->houseNr = $item->houseNr;
        $this->postalCode = $item->postalCode;
    }


    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param object $image_data
     */
    public function setImage($image_data): void
    {
        if (is_string($image_data)) {
            empty($this->image);
            $this->image = (string)$image_data;
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * @param string $startTime
     */
    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return string
     */
    public function getEndTime(): string
    {
        return $this->endTime;
    }

    /**
     * @param string $endTime
     */
    public function setEndTime(string $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return string
     */
    public function getRequirements(): string
    {
        return $this->requirements;
    }

    /**
     * @param string $requirements
     */
    public function setRequirements(string $requirements): void
    {
        $this->requirements = $requirements;
    }

    /**
     * @return int
     */
    public function getHouseNr(): int
    {
        return $this->houseNr;
    }

    /**
     * @param int $houseNr
     */
    public function setHouseNr(int $houseNr): void
    {
        $this->houseNr = $houseNr;
    }

    /**
     * @return int
     */
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    /**
     * @param int $postalCode
     */
    public function setPostalCode(int $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Converts an Eventitem object to an array for writing to a json-file
     * @return array
     */
    public function toJsonArray(): array
    {
        return array(
            "image" => $this->image,
            "id" => $this->id,
            "type" => $this->type,
            "description" => $this->description,
            "name" => $this->name,
            "street" => $this->street,
            "houseNr" => $this->houseNr,
            "postalCode" => $this->postalCode,
            "city" => $this->city,
            "Date" => $this->date,
            "startTime" => $this->startTime,
            "endTime" => $this->endTime,
            "requirements" => $this->requirements

        );
    }

    /**
     * creates an id for an event
     * @return string ID of an event
     */
    private function createID(): string
    {
        //todo: implement method
        return "";
    }

}
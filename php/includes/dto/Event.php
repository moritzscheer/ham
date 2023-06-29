<?php

//namespace Item;
class event
{

    // event attributes
    private ?int $event_id = null;
    private ?string $address_id = "";
    private ?int $user_id = null;
    private ?string $name = "";
    private ?string $description = "";
    private ?string $requirements = "";
    private ?string $date = "";
    private ?string $starttime = "";
    private ?string $endtime = "";

    // address attributes
    private ?string $street_name = "";
    private ?string $house_number = "";
    private ?string $postal_code = "";
    private ?string $city = "";

    // image attributes
    private ?array $blobdata = null;

    /**
     * @param array $item
     * @return event
     */
    public static function withaddress(array $item): event
    {
        $instance = new self();
        $instance->event_id = $item["event_id"];
        $instance->address_id = $item["address_id"];
        $instance->user_id = $item["user_id"];
        $instance->name = $item["name"];
        $instance->description = $item["description"];
        $instance->requirements = $item["requirements"];
        $instance->date = $item["date"];
        $instance->starttime = $item["starttime"];
        $instance->endtime = $item["endtime"];
        $instance->street_name = $item["street_name"];
        $instance->house_number = $item["house_number"];
        $instance->postal_code = $item["postal_code"];
        $instance->city = $item["city"];
        return $instance;
    }

    public static function getjsonevent($item): event
    {
        $instance = new self();
        $instance->event_id = (int)$item->id;
        $instance->address_id = $item->address_id;
        $instance->user_id = (int)$item->authorid;
        $instance->name = $item->name;
        $instance->description = $item->description;
        $instance->requirements = $item->requirements;
        $instance->date = $item->date;
        $instance->starttime = $item->starttime;
        $instance->endtime = $item->endtime;
        $instance->street_name = $item->street;
        $instance->house_number = $item->housenr;
        $instance->postal_code = $item->postalcode;
        $instance->city = $item->city;
        return $instance;
    }

    public static function toarrayforjsonentry(event $item): array
    {
        $jsonevent = array(
            "image" => $item->getimagesource(),
            "id" => uniqid('ev_'),
            "authorid" => $item->getuserid(),
            "type" => "event",
            "description" => $item->getdescription(),
            "name" => $item->getname(),
            "address_id" => $item->getaddressid(),
            "street" => $item->getstreetname(),
            "housenr" => $item->gethousenumber(),
            "postalcode" => $item->getpostalcode(),
            "city" => $item->getcity(),
            "date" => $item->getdate(),
            "starttime" => $item->getstarttime(),
            "endtime" => $item->getendtime(),
            "requirements" => $item->getrequirements()
        );
        return $jsonevent;
    }

    public function geteventhtml(): string
    {
        return $string =
            '    <form method="post" name="event_id" id="item">                                                    ' .
            '        <div id="item_image">                                                                         ' .
            '            <img src="' . $this->getimagesource() . '" alt="bandimage"/>                              ' .
            '        </div>                                                                                        ' .
            '        <div id="item_short_description" class="text-line-pre">                                       ' .
            '            <span>' . $this->name . '</span>                                                          ' .
            '            <br>                                                                                      ' .
            '            <span>dto\address: ' . $this->getaddressattributes("value", "list") . '</span>   ' .
            '            <br>                                                                                      ' .
            '            <span> ' . $this->gettime() . '</span>                                                    ' .
            '        </div>                                                                                        ' .
            '        <label>click to display more / less                                                           ' .
            '             <input type="submit" name="onitemclick" value="' . $this->event_id . '">                 ' .
            '        </label>                                                                                      ' .
            '    </form>                                                                                           ';
    }

    //todo: fix line 120 to 127 with ajax ?
    public function geteditableeventhtml(): string
    {
        return $string =
            '    <form method="post" name="event_id" id="item">                                                    ' .
            '        <div id="item_image">                                                                         ' .
            '            <img src="' . $this->getimagesource() . '" alt="bandimage"/>                              ' .
            '        </div>                                                                                        ' .
            '        <div id="item_editable">                                                                      ' .
            '             <label>edit                                                                              ' .
            '                   <a href="createevent.php"  name="onedit" ></a>                                     ' .
            '                   <input type="submit" name="onedit" value="' . $this->event_id . '">                ' .
            '             </label>                                                                                 ' .
            '             <label>delete                                                                            ' .
            '                   <a href="events.php"  name="ondelete" ></a>                                        ' .
            '                   <input type="submit" name="ondelete" value="' . $this->event_id . '">              ' .
            '              </label>                                                                                ' .
            '        </div>                                                                                        ' .
            '        <div id="item_short_description" class="text-line-pre">                                       ' .
            '            <span>' . $this->name . '</span>                                                          ' .
            '            <br>                                                                                      ' .
            '            <span>dto\address: ' . $this->getaddressattributes("value", "list") . '</span>   ' .
            '            <br>                                                                                      ' .
            '            <span> ' . $this->gettime() . '</span>                                                    ' .
            '        </div>                                                                                        ' .
            '        <label>click to display more / less                                                           ' .
            '             <input type="submit" name="onitemclick" value="' . $this->event_id . '">                 ' .
            '        </label>                                                                                      ' .
            '    </form>                                                                                           ';

    }

    /**
     * @return string
     */
    public function getimagesource(): string
    {
        if (empty($this->blobdata)) {
            return "../resources/images/events/event.jpg";
        } else {
            return "data:" . $this->blobdata["mime"] . ";base64," . base64_encode($this->blobdata["data"]);
        }
    }

    /**
     * @return string
     */
    public function gettime(): string
    {
        return $this->starttime . " - " . $this->endtime;
    }

    /**
     * returns a string containing all attributes of the user class defined in user table that are not null.
     * the string is formatted according to the $schema variable
     * @param $keyorvalue
     * @param $schema
     * @return string
     */
    public function getattributes($keyorvalue, $schema): string
    {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key !== "street_name" && $key !== "house_number" && $key !== "postal_code" && $key !== "city" && $key !== "blobdata") {
                $result = $this->concatstring($result, $key, $value, $keyorvalue, $schema);
            }
        }
        return $result;
    }

    /**
     * returns a string containing all attributes of the user class defined in address table that are not null.
     * the string is formatted according to the $schema variable
     * @param $keyorvalue
     * @param $schema
     * @return string
     */
    public function getaddressattributes($keyorvalue, $schema): string
    {
        $result = "";
        foreach ($this as $key => $value) {
            if ($key === "street_name" || $key === "house_number" || $key === "postal_code" || $key === "city") {
                $result = $this->concatstring($result, $key, $value, $keyorvalue, $schema);
            }
        }
        return $result;
    }

    /**
     * @param $result
     * @param $value
     * @param $keyorvalue
     * @param $schema
     * @return string
     */
    private function concatstring($result, $key, $value, $keyorvalue, $schema): string
    {
        $attr = $keyorvalue === "value" ? $value : ($keyorvalue === "valuewithapo" ? "'" . $value . "'" : $key);

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
     * @param int $user_id
     */
    public function setuserid(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getuserid(): int
    {
        return $this->user_id;
    }

    /**
     * @return string|null
     */
    public function getstreetname(): ?string
    {
        return $this->street_name;
    }

    /**
     * @param string|null $street_name
     */
    public function setstreetname(?string $street_name): void
    {
        $this->street_name = $street_name;
    }

    /**
     * @return array|null
     */
    public function getblobdata(): ?array
    {
        return $this->blobdata;
    }

    /**
     * @param array|null $blobdata
     */
    public function setblobdata(?array $blobdata): void
    {
        $this->blobdata = $blobdata;
    }

    /**
     * @return string|null
     */
    public function getaddressid(): ?string
    {
        return $this->address_id;
    }

    /**
     * @param string|null $address_id
     */
    public function setaddressid(?string $address_id): void
    {
        $this->address_id = $address_id;
    }

    /**
     * @return string|null
     */
    public function getname(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setname(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getdescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setdescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getrequirements(): ?string
    {
        return $this->requirements;
    }

    /**
     * @param string|null $requirements
     */
    public function setrequirements(?string $requirements): void
    {
        $this->requirements = $requirements;
    }

    /**
     * @return string|null
     */
    public function getdate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     */
    public function setdate(?string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string|null
     */
    public function getstarttime(): ?string
    {
        return $this->starttime;
    }

    /**
     * @param string|null $starttime
     */
    public function setstarttime(?string $starttime): void
    {
        $this->starttime = $starttime;
    }

    /**
     * @return string|null
     */
    public function getendtime(): ?string
    {
        return $this->endtime;
    }

    /**
     * @param string|null $endtime
     */
    public function setendtime(?string $endtime): void
    {
        $this->endtime = $endtime;
    }

    /**
     * @return string|null
     */
    public function gethousenumber(): ?string
    {
        return $this->house_number;
    }

    /**
     * @param string|null $house_number
     */
    public function sethousenumber(?string $house_number): void
    {
        $this->house_number = $house_number;
    }

    /**
     * @return string|null
     */
    public function getpostalcode(): ?string
    {
        return $this->postal_code;
    }

    /**
     * @param string|null $postal_code
     */
    public function setpostalcode(?string $postal_code): void
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return string|null
     */
    public function getcity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setcity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return int|null
     */
    public function geteventid(): ?int
    {
        return $this->event_id;
    }


}
<?php

class Address {
    private string $address_ID;
    private ?string $street_name;
    private ?string $house_number;
    private ?string $postal_code;
    private ?string $city;

    public function __construct() {
        $this->street_name = "";
        $this->house_number = "";
        $this->postal_code = "";
        $this->city = "";
    }


        /**
     * constructor
     * @param $address
     */
    public static function withAddressID($address): Address {
        $instance = new self();
        $instance->address_ID = $address->address_ID;
        $instance->street_name = $address->street_name;
        $instance->house_number = $address->house_number;
        $instance->postal_code = $address->postal_code;
        $instance->city = $address->city;
        return $instance;
    }

    /**
     * @return string
     */
    public function getAddressID(): string
    {
        return $this->address_ID;
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

}
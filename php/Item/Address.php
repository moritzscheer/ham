<?php

class Address
{
    private string $id, $street, $houseNr, $postalCode, $city;

    public function __construct($address)
    {
        $this->id = $address->id;
        $this->street = $address->street;
        $this->houseNr = $address->houseNr;
        $this->postalCode = $address->postalCode;
        $this->city = $address->city;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouseNr(): string
    {
        return $this->houseNr;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

}
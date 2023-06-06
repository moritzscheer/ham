<?php

class BandItem implements Item
{
    private object $image;
    private string $id, $name, $type, $genre, $costs, $region, $email;
    private $members, $links = array();

    /**
     * @param object $image
     * @param string $id
     * @param string $name
     * @param string $type
     * @param string $genre
     * @param string $costs
     * @param string $region
     * @param string $email
     * @param $members
     * @param array $links
     */
    public function __construct(object $image, string $id, string $name, string $type, string $genre, string $costs, string $region, string $email, $members, array $links)
    {
        $this->image = $image;
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->genre = $genre;
        $this->costs = $costs;
        $this->region = $region;
        $this->email = $email;
        $this->members = $members;
        $this->links = $links;
    }

    //https://www.amitmerchant.com/multiple-constructors-php/


    /**
     * @return object
     */
    public function getImage(): object
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @return string
     */
    public function getCosts(): string
    {
        return $this->costs;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }


}
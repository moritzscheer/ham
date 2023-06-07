<?php

class Band implements Item
{
    private string $image;
    private string $id, $name, $genre, $costs, $region, $email;
    private $members, $links = array();

    /**
     * @param object $image
     * @param string $id
     * @param string $name
     * @param string $genre
     * @param string $costs
     * @param string $region
     * @param string $email
     * @param $members
     * @param array $links
     */
    /*public function __construct(string $image, string $id, string $name, string $genre, string $costs, string $region, string $email, $members, array $links)
    {
        $this->image = $image;
        $this->id = $id;
        $this->name = $name;
        $this->genre = $genre;
        $this->costs = $costs;
        $this->region = $region;
        $this->email = $email;
        $this->members = $members;
        $this->links = $links;
    }*/


    public function __construct(object $item){
        $this->image = $item->image;
        $this->id = $item->id;
        $this->name = $item->name;
        $this->genre = $item->genre;
        $this->costs = $item->costs;
        $this->region = $item->region;
        $this->email = $item->email;
        $this->members = $item->members;
        $this->links = $item->links;
    }

    /**
     * @return object
     */
    public function getImage(): string
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

    /**
     * @return array for writing to a json file
     */
    public function toJsonArray(): array
    {
        return array(
            "image" => $this->image,
            "id" => $this->id,
            "name" => $this->name,
            "genre" => $this->genre,
            "members" => $this->members,
            "costs" => $this->costs,
            "region" => $this->region,
            "email" => $this->email,
            "links" => $this->links
        );
    }

}
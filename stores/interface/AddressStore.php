<?php
include_once "../stores/Store.php";

interface AddressStore extends Store {
    public function create(Address $item): Address;
    public function update(Address $item): Address;
    public function findOne(string $id): Address;
}
<?php
include_once "../stores/interface/Store.php";

interface AddressStore extends Store {
    public function create(object $item): string;
    public function update(object $item): string;
    public function findOne(string $id): array;
}
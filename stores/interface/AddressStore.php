<?php

namespace stores\interface;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/Store.php';

interface AddressStore extends Store
{
    public function create(object $item): string|false;
    public function update(object $item): string;
    public function delete(string $id): void;
    public function findOne(object $item): mixed;
}
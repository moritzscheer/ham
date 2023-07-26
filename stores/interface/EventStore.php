<?php

namespace stores\interface;

use php\includes\items\Event;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/Store.php';

interface EventStore extends Store {
    public function create(Event $event): Event;
    public function update(Event $event): Event;
    public function findOne(string $id): Event;
    public function findAny(string $stmt) : array;
    public function findMy(string $user_ID) : array;
    public function findAll() : array;
}
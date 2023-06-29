<?php

use Item\Event;

include_once "../stores/interface/Store.php";

interface EventStore extends Store {
    public function create(Event $item): Event;
    public function update(Event $item): Event;
    public function findOne(string $id): Event;
}
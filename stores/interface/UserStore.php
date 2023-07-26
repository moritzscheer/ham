<?php

namespace stores\interface;

use php\includes\items\User;

include_once $_SERVER['DOCUMENT_ROOT'].'/stores/interface/Store.php';

interface UserStore extends Store {
    public function create(User $user): User;
    public function update(User $user): User;
    public function delete(string $id);
    public function findOne(string $id);
    public function findAny(string $stmt): array;
    public function findAll(): array;
}
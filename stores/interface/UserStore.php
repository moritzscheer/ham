<?php
include_once "../stores/Store.php";


interface UserStore extends Store {
    public function create(User $user): User;
    public function update(User $user): User;
    public function delete(string $user_ID);
    public function findOne(string $user_ID);
}